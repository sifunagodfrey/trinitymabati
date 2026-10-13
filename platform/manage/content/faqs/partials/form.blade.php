{{-- -------------------
     Admin Content - FAQ Form Partial
     Shared by the create and edit screens
------------------- --}}
<form method="POST" action="{{ $action }}"
      class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-5 sm:grid-cols-2">

        {{-- Question --}}
        <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Question <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="question" value="{{ old('question', $faq?->question) }}" required maxlength="255"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('question') border-red-400 @enderror" />
            @error('question')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Answer --}}
        <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Answer <span class="text-rose-500">*</span>
            </label>
            <textarea name="answer" rows="5" required
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('answer') border-red-400 @enderror">{{ old('answer', $faq?->answer) }}</textarea>
            @error('answer')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Position --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Position <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="position" value="{{ old('position', $faq?->position ?? $nextPosition ?? 1) }}" required min="0"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
            <p class="text-xs text-muted">Lower numbers appear first on the FAQ page.</p>
        </div>

        {{-- Status --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Status</label>
            <select name="is_active"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                <option value="1" {{ old('is_active', $faq?->is_active ?? true) ? 'selected' : '' }}>Published</option>
                <option value="0" {{ ! old('is_active', $faq?->is_active ?? true) ? 'selected' : '' }}>Hidden</option>
            </select>
        </div>

    </div>

    {{-- ---------------
    -- Form Actions
    -- --------------- --}}
    <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
        <a href="{{ route('manage.content.faqs.index') }}"
            class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
            <i class="fa-solid fa-floppy-disk"></i>
            Save Question
        </button>
    </div>

</form>
