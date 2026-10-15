<?php

namespace Tests\Feature;

use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Payments\PaymentMethod;
use App\Models\Payment\PaymentTransaction;
use App\Services\ManualPaymentService;
use App\Services\StockService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

// Run against the migrated application test database.
class ManualPaymentReviewTest extends TestCase
{
    use DatabaseTransactions;

    private int $userId;
    private PaymentMethod $method;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userId = DB::table('su_users')->insertGetId([
            'first_name' => 'Payment Test', 'last_name' => 'Customer',
            'email' => Str::uuid() . '@example.test', 'password' => bcrypt('test-password'),
        ]);
        $this->method = PaymentMethod::create([
            'name' => 'Test Manual Paybill', 'slug' => 'test-' . Str::uuid(),
            'is_manual' => true, 'is_active' => true,
            'config' => ['paybill' => '999999', 'account_number' => 'TEST-ACCOUNT', 'account_name' => 'Test Account'],
        ]);
    }

    private function newOrder(): Order
    {
        return Order::create([
            'user_id' => $this->userId, 'order_code' => 'TEST' . str_replace('-', '', Str::uuid()),
            'status' => 'pending', 'payment_status' => 'pending', 'shipping_status' => 'pending',
            'total' => '1500.00', 'shipping_cost' => '0.00', 'currency' => 'KES', 'stock_deducted' => 0,
        ]);
    }

    private function submit(Order $order, ?string $reference): PaymentTransaction
    {
        return DB::transaction(fn () => app(ManualPaymentService::class)->submit($order, $this->method, $reference, null));
    }

    public function test_submission_stays_pending_and_preserves_payment_instructions(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, ' ref-1000 ');
        $this->assertSame('pending', $payment->status);
        $this->assertSame('REF-1000', $payment->manual_reference);
        $this->assertSame('pending', $order->fresh()->payment_status);
        $this->assertSame(0, (int) $order->fresh()->stock_deducted);
        $this->method->update(['config' => ['paybill' => '111111', 'account_number' => 'OTHER', 'account_name' => 'Changed']]);
        $this->assertSame('999999', $payment->fresh()->payment_details['paybill']);
    }

    public function test_approval_is_idempotent_and_deducts_stock_once(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, 'REF-APPROVE');
        $stock = Mockery::mock(StockService::class);
        $stock->shouldReceive('deductForOrder')->once()->andReturnUsing(function ($order) {
            DB::table('su_orders')->where('id', $order->id)->update(['stock_deducted' => 1]);
        });
        $this->app->instance(StockService::class, $stock);
        $first = app(ManualPaymentService::class)->review($payment->id, $this->userId, true, 'Verified in statement');
        $second = app(ManualPaymentService::class)->review($payment->id, $this->userId, true, 'Second click');
        $this->assertTrue($first['changed']);
        $this->assertFalse($second['changed']);
        $this->assertSame('successful', $payment->fresh()->status);
        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('processing', $order->fresh()->status);
        $this->assertSame($this->userId, (int) $payment->fresh()->reviewed_by);
        $this->assertSame(1, DB::table('su_payment_logs')->where('payment_id', $payment->id)->where('status', 'manual_approved')->count());
    }

    public function test_rejected_reference_can_be_corrected_and_resubmitted_with_audit_history(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, 'REF-RETRY');
        app(ManualPaymentService::class)->review($payment->id, $this->userId, false, 'Please provide clearer proof');
        $this->assertSame('failed', $order->fresh()->payment_status);
        $resubmitted = $this->submit($order->fresh(), 'REF-RETRY');
        $this->assertSame($payment->id, $resubmitted->id);
        $this->assertSame('pending', $resubmitted->status);
        $this->assertNull($resubmitted->reviewed_at);
        $this->assertSame(1, DB::table('su_payment_logs')->where('payment_id', $payment->id)->where('status', 'manual_rejected')->count());
        $this->assertSame(2, DB::table('su_payment_logs')->where('payment_id', $payment->id)->where('status', 'manual_submitted')->count());
    }

    public function test_reference_cannot_be_reused_for_a_different_order(): void
    {
        $this->submit($this->newOrder(), 'REF-UNIQUE');
        $this->expectException(ValidationException::class);
        $this->submit($this->newOrder(), 'ref-unique');
    }

    public function test_disabled_payment_method_cannot_accept_a_submission(): void
    {
        $this->method->update(['is_active' => false]);
        $this->expectException(ValidationException::class);
        $this->submit($this->newOrder(), 'REF-DISABLED');
    }

    public function test_unconfigured_payment_method_cannot_accept_a_submission(): void
    {
        $this->method->update(['config' => ['paybill' => '', 'account_number' => '', 'account_name' => '']]);
        $this->expectException(ValidationException::class);
        $this->submit($this->newOrder(), 'REF-UNCONFIGURED');
    }

    public function test_mismatched_order_total_cannot_be_approved(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, 'REF-AMOUNT');
        $order->update(['total' => '1600.00']);
        try {
            app(ManualPaymentService::class)->review($payment->id, $this->userId, true, null);
            $this->fail('Mismatched payment was approved.');
        } catch (ValidationException $exception) {
            $this->assertSame('pending', $payment->fresh()->status);
            $this->assertSame('pending', $order->fresh()->payment_status);
        }
    }

    public function test_cancelled_order_cannot_be_approved(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, 'REF-CANCELLED');
        $order->update(['status' => 'cancelled']);
        $this->expectException(ValidationException::class);
        app(ManualPaymentService::class)->review($payment->id, $this->userId, true, null);
    }

    public function test_inventory_failure_rolls_back_payment_approval(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, 'REF-STOCK-FAIL');
        $stock = Mockery::mock(StockService::class);
        $stock->shouldReceive('deductForOrder')->once()->andReturnNull();
        $this->app->instance(StockService::class, $stock);
        try {
            app(ManualPaymentService::class)->review($payment->id, $this->userId, true, null);
            $this->fail('Payment approval persisted without inventory update.');
        } catch (ValidationException $exception) {
            $this->assertSame('pending', $payment->fresh()->status);
            $this->assertSame('pending', $order->fresh()->payment_status);
            $this->assertNull($payment->fresh()->reviewed_by);
        }
    }

    public function test_gateway_helper_cannot_mark_a_manual_payment_successful(): void
    {
        $payment = $this->submit($this->newOrder(), 'REF-NO-GATEWAY');
        $this->expectException(\LogicException::class);
        $payment->markSuccessful('UNVERIFIED');
    }

    public function test_multiple_orders_can_submit_without_references_and_stay_manual(): void
    {
        $first = $this->submit($this->newOrder(), null);
        $second = $this->submit($this->newOrder(), '   ');
        $this->assertNull($first->manual_reference);
        $this->assertNull($second->manual_reference);
        $this->assertTrue($first->is_manual);
        $this->assertTrue($second->is_manual);
        $this->assertSame('pending', $first->status);
        $this->assertSame('pending', $second->status);
    }

    public function test_reference_free_payment_can_be_rejected_and_resubmitted(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, null);
        app(ManualPaymentService::class)->review($payment->id, $this->userId, false, 'Please confirm the transfer');
        $retry = $this->submit($order->fresh(), null);
        $this->assertSame($payment->id, $retry->id);
        $this->assertTrue($retry->is_manual);
        $this->assertSame('pending', $retry->status);
    }

    public function test_reference_free_manual_payment_can_be_approved(): void
    {
        $order = $this->newOrder();
        $payment = $this->submit($order, null);
        $stock = Mockery::mock(StockService::class);
        $stock->shouldReceive('deductForOrder')->once()->andReturnUsing(function ($order) {
            DB::table('su_orders')->where('id', $order->id)->update(['stock_deducted' => 1]);
        });
        $this->app->instance(StockService::class, $stock);
        $result = app(ManualPaymentService::class)->review($payment->id, $this->userId, true, 'Verified in bank records');
        $this->assertTrue($result['changed']);
        $this->assertTrue($payment->fresh()->is_manual);
        $this->assertNull($payment->fresh()->manual_reference);
        $this->assertSame('successful', $payment->fresh()->status);
        $this->assertSame('paid', $order->fresh()->payment_status);
    }
}
