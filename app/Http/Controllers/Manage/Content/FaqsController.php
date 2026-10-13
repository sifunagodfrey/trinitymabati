<?php

/* -------------------
   Admin FAQ management - list, create, edit, reorder, toggle and delete
   the public frequently asked questions stored in su_faqs.
------------------- */

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use App\Models\Core\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqsController extends Controller
{
    // ---------------
    // List all questions
    // ---------------
    public function index(): View
    {
        $faqs = Faq::orderBy('position')->orderBy('id')->paginate(20)->withQueryString();

        return view('manage.content.faqs.index', compact('faqs'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create(): View
    {
        $nextPosition = (int) Faq::max('position') + 1;

        return view('manage.content.faqs.create', compact('nextPosition'));
    }

    // ---------------
    // Store a new question
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Faq::create($data + ['created_at' => now()]);

        return redirect()->route('manage.content.faqs.index')
            ->with('success', 'Question added successfully.');
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id): View
    {
        $faq = Faq::findOrFail($id);

        return view('manage.content.faqs.edit', compact('faq'));
    }

    // ---------------
    // Update an existing question
    // ---------------
    public function update(Request $request, string $id): RedirectResponse
    {
        $faq = Faq::findOrFail($id);
        $faq->update($this->validated($request));

        return redirect()->route('manage.content.faqs.index')
            ->with('success', 'Question updated successfully.');
    }

    // ---------------
    // Toggle a question between active and hidden
    // ---------------
    public function toggle(string $id): RedirectResponse
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['is_active' => ! $faq->is_active]);

        return back()->with('success', 'Question visibility updated.');
    }

    // ---------------
    // Delete a question
    // ---------------
    public function destroy(string $id): RedirectResponse
    {
        Faq::findOrFail($id)->delete();

        return redirect()->route('manage.content.faqs.index')
            ->with('success', 'Question deleted.');
    }

    // ---------------
    // Shared validation
    // ---------------
    private function validated(Request $request): array
    {
        return $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'position'  => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);
    }
}
