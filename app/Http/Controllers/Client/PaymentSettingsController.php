<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment\PaymentMethod;
use App\Models\Client\CustomerPaymentPreference;

class PaymentSettingsController extends Controller
{
    // ---------------
    // Show payment settings form
    // ---------------
    public function edit()
    {
        $user = auth()->user();

        // Fetch all active payment methods
        $methods = PaymentMethod::active()
            ->orderBy('name')
            ->get(['id', 'name']);

        // Fetch current preference (if any)
        $currentPreference = CustomerPaymentPreference::where('user_id', $user->id)
            ->with('paymentMethod')
            ->first();

        return view('client.payment-settings.index', compact('methods', 'currentPreference'));
    }

    // ---------------
    // Update preferred payment method
    // ---------------
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'preferred_method_id' => 'required|exists:su_payment_methods,id',
        ]);

        // Update or create preference
        CustomerPaymentPreference::updateOrCreate(
            ['user_id' => $user->id],
            ['payment_method_id' => $request->preferred_method_id]
        );

        return redirect()
            ->route('client.settings.payment')
            ->with('success', 'Your preferred payment method has been saved.');
    }
}