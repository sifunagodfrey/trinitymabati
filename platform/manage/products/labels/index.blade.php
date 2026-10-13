@extends('manage.layouts.app')

@section('title', 'Product Labels')

@section('content')
    {{-- manage/products/labels/index.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.labels.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Labels</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Product Labels</h1>
                <p class="text-sm text-muted">Manage promotional and informational labels with colours.</p>
            </div>

            <a href="{{ route('manage.products.labels.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Label
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
            <table class="min-w-[600px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Colour</th>
                        <th class="px-4 py-3">Label</th>
                        <th class="px-4 py-3">Products</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($labels as $label)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $label->id }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-[8px] border border-border" style="background-color: {{ $label->color_code }}"></div>
                                    <span class="text-xs font-mono text-muted">{{ $label->color_code }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-black">{{ $label->name }}</div>
                                <div class="text-xs text-muted">{{ Str::limit($label->description, 50) ?: 'No description' }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-black">{{ $label->products_count }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('manage.products.labels.destroy', $label->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete label {{ addslashes($label->name) }}? This cannot be undone.');">
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
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-muted">
                                No labels found. Create a new label to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $labels->links() }}
        </div>
    </div>
@endsection