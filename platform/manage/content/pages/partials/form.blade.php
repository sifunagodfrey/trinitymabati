{{-- -------------------
     Admin Content - Page Form Partial
     Shared by the create and edit screens
------------------- --}}
<form method="POST" action="{{ $action }}"
      class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-5 sm:grid-cols-2">

        {{-- Title --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Title <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $page?->title) }}" required
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('title') border-red-400 @enderror" />
            @error('title')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $page?->slug) }}"
                placeholder="Leave blank to generate from the title"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black font-mono outline-none focus:border-primary" />
            <p class="text-xs text-muted">The page lives at /pages/slug. Legal pages also keep their dedicated URLs.</p>
        </div>

        {{-- Content --}}
        <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Content</label>
            <div id="quill-editor">{!! old('content', $page?->content) !!}</div>
            <input type="hidden" name="content" id="content-input" value="{{ old('content', $page?->content) }}">
            <p class="text-xs text-muted">Write and format the page content, no HTML knowledge required.</p>
            @error('content')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Meta Title --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $page?->meta_title) }}"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
        </div>

        {{-- Status --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Status</label>
            <select name="is_active"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                <option value="1" {{ old('is_active', $page?->is_active ?? true) ? 'selected' : '' }}>Published</option>
                <option value="0" {{ ! old('is_active', $page?->is_active ?? true) ? 'selected' : '' }}>Hidden</option>
            </select>
        </div>

        {{-- Meta Description --}}
        <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Meta Description</label>
            <textarea name="meta_description" rows="2" maxlength="255"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">{{ old('meta_description', $page?->meta_description) }}</textarea>
        </div>

    </div>

    {{-- ---------------
    -- Form Actions
    -- --------------- --}}
    <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
        <a href="{{ route('manage.content.pages.index') }}"
            class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
            <i class="fa-solid fa-floppy-disk"></i>
            Save Page
        </button>
    </div>

</form>
