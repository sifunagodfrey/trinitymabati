<?php

namespace App\Http\Controllers\Manage\Payments;

use App\Http\Controllers\Controller;
use App\Models\Manage\Payments\PaymentMethod;
use Illuminate\Http\Request;

class MethodsController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::orderBy('id')->get();
        return view('manage.payments.methods.index', compact('methods'));
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return view('manage.payments.methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'is_default'  => 'boolean',
            'config'      => 'nullable|json',
            'user_input_label'       => 'nullable|string|max:255',
            'user_input_description' => 'nullable|string',
            'thumbnail'   => 'nullable|string|max:255',
        ]);

        $data['is_default'] = $request->boolean('is_default');

        // A default method must be active, and only one method can be default.
        if ($data['is_default']) {
            $data['is_active'] = true;
            PaymentMethod::where('id', '!=', $method->id)->update(['is_default' => false]);
        }

        $method->update($data);

        return redirect()->route('manage.payments.methods.index')
            ->with('success', 'Payment method updated.');
    }

    public function toggleStatus($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $newActive = ! $method->is_active;
        $method->update([
            'is_active'  => $newActive,
            'is_default' => $newActive ? $method->is_default : false,
        ]);

        return redirect()->route('manage.payments.methods.index')
            ->with('success', 'Status toggled.');
    }
}