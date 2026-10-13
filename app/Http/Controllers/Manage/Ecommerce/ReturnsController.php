<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Ecommerce\StoreReturnRequest;
use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Ecommerce\OrderReturn;
use App\Services\ClientEmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnsController extends Controller
{
    public function __construct(private ClientEmailService $emailService) {}

    // ---------------
    // Show form to initiate a new return
    // ---------------
    public function create(): View
    {
        return view('manage.ecommerce.returns.create');
    }

    // ---------------
    // Return order details + items as JSON for a given order code
    // ---------------
    public function orderItems(Request $request): JsonResponse
    {
        $order = Order::with(['user', 'items'])
            ->where('order_code', trim($request->order_code))
            ->first();

        if (! $order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'order'    => [
                'id'         => $order->id,
                'order_code' => $order->order_code,
            ],
            'customer' => [
                'id'    => optional($order->user)->id,
                'name'  => optional($order->user)->first_name . ' ' . optional($order->user)->last_name,
                'email' => optional($order->user)->email,
            ],
            'items' => $order->items->map(fn ($item) => [
                'product_id'    => $item->product_id,
                'product_name'  => $item->product_name,
                'variant_label' => $item->variant_label,
                'quantity'      => $item->quantity,
            ])->values(),
        ]);
    }

    // ---------------
    // Store a new admin-initiated return and notify the customer
    // ---------------
    public function store(StoreReturnRequest $request): RedirectResponse
    {
        $return = OrderReturn::create([
            'order_id'   => $request->order_id,
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'reason'     => $request->reason,
            'status'     => $request->status,
        ]);

        $return->load(['user', 'order', 'product']);

        try {
            match ($return->status) {
                'requested' => $this->emailService->sendReturnRequested($return->user, $return, $return->order, $return->product),
                'approved'  => $this->emailService->sendReturnApproved($return->user, $return, $return->order, $return->product),
                'rejected'  => $this->emailService->sendReturnRejected($return->user, $return, $return->order, $return->product),
                'refunded'  => $this->emailService->sendReturnRefunded($return->user, $return, $return->order, $return->product),
                default     => null,
            };
        } catch (\Throwable $e) {
            return redirect()->route('manage.ecommerce.returns.index')
                ->with('success', 'Return request created successfully.')
                ->with('warning', 'Notification email failed: ' . $e->getMessage());
        }

        return redirect()->route('manage.ecommerce.returns.index')
            ->with('success', 'Return request created and customer notified.');
    }

    // ---------------
    // List all return requests with search and status filter
    // ---------------
    public function index(): View
    {
        $query = OrderReturn::with(['order', 'user'])
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->whereHas('order', fn ($o) => $o->where('order_code', 'like', "%{$search}%"));
            })
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $returns = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.returns.index', compact('returns'));
    }

    // ---------------
    // Single return request detail with related order items
    // ---------------
    public function show(string $id): View
    {
        $return = OrderReturn::with(['order.items', 'order.user', 'user', 'product'])
            ->findOrFail($id);

        return view('manage.ecommerce.returns.show', compact('return'));
    }

    // ---------------
    // Approve a return request and notify the customer
    // ---------------
    public function approve(string $id): RedirectResponse
    {
        $return = OrderReturn::with(['user', 'order', 'product'])->findOrFail($id);

        if ($return->status !== 'requested') {
            return redirect()->back()->with('error', 'Only returns in "Requested" status can be approved.');
        }

        $return->update(['status' => 'approved']);

        try {
            $this->emailService->sendReturnApproved($return->user, $return, $return->order, $return->product);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('success', 'Return approved.')
                ->with('warning', 'Notification email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Return approved and customer notified.');
    }

    // ---------------
    // Reject a return request and notify the customer
    // ---------------
    public function reject(string $id): RedirectResponse
    {
        $return = OrderReturn::with(['user', 'order', 'product'])->findOrFail($id);

        if ($return->status !== 'requested') {
            return redirect()->back()->with('error', 'Only returns in "Requested" status can be rejected.');
        }

        $return->update(['status' => 'rejected']);

        try {
            $this->emailService->sendReturnRejected($return->user, $return, $return->order, $return->product);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('success', 'Return rejected.')
                ->with('warning', 'Notification email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Return rejected and customer notified.');
    }

    // ---------------
    // Mark an approved return as refunded and notify the customer
    // ---------------
    public function refund(string $id): RedirectResponse
    {
        $return = OrderReturn::with(['user', 'order', 'product'])->findOrFail($id);

        if ($return->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved returns can be marked as refunded.');
        }

        $return->update(['status' => 'refunded']);

        try {
            $this->emailService->sendReturnRefunded($return->user, $return, $return->order, $return->product);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('success', 'Return marked as refunded.')
                ->with('warning', 'Notification email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Refund confirmed and customer notified.');
    }
}
