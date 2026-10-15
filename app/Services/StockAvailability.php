<?php

namespace App\Services;

class StockAvailability
{
    public static function normalize($quantity): ?int
    {
        return $quantity === null || (is_string($quantity) && trim($quantity) === '')
            ? null : (int) $quantity;
    }

    public static function isAvailable($quantity): bool
    {
        $quantity = self::normalize($quantity);
        return $quantity === null || $quantity > 0;
    }

    public static function forProduct($product): ?int
    {
        if ($product->is_variant && $product->variants->isNotEmpty()) {
            $total = 0;
            foreach ($product->variants as $variant) {
                $quantity = self::normalize($variant->stock_quantity);
                // One available variant with no stock limit makes the total unbounded.
                if ($quantity === null) return null;
                $total += $quantity;
            }
            return $total;
        }
        return self::normalize($product->stock_quantity);
    }
}
