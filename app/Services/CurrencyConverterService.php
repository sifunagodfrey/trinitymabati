<?php

namespace App\Services;

class CurrencyConverterService
{
    // ---------------
    // The store trades in a single currency, KES
    // ---------------
    public function getActiveCurrency(): string
    {
        return 'KES';
    }

    // ---------------
    // Kept for call sites that render a currency switcher
    // ---------------
    public function getAvailableCurrencies(): array
    {
        return [['code' => 'KES', 'symbol' => 'KSh']];
    }

    public function getRate(string $currency): float
    {
        return 1.0;
    }

    public function getSymbol(string $currency): string
    {
        return 'KSh';
    }

    // ---------------
    // No conversion happens, the amount is already in KES
    // ---------------
    public function convert(float $amount, ?string $currency = null): float
    {
        return $amount;
    }

    public function format(float $amount, ?string $currency = null): string
    {
        return 'KSh ' . number_format($amount, 0);
    }
}
