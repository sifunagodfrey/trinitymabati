@extends('manage.layouts.app')

@section('title', 'View Product')

@section('content')
    {{-- manage/products/all/show.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.all.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-text font-semibold">View Product</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">View Product</h1>
                <p class="text-sm text-muted">Review product details, gallery images, variants, and pricing information.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('manage.products.all.edit', $product->id) }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm font-medium text-text transition hover:bg-slate-100">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit Product
                </a>
                <a href="{{ route('manage.products.all.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-list"></i>
                    All Products
                </a>
            </div>
        </div>
    </div>

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
        <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
            <div class="space-y-4 rounded-[12px] border border-border bg-white p-5 shadow-sm">
                <div class="overflow-hidden rounded-[12px] bg-slate-100">
                    <img src="{{ $product->thumbnail ? asset(str_starts_with($product->thumbnail, 'uploads/') || str_starts_with($product->thumbnail, 'storage/') ? $product->thumbnail : (str_starts_with($product->thumbnail, 'products/') ? 'storage/' . $product->thumbnail : 'uploads/products/images/' . $product->thumbnail)) : asset('images/product-placeholder.jpg') }}"
                        alt="{{ $product->name }}" class="h-72 w-full object-cover text-black" />
                </div>

                @if ($product->media->where('type', 'image')->isNotEmpty())
                    <div class="grid gap-3 sm:grid-cols-3">
                        @foreach ($product->media->where('type', 'image')->take(6) as $media)
                            <div class="h-20 overflow-hidden rounded-[12px] bg-slate-100">
                                <img src="{{ asset(str_starts_with($media->file_path, 'uploads/') || str_starts_with($media->file_path, 'storage/') ? $media->file_path : (str_starts_with($media->file_path, 'products/') ? 'storage/' . $media->file_path : 'uploads/products/images/' . $media->file_path)) }}"
                                    alt="Gallery image" class="h-full w-full object-cover" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-black">{{ $product->name }}</h2>
                            <p class="text-sm text-muted">SKU: {{ $product->sku ?? 'N/A' }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-[12px] bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mt-6 grid gap-4">
                        <div class="space-y-3 rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Categories</div>
                            <div class="text-sm text-black">
                                {{ $product->categories->isNotEmpty() ? $product->categories->pluck('name')->join(', ') : 'N/A' }}
                            </div>
                        </div>

                        <div class="space-y-3 rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Brand</div>
                            <div class="text-sm text-black">{{ optional($product->brand)->name ?? 'N/A' }}</div>
                        </div>

                        <div class="space-y-3 rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Labels</div>
                            @if ($product->labels->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($product->labels as $label)
                                        <span class="inline-flex items-center text-xs font-medium text-white px-2 py-0.5 rounded-[12px]"
                                            style="background-color: {{ $label->color_code ?? '#9ca3af' }}">
                                            {{ $label->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm text-black">N/A</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        {{-- Price card – now shows range for variants or bulk --}}
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Selling Price</div>
                            @php
                                $minPrice = null;
                                $maxPrice = null;
                                $priceNote = null;
                                if ($product->is_variant && $product->variants->isNotEmpty()) {
                                    $minPrice = $product->variants->min(fn ($v) => $v->sale_price ?? $v->price);
                                    $maxPrice = $product->variants->max(fn ($v) => $v->sale_price ?? $v->price);
                                    $priceNote = 'across ' . $product->variants->count() . ' variants';
                                } else {
                                    $minPrice = $product->sale_price ?? $product->price;
                                    $maxPrice = $minPrice;
                                }
                            @endphp
                            @if ($minPrice && $maxPrice)
                                <div class="text-lg font-semibold text-black">
                                    @if ($minPrice == $maxPrice)
                                        KES {{ number_format($minPrice, 2) }}
                                    @else
                                        KES {{ number_format($minPrice, 2) }} – {{ number_format($maxPrice, 2) }}
                                    @endif
                                </div>
                                @if ($priceNote)
                                    <div class="text-xs text-muted mt-1">{{ $priceNote }}</div>
                                @endif
                            @else
                                <div class="text-lg font-semibold text-black">N/A</div>
                            @endif
                        </div>

                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Strike-through Price</div>
                            <div class="text-lg font-semibold text-black">{{ $product->sale_price ? 'KES ' . number_format($product->price, 2) : 'N/A' }}</div>
                        </div>
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Cost Price</div>
                            @php
                                $costMin = $product->is_variant && $product->variants->isNotEmpty()
                                    ? $product->variants->whereNotNull('cost_price')->min('cost_price')
                                    : $product->cost_price;
                                $costMax = $product->is_variant && $product->variants->isNotEmpty()
                                    ? $product->variants->whereNotNull('cost_price')->max('cost_price')
                                    : $product->cost_price;
                            @endphp
                            @if ($costMin)
                                <div class="text-lg font-semibold text-black">
                                    KES {{ number_format($costMin, 2) }}@if ($costMax && $costMax != $costMin) - {{ number_format($costMax, 2) }}@endif
                                </div>
                                <div class="text-xs text-muted mt-1">internal, used for profit reports</div>
                            @else
                                <div class="text-lg font-semibold text-black">N/A</div>
                            @endif
                        </div>
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">Stock</div>
                            @if ($product->is_variant && $product->variants->isNotEmpty())
                                <div class="text-sm text-black">{{ $product->variants->sum('stock_quantity') }}</div>
                                <div class="text-xs text-muted">across {{ $product->variants->count() }} variant(s)</div>
                            @else
                                <div class="text-sm text-black">{{ $product->stock_quantity }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-muted">VAT Status</div>
                            <div class="text-sm font-semibold text-black">{{ $product->is_vat_exempt ? 'Exempt' : 'Applied' }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-black">Dimensions</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs text-muted">Weight</div>
                            <div class="text-sm text-black">{{ $product->weight ?? 'N/A' }} kg</div>
                        </div>
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs text-muted">Length</div>
                            <div class="text-sm text-black">{{ $product->length ?? 'N/A' }} cm</div>
                        </div>
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs text-muted">Width</div>
                            <div class="text-sm text-black">{{ $product->width ?? 'N/A' }} cm</div>
                        </div>
                        <div class="rounded-[12px] bg-slate-50 p-4">
                            <div class="text-xs text-muted">Height</div>
                            <div class="text-sm text-black">{{ $product->height ?? 'N/A' }} cm</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($product->variants->isNotEmpty())
            <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-black">Variants</h2>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-[600px] divide-y divide-border text-sm">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-muted">
                            <tr>
                                <th class="px-4 py-3">Variant</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Stock</th>
                                <th class="px-4 py-3">VAT</th>
                                <th class="px-4 py-3">Net</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($product->variants as $variant)
                                @php
                                    $variantLabel = $variant->variantAttributes->map(fn($attr) => optional($attr->attributeValue)->value)->filter()->join(' / ');
                                @endphp
                                <tr>
                                    <td class="px-4 py-4 text-black">{{ $variantLabel ?: '#'.$variant->id }}</td>
                                    <td class="px-4 py-4 text-black">KES {{ number_format($variant->price, 2) }}</td>
                                    <td class="px-4 py-4 text-black">{{ $variant->stock_quantity }}</td>
                                    <td class="px-4 py-4 text-black">{{ $product->is_vat_exempt ? 'Exempt' : 'Applied' }}</td>
                                    <td class="px-4 py-4 text-black">KES {{ number_format($variant->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


        <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
            <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-black">Short Description</h3>
                <p class="mt-3 text-sm leading-6 text-muted">{{ $product->short_description ?? 'No short description available.' }}</p>

                <h3 class="mt-6 text-lg font-semibold text-black">Detailed Description</h3>
                <div class="mt-3 rounded-[12px] bg-slate-50 p-4 text-sm leading-6 text-muted prose max-w-none">
                    {!! $product->detailed_description ?? '<p>No detailed description available.</p>' !!}
                </div>
            </div>

            <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-black">Product Metadata</h3>
                <div class="mt-4 space-y-3 text-sm text-black">
                    <div class="flex items-center justify-between rounded-[12px] bg-slate-50 p-4">
                        <span>ID</span>
                        <span class="font-semibold">#{{ $product->id }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-[12px] bg-slate-50 p-4">
                        <span>Created</span>
                        <span class="font-semibold">{{ $product->created_at?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-[12px] bg-slate-50 p-4">
                        <span>Updated</span>
                        <span class="font-semibold">{{ $product->updated_at?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========= CUSTOMER REVIEWS CARD ========= --}}
        @if($product->reviews->count())
            <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-black">
                        Customer Reviews ({{ $product->reviews->count() }})
                    </h3>
                    @php
                        $avgRating = $product->reviews->avg('rating');
                    @endphp
                    @if($avgRating)
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
                            @endfor
                            <span class="text-sm text-muted ml-1">{{ number_format($avgRating, 1) }}</span>
                        </div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[720px] divide-y divide-border text-sm">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-muted">
                            <tr>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Rating</th>
                                <th class="px-4 py-3">Comment</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($product->reviews as $review)
                                <tr>
                                    <td class="px-4 py-3">{{ $review->user?->name ?? 'Anonymous' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex text-amber-400 text-xs">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 max-w-xs break-words">{{ $review->comment ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $review->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-[12px] px-2 py-0.5 text-xs font-semibold
                                            {{ $review->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($review->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($review->status !== 'approved')
                                            <form method="POST" action="{{ route('manage.products.reviews.status', $review->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="text-emerald-600 hover:text-emerald-800 mr-2" title="Approve">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($review->status !== 'rejected')
                                            <form method="POST" action="{{ route('manage.products.reviews.status', $review->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-rose-600 hover:text-rose-800" title="Reject">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm text-center text-muted">
                No customer reviews yet.
            </div>
        @endif
    </div>

@endsection
