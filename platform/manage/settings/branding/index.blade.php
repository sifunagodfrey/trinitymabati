@extends('manage.layouts.app')

@section('title', 'Branding Settings')

@section('content')
    <div class="mb-6">
        <nav class="mb-4 text-sm text-muted" aria-label="Breadcrumb">
            <a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a>
            <span class="mx-2">/</span><span>Settings</span>
            <span class="mx-2">/</span><strong class="text-text">Branding</strong>
        </nav>
        <h1 class="text-2xl font-semibold text-text">Site Branding</h1>
        <p class="mt-1 text-sm text-muted">Update the name, logos, browser icons and colours used throughout the site.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.settings.branding.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <section class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-text">Site Identity</h2>
            <div class="max-w-xl">
                <label for="site_name" class="mb-1 block text-sm font-medium text-text">Site Name</label>
                <input id="site_name" name="site_name" type="text" required maxlength="100"
                    value="{{ old('site_name', $values['site_name']) }}"
                    class="w-full rounded-[8px] border-border bg-white text-sm focus:border-primary focus:ring-primary">
                <p class="mt-1 text-xs text-muted">Used in page titles, captions, emails and accessible image labels.</p>
            </div>
        </section>

        <section class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-text">Logos and Site Icons</h2>
            <p class="mb-5 mt-1 text-sm text-muted">PNG, JPG or WEBP. Transparent PNG files are recommended for logos.</p>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ([
                    'logo_main' => ['Main Logo', 'Default logo used where no special variant is required.'],
                    'logo_white' => ['White Logo', 'Used on dark backgrounds such as the footer.'],
                    'logo_dark' => ['Dark Logo', 'Used in headers and other light surfaces.'],
                    'site_icon' => ['Site Icon / Favicon', 'Browser tab icon; ICO is also accepted.'],
                    'apple_touch_icon' => ['Mobile Site Icon', 'Icon used when the site is saved to a phone home screen.'],
                ] as $key => [$label, $help])
                    <label class="block rounded-[12px] border border-border bg-background p-4">
                        <span class="block text-sm font-semibold text-text">{{ $label }}</span>
                        <span class="mb-3 block text-xs text-muted">{{ $help }}</span>
                        <span class="mb-3 flex h-20 items-center justify-center rounded-[8px] border border-border bg-white p-3">
                            <img src="{{ $values[$key] }}" alt="{{ $label }} preview" class="max-h-full max-w-full object-contain">
                        </span>
                        <input type="file" name="{{ $key }}" accept="{{ $key === 'site_icon' ? 'image/*,.ico' : 'image/*' }}"
                            class="block w-full text-xs text-muted file:mr-3 file:rounded-[8px] file:border-0 file:bg-primary file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:opacity-90">
                    </label>
                @endforeach
            </div>
        </section>

        <section class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-text">Brand Colours</h2>
            <p class="mb-5 mt-1 text-sm text-muted">These colours become global CSS variables and update the storefront, client portal and admin area.</p>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                @foreach ([
                    'primary_color' => 'Primary Colour',
                    'secondary_color' => 'Secondary Colour',
                    'tertiary_color' => 'Tertiary Colour',
                ] as $key => $label)
                    <div>
                        <label for="{{ $key }}" class="mb-1 block text-sm font-medium text-text">{{ $label }}</label>
                        <div class="flex items-center gap-3 rounded-[8px] border border-border bg-white p-2">
                            <input id="{{ $key }}" name="{{ $key }}" type="color"
                                value="{{ old($key, $values[$key]) }}" class="h-10 w-12 cursor-pointer rounded-[8px] border-0 bg-transparent p-0">
                            <input type="text" value="{{ old($key, $values[$key]) }}" maxlength="7" placeholder="#713FCE"
                                class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm uppercase text-muted focus:ring-0"
                                data-colour-value="{{ $key }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="rounded-[8px] bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:opacity-90">Save Branding</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[type="color"]').forEach((picker) => {
        const textInput = document.querySelector(`[data-colour-value="${picker.name}"]`);
        picker.addEventListener('input', () => {
            textInput.value = picker.value.toUpperCase();
        });
        textInput.addEventListener('input', () => {
            let value = textInput.value.trim();
            if (value && !value.startsWith('#')) value = '#' + value;
            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                picker.value = value;
                textInput.value = value.toUpperCase();
            }
        });
        textInput.addEventListener('paste', () => setTimeout(() => textInput.dispatchEvent(new Event('input')), 0));
    });
</script>
@endpush
