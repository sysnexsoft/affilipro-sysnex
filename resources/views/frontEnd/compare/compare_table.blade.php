@if(count($products) < 2)
    <div class="p-16 text-center w-full bg-slate-50/50 rounded-2xl">
        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full d-flex align-items-center justify-content-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-code-compare"></i>
        </div>
        <h4 class="font-display text-xl font-bold text-slate-800">Not enough products to compare.</h4>
        <p class="text-slate-500 mt-2 text-sm max-w-sm mx-auto">Add at least 2 products to the comparison list to see a side-by-side metric breakdown.</p>
        <a href="{{ route('home') }}" class="btn-grad text-sm no-underline d-inline-block mt-4 px-5 py-2.5 rounded-xl shadow-md">Back to Home</a>
    </div>
@else
    <table class="table align-middle mb-0 min-w-[760px] border-collapse">
        <thead>
        <tr class="border-b border-slate-100">
            <th class="p-4 bg-slate-50/70 text-slate-500 font-bold text-sm tracking-wide uppercase text-start ps-6" style="width: 22%;">Metrics</th>
            @foreach($products as $index => $product)
                <th class="p-5 text-center transition-all relative {{ $index === 0 ? 'bg-blue-50/30' : '' }}" style="width: calc(78% / {{ count($products) }});">
                    @if($index === 0)
                        <span class="badge-pick mb-3 d-inline-block bg-primary text-white text-[11px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">Best Pick</span>
                    @endif
                    <div class="mb-4 bg-white p-2 rounded-xl border border-slate-100 inline-block shadow-sm">
                        <img src="{{ asset($product->featured_image ?? 'placeholder.png') }}" class="img-fluid mx-auto" style="max-height: 90px; object-fit: contain;">
                    </div>
                    <div class="font-bold text-slate-800 text-sm line-clamp-2 px-2 h-10 leading-snug" title="{{ $product->title }}">{{ $product->title }}</div>

                    {{-- AJAX রিমুভ বাটন --}}
                    <button type="button" data-id="{{ $product->id }}" class="btn-remove-compare text-[11px] text-slate-400 hover:text-red-500 no-underline border-0 bg-transparent mt-3 transition-colors duration-200 font-medium cursor-pointer">
                        <i class="fa-solid fa-xmark me-1"></i> Remove
                    </button>
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        <!-- রেটিং -->
        <tr class="hover:bg-slate-50/50 transition">
            <td class="p-4 fw-bold text-slate-600 text-sm ps-6">Rating</td>
            @foreach($products as $index => $product)
                <td class="p-4 text-center {{ $index === 0 ? 'bg-blue-50/20' : '' }}">
                        <span class="stars text-amber-400 text-xs gap-0.5 d-inline-flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($product->rating >= $i) <i class="fa-solid fa-star"></i>
                                @elseif($product->rating >= ($i - 0.5)) <i class="fa-solid fa-star-half-stroke"></i>
                                @else <i class="fa-regular fa-star text-slate-200"></i>
                                @endif
                            @endfor
                        </span>
                    <div class="text-[11px] font-semibold text-slate-400 mt-1">{{ $product->rating }} / 5</div>
                </td>
            @endforeach
        </tr>

        <!-- প্রাইস -->
        <tr class="hover:bg-slate-50/50 transition">
            <td class="p-4 fw-bold text-slate-600 text-sm ps-6">Price</td>
            @foreach($products as $index => $product)
                <td class="p-4 text-center {{ $index === 0 ? 'bg-blue-50/20' : '' }}">
                    @if($product->sale_price)
                        <span class="text-lg font-black text-slate-900">${{ $product->sale_price }}</span>
                        <span class="line-through text-slate-400 text-xs ms-1.5">${{ $product->regular_price }}</span>
                    @else
                        <span class="text-lg font-black text-slate-900">${{ $product->regular_price ?? 'N/A' }}</span>
                    @endif
                </td>
            @endforeach
        </tr>

        <!-- ব্র্যান্ড -->
        <tr class="hover:bg-slate-50/50 transition">
            <td class="p-4 fw-bold text-slate-600 text-sm ps-6">Brand</td>
            @foreach($products as $index => $product)
                <td class="p-4 text-center {{ $index === 0 ? 'bg-blue-50/20' : '' }} text-slate-700 font-semibold text-sm">
                    {{ $product->brand->name ?? 'Generic' }}
                </td>
            @endforeach
        </tr>

        <!-- ডায়নামিক ফিল্ডসমূহ -->
        @foreach($comparisonFields as $field)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="p-4 fw-bold text-slate-600 text-sm ps-6">{{ $field->name }}</td>
                @foreach($products as $index => $product)
                    <td class="p-4 text-center {{ $index === 0 ? 'bg-blue-50/20' : '' }} text-slate-600 text-sm">
                        @php $linkedField = $product->comparisonFields->firstWhere('id', $field->id); @endphp
                        <span class="{{ $linkedField ? 'font-medium text-slate-800' : 'text-slate-300' }}">
                                {{ $linkedField ? $linkedField->pivot->value : '—' }}
                            </span>
                    </td>
                @endforeach
            </tr>
        @endforeach

        <!-- Pros -->
        <tr class="hover:bg-slate-50/50 transition">
            <td class="p-4 fw-bold text-slate-600 text-sm ps-6">Pros</td>
            @foreach($products as $index => $product)
                <td class="p-4 {{ $index === 0 ? 'bg-blue-50/20' : '' }} text-xs text-slate-600 text-start ps-8">
                    @if($product->pros)
                        <div class="leading-relaxed text-emerald-700 font-medium">{!! nl2br(e($product->pros)) !!}</div>
                    @else
                        <div class="text-emerald-600 font-medium d-flex flex-column gap-1">
                            <span><i class="fa-solid fa-circle-check text-emerald-500 me-1.5"></i> Great value</span>
                            <span><i class="fa-solid fa-circle-check text-emerald-500 me-1.5"></i> High reliability</span>
                        </div>
                    @endif
                </td>
            @endforeach
        </tr>

        <!-- Action -->
        <tr>
            <td class="p-4"></td>
            @foreach($products as $index => $product)
                <td class="p-5 text-center {{ $index === 0 ? 'bg-blue-50/20' : '' }}">
                    @if($product->affiliate_url)
                        <a href="{{ $product->affiliate_url }}" target="_blank" class="btn-grad text-xs no-underline d-inline-block px-4 py-2.5 rounded-xl shadow-sm hover:translate-y-[-1px] transition duration-200">
                            Buy via {{ $product->affiliate_network ?? 'Store' }} <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-[10px]"></i>
                        </a>
                    @else
                        <a href="{{ route('product.details', $product->slug) }}" class="text-xs font-semibold no-underline d-inline-block px-4 py-2.5 rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 transition border border-slate-200/50">
                            View Details
                        </a>
                    @endif
                </td>
            @endforeach
        </tr>
        </tbody>
    </table>
@endif
