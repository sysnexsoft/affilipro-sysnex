<div class="card-premium p-4 flex flex-col justify-between h-full bg-white shadow-sm border border-slate-100 rounded-2xl group transition-all duration-300 hover:shadow-md">

    <a href="{{ route('product.details', $product->slug) }}" class="block no-underline group-hover:opacity-95">
        <div class="rounded-xl bg-slate-50 aspect-square grid place-items-center overflow-hidden mb-4 border border-slate-100">
            <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}"
                 alt="{{ $product->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>
        <div>
            <h4 class="font-bold text-base text-slate-900 mb-1 line-clamp-1 group-hover:text-primary transition-colors">
                {{ $product->title }}
            </h4>
            <p class="text-xs text-slate-500 line-clamp-2 min-h-[2rem]">
                {{ Str::limit($product->short_description, 60) }}
            </p>
        </div>
    </a>

    <div class="mt-4 border-t border-slate-100 pt-3">
        <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-3">
            <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Price:</span>
            <div class="flex flex-col items-end sm:flex-row sm:items-center sm:gap-2 clear-both block">
                @if($product->sale_price && $product->regular_price)
                    <span class="product-price-display-fixed text-emerald-600 font-extrabold" style="font-size: 1.25rem !important; display: inline-block !important;">
                        {!! format_price($product->sale_price) !!}
                    </span>
                    <span class="text-slate-400 font-medium line-through" style="font-size: 0.875rem !important; display: inline-block !important;">
                        {!! format_price($product->regular_price) !!}
                    </span>
                @else
                    <span class="product-price-display-fixed text-slate-900 font-extrabold" style="font-size: 1.25rem !important; display: inline-block !important;">
            {!! format_price($product->regular_price ?? $product->sale_price) !!}
        </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <button type="button"
                    data-id="{{ $product->id }}"
                    class="btn-add-to-compare flex items-center justify-center gap-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs py-2 px-2 rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-arrows-rotate text-slate-400"></i> Compare
            </button>

            <a href="{{ route('product.details', $product->slug) }}"
               class="btn-accent flex items-center justify-center text-xs py-2 px-2 no-underline text-center rounded-lg font-semibold bg-slate-900 text-white hover:bg-slate-800 transition-colors">
                Details
            </a>
        </div>
    </div>
</div>
