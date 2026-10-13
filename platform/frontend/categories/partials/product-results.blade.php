{{-- -------------------
     Category Product Results
     Shared by the full category page and the AJAX category switch/filter.
     Renders the product grid plus pagination.
------------------- --}}
<div id="category-products">
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2.5 md:gap-4">
        @forelse ($products as $product)
            @include('frontend.partials.product-card', ['product' => $product['model']])
        @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-box-open text-4xl text-gray-200 mb-4 block"></i>
                <p class="text-sm font-semibold text-text mb-1">No products here yet</p>
                <p class="text-xs text-muted">Check back soon or browse another category.</p>
            </div>
        @endforelse
    </div>

    @if ($productsPaginator->hasPages())
        <div class="flex items-center justify-center pt-6">
            {{ $productsPaginator->links() }}
        </div>
    @endif
</div>
