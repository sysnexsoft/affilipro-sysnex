<div class="card-premium p-4 flex flex-col justify-between">
    <a href="{{route('product.details',$product->slug)}}">
        <div>
            <div class="rounded-xl bg-slate-50 aspect-square grid place-items-center overflow-hidden mb-4">
                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
            </div>
            <h4 class="font-bold text-base text-slate-900 mb-1">{{ $product->title }}</h4>
            <p class="text-xs text-slate-500">{{ Str::limit($product->short_description, 60) }}</p>
        </div>
        <div class="flex items-center justify-between mt-4 border-t pt-3">
            <span class="text-lg font-extrabold text-slate-900">
                {{ format_price($product->sale_price) }}</span>
            <a href="{{route('product.details',$product->slug)}}" class="btn-accent text-xs px-3 py-1.5 no-underline">Details</a>
        </div>
    </a>
</div>
