<?php

namespace Tests\Unit;

use App\Services\StockAvailability;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class StockAvailabilityTest extends TestCase
{
    public function test_blank_quantities_are_available_but_explicit_zero_is_not(): void
    {
        foreach ([null, '', '  ', 5, '5'] as $quantity) {
            $this->assertTrue(StockAvailability::isAvailable($quantity));
        }
        foreach ([0, '0', -1] as $quantity) {
            $this->assertFalse(StockAvailability::isAvailable($quantity));
        }
    }

    public function test_a_single_untracked_variant_keeps_the_product_available(): void
    {
        $product = (object) ['is_variant' => true, 'stock_quantity' => 0, 'variants' => new Collection([
            (object) ['stock_quantity' => 0], (object) ['stock_quantity' => null],
        ])];
        $this->assertNull(StockAvailability::forProduct($product));
        $this->assertTrue(StockAvailability::isAvailable(StockAvailability::forProduct($product)));
    }

    public function test_tracked_variant_totals_preserve_sold_out_and_finite_stock(): void
    {
        $product = (object) ['is_variant' => true, 'stock_quantity' => null, 'variants' => new Collection([
            (object) ['stock_quantity' => 0], (object) ['stock_quantity' => 0],
        ])];
        $this->assertSame(0, StockAvailability::forProduct($product));
        $this->assertFalse(StockAvailability::isAvailable(StockAvailability::forProduct($product)));
        $product->variants->push((object) ['stock_quantity' => 7]);
        $this->assertSame(7, StockAvailability::forProduct($product));
    }

    public function test_simple_products_do_not_inherit_variant_stock(): void
    {
        $product = (object) ['is_variant' => false, 'stock_quantity' => '', 'variants' => new Collection()];
        $this->assertNull(StockAvailability::forProduct($product));
        $product->stock_quantity = '0';
        $this->assertSame(0, StockAvailability::forProduct($product));
    }
}
