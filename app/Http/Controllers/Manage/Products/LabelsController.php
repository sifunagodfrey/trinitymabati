<?php

namespace App\Http\Controllers\Manage\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Products\StoreLabelRequest;
use App\Http\Requests\Manage\Products\UpdateLabelRequest;
use App\Models\Manage\Products\Label;

class LabelsController extends Controller
{
    // ---------------
    // List All Labels
    // ---------------
    public function index()
    {
        $labels = Label::withCount('products')
            ->orderBy('name')
            ->paginate(20);

        return view('manage.products.labels.index', compact('labels'));
    }

    // ---------------
    // Show Create Form
    // ---------------
    public function create()
    {
        return view('manage.products.labels.create');
    }

    // ---------------
    // Store New Label
    // ---------------
    public function store(StoreLabelRequest $request)
    {
        Label::create([
            'name'        => $request->name,
            'color_code'  => $request->color_code,
            'description' => $request->description,
        ]);

        return redirect()->route('manage.products.labels.index')
            ->with('success', 'Label "' . $request->name . '" created successfully.');
    }

    // ---------------
    // Show Edit Form
    // ---------------
    public function edit(string $id)
    {
        $label = Label::findOrFail($id);

        return view('manage.products.labels.edit', compact('label'));
    }

    // ---------------
    // Update Label
    // ---------------
    public function update(UpdateLabelRequest $request, string $id)
    {
        $label = Label::findOrFail($id);

        $label->update([
            'name'        => $request->name,
            'color_code'  => $request->color_code,
            'description' => $request->description,
        ]);

        return redirect()->route('manage.products.labels.index')
            ->with('success', 'Label "' . $label->name . '" updated successfully.');
    }

    // ---------------
    // Delete Label
    // ---------------
    public function destroy(string $id)
    {
        $label = Label::withCount('products')->findOrFail($id);

        if ($label->products_count > 0) {
            return redirect()->route('manage.products.labels.index')
                ->with('error', 'Cannot delete "' . $label->name . '" - it is assigned to ' . $label->products_count . ' product(s).');
        }

        $name = $label->name;
        $label->delete();

        return redirect()->route('manage.products.labels.index')
            ->with('success', 'Label "' . $name . '" deleted successfully.');
    }
}
