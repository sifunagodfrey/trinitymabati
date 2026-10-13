@extends('manage.layouts.app')

@section('title', 'Product Categories')

@section('content')
    {{-- manage/products/categories/index.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.categories.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Categories</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Product Categories</h1>
                <p class="text-sm text-muted">Manage category hierarchy, commission rates, and visibility.</p>
            </div>

            <a href="{{ route('manage.products.categories.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Category
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[720px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Icon</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Parent</th>
                        <th class="px-4 py-3">Products</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $category->id }}</td>
                            <td class="px-4 py-4">
                                <div class="h-12 w-12 overflow-hidden rounded-[12px] bg-slate-100">
                                    @if ($category->featured_image)
                                        <img src="{{ asset('categories/featured/' . $category->featured_image) }}"
                                            alt="{{ $category->name }} icon" class="h-full w-full object-cover" />
                                    @elseif ($category->icon)
                                        <img src="{{ asset('categories/icons/' . $category->icon) }}"
                                            alt="{{ $category->name }} icon" class="h-full w-full object-cover" />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-muted">No icon</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-black">{{ $category->name }}</div>
                                <div class="text-xs text-muted">{{ Str::limit($category->description, 60) ?: 'No description' }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-black">{{ optional($category->parent)->name ?? 'Root' }}</td>
                            <td class="px-4 py-4 text-sm text-black">{{ $category->products_count }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('manage.products.categories.edit', $category->id) }}"
                                        class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-3 py-2 text-xs font-medium text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-pencil"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('manage.products.categories.destroy', $category->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete category {{ addslashes($category->name) }}? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-[12px] bg-red-50 px-3 py-2 text-xs font-medium text-red-700 transition hover:bg-red-100">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-muted">
                                No categories found. Create a new category to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
@endsection