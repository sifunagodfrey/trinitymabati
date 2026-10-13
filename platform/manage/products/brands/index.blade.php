@extends('manage.layouts.app')

@section('title', 'Product Brands')

@section('content')
    {{-- manage/products/brands/index.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.brands.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Brands</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Product Brands</h1>
                <p class="text-sm text-muted">Manage brands with logos and descriptions.</p>
            </div>

            <a href="{{ route('manage.products.brands.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Brand
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
                        <th class="px-4 py-3">Logo</th>
                        <th class="px-4 py-3">Brand</th>
                        <th class="px-4 py-3">Products</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($brands as $brand)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $brand->id }}</td>
                            <td class="px-4 py-4">
                                <div class="h-12 w-12 overflow-hidden rounded-[12px] bg-slate-100">
                                    @if ($brand->logo)
                                        <img src="{{ asset(str_starts_with($brand->logo, 'uploads/') || str_starts_with($brand->logo, 'storage/') ? $brand->logo : (str_starts_with($brand->logo, 'brands/') ? 'storage/' . $brand->logo : 'uploads/brands/logos/' . $brand->logo)) }}"
                                            alt="{{ $brand->name }} logo" class="h-full w-full object-cover" />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-muted">No logo</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-black">{{ $brand->name }}</div>
                                <div class="text-xs text-muted">{{ Str::limit($brand->description, 60) ?: 'No description' }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-black">{{ $brand->products_count }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('manage.products.brands.destroy', $brand->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete brand {{ addslashes($brand->name) }}? This cannot be undone.');">
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
                                No brands found. Create a new brand to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $brands->links() }}
        </div>
    </div>
@endsection