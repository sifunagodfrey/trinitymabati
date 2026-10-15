<?php

namespace App\Http\Controllers\Manage\Payments;

use App\Http\Controllers\Controller;
use App\Models\Manage\Payments\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MethodsController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::manual()->orderBy('id')->get();
        return view('manage.payments.methods.index', compact('methods'));
    }

    public function edit($id)
    {
        $method = PaymentMethod::manual()->findOrFail($id);
        return view('manage.payments.methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::manual()->findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'bank_name' => ['nullable', 'string', 'max:160'],
            'paybill' => ['nullable', 'string', 'regex:/^[0-9]{5,10}$/'],
            'account_number' => ['nullable', 'string', 'max:100'],
            'account_name' => ['nullable', 'string', 'max:160'],
            'instructions' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
        ]);
        $config = [];
        foreach (['bank_name', 'paybill', 'account_number', 'account_name', 'instructions'] as $key) {
            $config[$key] = trim((string) ($data[$key] ?? ''));
        }
        $method->fill(['name' => trim($data['name']), 'description' => $data['description'] ?? null, 'config' => $config]);
        $method->is_default = $request->boolean('is_default');
        $method->is_active = $request->boolean('is_active') || $method->is_default;
        if ($method->is_active && !$method->isConfigured()) {
            throw ValidationException::withMessages(['paybill' => 'Enter the paybill, account number and account name before enabling this option.']);
        }
        DB::transaction(function () use ($method) {
            if ($method->is_default) PaymentMethod::manual()->where('id', '!=', $method->id)->update(['is_default' => false]);
            $method->save();
        });
        return redirect()->route('manage.payments.methods.index')->with('success', 'Manual payment option updated.');
    }

    public function toggleStatus($id)
    {
        $method = PaymentMethod::manual()->findOrFail($id);
        if (!$method->is_active && !$method->isConfigured()) {
            return back()->with('error', 'Configure the paybill, account number and account name before enabling this option.');
        }
        $method->update(['is_active' => !$method->is_active, 'is_default' => $method->is_active ? false : $method->is_default]);
        return back()->with('success', 'Payment option status updated.');
    }
}
