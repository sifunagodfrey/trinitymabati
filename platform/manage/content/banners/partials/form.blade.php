{{-- -------------------
     Admin Content - Banner Form Partial
     Shared by the create and edit screens
------------------- --}}
<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
      class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-5 sm:grid-cols-2">

        {{-- Title --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Title</label>
            <input type="text" name="title" value="{{ old('title', $banner?->title) }}" maxlength="150"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
            <p class="text-xs text-muted">Internal label, also used as the image alt text.</p>
        </div>

        {{-- Link --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Link URL</label>
            <input type="text" name="link_url" value="{{ old('link_url', $banner?->link_url) }}" maxlength="255"
                placeholder="/products or https://"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black font-mono outline-none focus:border-primary" />
            <p class="text-xs text-muted">Where tapping the slide goes. Relative paths or full URLs.</p>
        </div>

        {{-- Image --}}
        <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Slide Image @if (! $banner)<span class="text-rose-500">*</span>@endif
            </label>
            @if ($banner?->image)
                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                     class="w-full max-w-md rounded-[12px] border border-border object-cover mb-2">
            @endif
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                class="text-sm text-muted file:mr-3 file:rounded-[8px] file:border-none file:bg-primary/10 file:px-4 file:py-2 file:text-sm file:font-medium file:text-primary file:cursor-pointer" />
            <p class="text-xs text-muted">Recommended 1280 x 400 or wider. JPG, PNG or WEBP up to 4MB.
                @if ($banner) Leave empty to keep the current image. @endif
            </p>
            @error('image')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Position --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                Position <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="position" value="{{ old('position', $banner?->position ?? $nextPosition ?? 1) }}" required min="0"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
            <p class="text-xs text-muted">Lower numbers rotate first.</p>
        </div>

        {{-- Status --}}
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Status</label>
            <select name="is_active"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                <option value="1" {{ old('is_active', $banner?->is_active ?? true) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ! old('is_active', $banner?->is_active ?? true) ? 'selected' : '' }}>Hidden</option>
            </select>
        </div>

    </div>

    {{-- ---------------
    -- Form Actions
    -- --------------- --}}
    <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
        <a href="{{ route('manage.content.banners.index') }}"
            class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
            <i class="fa-solid fa-floppy-disk"></i>
            Save Banner
        </button>
    </div>

</form>
