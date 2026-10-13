@extends('manage.layouts.app')

@section('title', 'Edit Blog Post - Trinity Mabati Factory Admin')

@push('styles')
    {{-- ---------------
    -- Quill rich editor stylesheet
    -- --------------- --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        /* ---------------
         * Quill editor sizing
         * --------------- */
        #quill-editor {
            min-height: 400px;
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
            resize: none !important;
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
            height: auto !important;
        }
        .ql-editor {
            overflow-y: visible !important;
        }
        .ql-editor img {
            display: block;
            max-width: 100% !important;
            width: auto !important;
            height: auto !important;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }
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
                <li><a href="{{ route('manage.blogs.posts.index') }}" class="hover:text-primary">Blog Posts</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Edit Post</li>
            </ol>
        </nav>

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Edit Post</h1>
                <p class="text-sm text-muted">Update the content and settings of this blog post.</p>
            </div>
            <a href="{{ route('manage.blogs.posts.index') }}"
               class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back
            </a>
        </div>
    </div>

    {{-- ---------------
    -- Validation Errors
    -- --------------- --}}
    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.blogs.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ---------------
            -- Main content column
            -- --------------- --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Title --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <label for="title" class="block text-sm font-medium text-black mb-1">
                        Post Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title"
                        value="{{ old('title', $post->title) }}"
                        placeholder="Enter a compelling title..."
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Excerpt --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <label for="excerpt" class="block text-sm font-medium text-black mb-1">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                        placeholder="Short summary shown in listings and meta descriptions..."
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary resize-none @error('excerpt') border-red-400 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ---------------
                -- Rich Text Content (Quill)
                -- --------------- --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <label class="block text-sm font-medium text-black mb-3">
                        Full Content <span class="text-red-500">*</span>
                    </label>
                    <div id="quill-editor"></div>
                    {{-- Hidden input carries existing content for re-render on validation fail --}}
                    <input type="hidden" name="content" id="content-input"
                           value="{{ old('content', $post->content) }}">
                    @error('content')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- ---------------
            -- Sidebar options column
            -- --------------- --}}
            <div class="space-y-6">

                {{-- Publish settings --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-4">Publish Settings</h3>

                    <label class="flex items-center gap-3 cursor-pointer mb-4">
                        <input type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                            class="w-4 h-4 rounded accent-primary">
                        <span class="text-sm text-black">Published</span>
                    </label>

                    @if ($post->published_at)
                        <p class="text-xs text-muted mb-4">
                            Published: {{ $post->published_at->format('d M Y, H:i') }}
                        </p>
                    @endif

                    <div class="flex justify-end gap-3 pt-2 border-t border-border">
                        <a href="{{ route('manage.blogs.posts.index') }}"
                           class="rounded-[12px] border border-border px-4 py-2 text-sm text-muted transition hover:bg-slate-100">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                            Update Post
                        </button>
                    </div>
                </div>

                {{-- Category --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-4">Category</h3>
                    <select name="category_id"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="">- No Category -</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tags --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-4">Tags</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach ($tags as $tag)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', $postTagIds)) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded accent-primary">
                                <span class="text-sm text-black">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                        @if ($tags->isEmpty())
                            <p class="text-xs text-muted">
                                No tags yet.
                                <a href="{{ route('manage.blogs.tags.index') }}" class="text-primary hover:underline">Add tags</a>
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-4">Thumbnail Image</h3>
                    @if ($post->thumbnail)
                        <div class="mb-3">
                            <img src="{{ asset($post->thumbnail) }}"
                             alt="Current thumbnail"
                                 class="w-full rounded-[12px] object-cover max-h-40 border border-border">
                            <p class="text-xs text-muted mt-1">Current thumbnail - upload a new file to replace.</p>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                        onchange="previewImage(this, 'thumbnail-preview')"
                        class="w-full text-sm text-muted file:mr-3 file:rounded-[12px] file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-xs file:text-white file:cursor-pointer">
                    <div id="thumbnail-preview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="w-full rounded-[12px] object-cover max-h-40 border border-border">
                    </div>
                    @error('thumbnail')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Banner --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-4">Banner Image</h3>
                    @if ($post->banner)
                        <div class="mb-3">
                            <img src="{{ asset($post->banner) }}"
                             alt="Current banner"
                                 class="w-full rounded-[12px] object-cover max-h-40 border border-border">
                            <p class="text-xs text-muted mt-1">Current banner - upload a new file to replace.</p>
                        </div>
                    @endif
                    <input type="file" name="banner" id="banner" accept="image/*"
                        onchange="previewImage(this, 'banner-preview')"
                        class="w-full text-sm text-muted file:mr-3 file:rounded-[12px] file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-xs file:text-white file:cursor-pointer">
                    <div id="banner-preview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="w-full rounded-[12px] object-cover max-h-40 border border-border">
                    </div>
                    @error('banner')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

    </form>

@endsection

@push('scripts')
    {{-- ---------------
    -- Quill rich editor
    -- --------------- --}}
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        // ---------------
        // Initialise Quill with full toolbar
        // ---------------
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ color: [] }, { background: [] }],
                        [{ align: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean']
                    ],
                    handlers: {
                        image: function () { uploadEditorMedia(quill, 'image/*'); }
                    }
                }
            }
        });

        // ---------------
        // Upload an image/video file to the server and insert it at the cursor
        // ---------------
        function uploadEditorMedia(editor, accept) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = accept;
            input.onchange = function () {
                const file = input.files[0];
                if (!file) return;

                const range = editor.getSelection(true);
                editor.insertText(range.index, 'Uploading...', 'italic', true);

                const formData = new FormData();
                formData.append('file', file);

                axios.post('{{ route('manage.blogs.posts.uploadMedia') }}', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(function (response) {
                    editor.deleteText(range.index, 'Uploading...'.length);
                    editor.insertEmbed(range.index, 'image', response.data.url);
                    editor.setSelection(range.index + 1);
                }).catch(function () {
                    editor.deleteText(range.index, 'Uploading...'.length);
                    alert('Upload failed. Please try again.');
                });
            };
            input.click();
        }

        // ---------------
        // Preload existing post content into editor
        // ---------------
        const existingContent = document.getElementById('content-input').value;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // ---------------
        // Sync Quill HTML to hidden input before submit
        // ---------------
        document.getElementById('quill-editor').closest('form').addEventListener('submit', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });

        // ---------------
        // Image file preview helper
        // ---------------
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
