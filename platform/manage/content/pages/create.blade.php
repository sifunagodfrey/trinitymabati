{{-- -------------------
     Admin Content - Create Page
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Add Page - Trinity Mabati Factory Admin')

@push('styles')
    {{-- ---------------
    -- Rich editor stylesheet
    -- --------------- --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        /* ---------------
         * Rich editor sizing
         * --------------- */
        #quill-editor {
            min-height: 320px;
            font-size: 15px;
            background: #fff;
        }
        .ql-toolbar.ql-snow {
            border-radius: 1rem 1rem 0 0;
            border-color: var(--color-border, #e2e8f0);
        }
        .ql-container.ql-snow {
            border-radius: 0 0 1rem 1rem;
            border-color: var(--color-border, #e2e8f0);
        }
        .ql-editor img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 0.5rem 0; }
    </style>
@endpush

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.content.pages.index') }}" class="hover:text-primary">Site Pages</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Add Page</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.content.pages.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Add Page</h1>
                <p class="text-sm text-muted">Create a new editable site page.</p>
            </div>
        </div>
    </div>

    @include('manage.content.pages.partials.form', [
        'action' => route('manage.content.pages.store'),
        'method' => 'POST',
        'page'   => null,
    ])

@endsection

@push('scripts')
    {{-- ---------------
    -- Rich editor
    -- --------------- --}}
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        // ---------------
        // Initialise editor with full toolbar
        // ---------------
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ color: [] }, { background: [] }],
                    [{ align: [] }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ indent: '-1' }, { indent: '+1' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // ---------------
        // Sync editor HTML to hidden input before submit
        // ---------------
        document.getElementById('quill-editor').closest('form').addEventListener('submit', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });
    </script>
@endpush
