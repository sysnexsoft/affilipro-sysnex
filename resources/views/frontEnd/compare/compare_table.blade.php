@if(count($products) < 2)
    <!-- Ultra-Premium Empty State -->
    <div class="p-16 text-center w-full bg-gradient-to-b from-slate-50 to-white border border-slate-100 rounded-3xl max-w-2xl mx-auto my-12 shadow-sm">
        <div class="w-24 h-24 bg-gradient-to-tr from-blue-500 to-indigo-600 text-white rounded-3xl d-flex align-items-center justify-content-center mx-auto mb-6 shadow-lg rotate-6 hover:rotate-0 transition-transform duration-300">
            <i class="fa-solid fa-sliders text-3xl"></i>
        </div>
        <h4 class="font-display text-3xl font-black text-slate-900 tracking-tight">Compare & Choose</h4>
        <p class="text-slate-500 mt-3 text-base max-w-sm mx-auto leading-relaxed">সেরা ডিলটি বেছে নিতে কমপক্ষে ২টি প্রোডাক্ট যোগ করুন।</p>
        <a href="{{ route('home') }}" class="btn-grad text-sm no-underline d-inline-block mt-8 px-8 py-3.5 rounded-2xl shadow-xl shadow-blue-500/20 hover:shadow-blue-500/30 transition-all font-bold tracking-wide uppercase">
            <i class="fa-solid fa-basket-shopping me-2"></i> Explore Products
        </a>
    </div>
@else

    <!-- ========================================== -->
    <!-- ১. মোবাইল ভিউ: কম স্পেস ও পাশাপাশি ব্র্যান্ড/রেটিং (Ultra-Compact) -->
    <!-- ========================================== -->
    <div class="block md:hidden space-y-3 px-1">
        <!-- প্রোডাক্ট কার্ডস (কম গ্যাপ ও প্যাডিং) -->
        <div class="grid grid-cols-2 gap-2">
            @foreach($products as $index => $product)
                <div class="bg-white rounded-xl border border-slate-100 p-2 shadow-sm relative flex flex-col justify-between {{ $index === 0 ? 'ring-1 ring-blue-500/20' : '' }}">

                    <!-- রিমুভ বাটন -->
                    <button type="button" data-id="{{ $product->id }}" class="btn-remove-compare absolute top-1 right-1 text-slate-400 hover:text-red-500 bg-slate-50 p-1 rounded-lg border-0 transition-all cursor-pointer z-10">
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </button>

                    <div>
                        <!-- ছোট ব্যাজ -->
                        <div class="h-4 mb-1">
                            @if($index === 0)
                                <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider">
                                    Best Value
                                </span>
                            @endif
                        </div>

                        <!-- ইমেজ বক্স (কম প্যাডিং) -->
                        <div class="bg-slate-50 p-1 rounded-lg border border-slate-100 text-center mb-1.5">
                            <img src="{{ asset($product->featured_image ?? 'placeholder.png') }}" class="mx-auto h-16 object-contain">
                        </div>

                        <!-- টাইটেল (কম মার্জিন) -->
                        <h5 class="font-bold text-slate-800 text-[11px] line-clamp-2 leading-tight mb-1 min-h-[1.8rem]">{{ $product->title }}</h5>

                        <!-- ব্র্যান্ড এবং রেটিং (এবার সম্পূর্ণ পাশাপাশি - Flex Row) -->
                        <div class="flex items-center justify-between gap-1 mb-1.5 border-b border-slate-50 pb-1">
                            <span class="text-[9px] font-extrabold text-slate-400 truncate max-w-[65px] uppercase tracking-wide">
                                {{ $product->brand->name ?? 'Generic' }}
                            </span>
                            <div class="flex items-center gap-0.5 text-amber-500 text-[9px] flex-shrink-0">
                                <i class="fa-solid fa-star text-[8px]"></i>
                                <span class="font-black text-slate-800">{{ $product->rating ?? '0.0' }}</span>
                            </div>
                        </div>

                        <!-- প্রাইস -->
                        <div class="text-xs font-black text-slate-900 leading-tight">
                            {{ $product->sale_price ? format_price($product->sale_price) : format_price($product->regular_price) }}
                            @if($product->sale_price)
                                <span class="text-[9px] text-slate-400 line-through font-medium block">{{ format_price($product->regular_price) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- ছোট অ্যাকশন বাটন -->
                    <div class="mt-2 pt-1 border-t border-slate-50">
                        @if($product->affiliate_url)
                            <a href="{{ $product->affiliate_url }}" target="_blank" class="no-underline block text-center py-1.5 bg-blue-600 text-white rounded-lg font-bold text-[9px] uppercase tracking-wide shadow-sm">
                                Buy Store
                            </a>
                        @else
                            <a href="{{ route('product.details', $product->slug) }}" class="no-underline block text-center py-1.5 bg-slate-100 text-slate-700 rounded-lg font-bold text-[9px] uppercase tracking-wide">
                                Details
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- মোবাইল স্পেসিফিকেশন এবং প্রোস (কম প্যাডিং ও স্পেস) -->
        <!-- মোবাইল স্পেসিফিকেশন এবং প্রোস (ডাইনামিক কলাম - ৩টি প্রোডাক্টই এক লাইনে থাকবে) -->
        <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-3 space-y-2">
            <h6 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest border-b pb-1.5 mb-1">Full Specifications</h6>

            <!-- ডায়নামিক স্পেসিফিকেশনসমূহ -->
            @foreach($comparisonFields as $field)
                <div class="bg-slate-50/50 p-2 rounded-lg border border-slate-100/60">
                    <span class="text-[10px] font-bold text-slate-500 block mb-1">{{ $field->name }}</span>

                    <!-- ডাইনামিক কলাম গ্রিড (count($products) অনুযায়ী কলাম হবে, ৩টি থাকলে ৩টি পাশাপাশি) -->
                    <div class="grid @if(count($products) == 3) grid-cols-3 @else grid-cols-2 @endif gap-1 text-center items-center">
                        @foreach($products as $product)
                            @php
                                $linkedField = $product->specifications->where('spec_name', $field->name)->first();
                            @endphp
                            <div class="text-[10px] font-semibold text-slate-800 break-words px-0.5 leading-tight">
                                {{ $linkedField && $linkedField->spec_value ? $linkedField->spec_value : '—' }}
                            </div>
                        @endforeach
                    </div>
                </div>
        @endforeach

        <!-- Key Benefits / Pros (এটিও ৩ কলামে পাশাপাশি ফিক্স করা হলো) -->
            <div class="bg-slate-50/50 p-2 rounded-lg border border-slate-100/60">
                <span class="text-[10px] font-bold text-slate-500 block mb-1.5">Key Benefits (Pros)</span>
                <div class="grid @if(count($products) == 3) grid-cols-3 @else grid-cols-2 @endif gap-1 text-start">
                    @foreach($products as $product)
                        <div class="text-[9px] text-emerald-900 bg-emerald-50/50 border border-emerald-100/50 p-1 rounded-md whitespace-pre-line leading-tight font-medium line-clamp-4">
                            @if($product->pros)
                                {!! $product->pros !!}
                            @else
                                <i class="fa-solid fa-circle-check text-emerald-500 text-[8px] me-0.5"></i> Top Rated
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ২. ডেস্কটপ ভিউ: আল্ট্রা-প্রিমিয়াম ম্যাট্রিক্স টেবিল (Unchanged) -->
    <!-- ========================================== -->
    <div class="hidden md:block w-full overflow-x-auto rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 bg-white">
        <table class="table align-middle mb-0 min-w-[900px] border-collapse">
            <thead>
            <tr class="border-b border-slate-100 sticky top-0 bg-white/80 backdrop-blur-md z-10">
                <th class="p-4 bg-slate-50/50 text-slate-400 font-extrabold text-[11px] tracking-widest uppercase text-start ps-8 align-middle" style="width: 22%;">
                    Features Matrix
                </th>
                @foreach($products as $index => $product)
                    <th class="p-6 text-center transition-all relative align-top {{ $index === 0 ? 'bg-blue-50/20' : '' }}" style="width: calc(78% / {{ count($products) }});">
                        <div class="min-h-[35px] d-flex justify-content-center align-items-center mb-3">
                            @if($index === 0)
                                <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-[10px] font-black px-3.5 py-1.5 rounded-full uppercase tracking-widest shadow-md shadow-orange-500/20">
                                        <i class="fa-solid fa-fire-flame-curved me-1"></i> Best Value
                                    </span>
                            @endif
                        </div>
                        <div class="mb-2 bg-gradient-to-b from-slate-50 to-white p-4 rounded-3xl border border-slate-100/80 inline-block shadow-sm group overflow-hidden relative">
                            <img src="{{ asset($product->featured_image ?? 'placeholder.png') }}" class="img-fluid mx-auto transition-transform duration-500 ease-out group-hover:scale-105" style="max-height: 130px; object-fit: contain;">
                        </div>
                        <div class="font-extrabold text-slate-800 text-sm line-clamp-2 px-3 h-11 leading-snug tracking-tight hover:text-blue-600 transition-colors cursor-pointer" title="{{ $product->title }}">
                            {{ $product->title }}
                        </div>
                        <button type="button" data-id="{{ $product->id }}" class="btn-remove-compare text-white text-[11px] bg-danger text-slate-400 hover:text-red-500 bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg border-0 transition-all duration-200 font-semibold cursor-pointer d-inline-flex align-items-center gap-1.5">
                            <i class="fa-solid fa-xmark text-[10px]"></i> Remove
                        </button>
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/70">
            <!-- Price -->
            <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                <td class="p-3 font-bold text-slate-800 text-sm ps-8">Price Breakdown</td>
                @foreach($products as $index => $product)
                    <td class="p-4 text-center {{ $index === 0 ? 'bg-blue-50/10' : '' }}">
                        @if($product->sale_price)
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ format_price($product->sale_price) }}</span>
                                <span class="text-slate-400 font-medium text-xs line-through mt-0.5">{{ format_price($product->regular_price) }}</span>
                            </div>
                        @else
                            <span class="text-2xl font-black text-slate-900 tracking-tight">{{ $product->regular_price ? format_price($product->regular_price) : 'N/A' }}</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            <!-- Rating -->
            <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                <td class="p-3 font-bold text-slate-800 text-sm ps-8">User Satisfaction</td>
                @foreach($products as $index => $product)
                    <td class="p-3 text-center {{ $index === 0 ? 'bg-blue-50/10' : '' }}">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl py-2 px-4 d-inline-flex align-items-center gap-2 shadow-inner">
                                <span class="stars text-amber-400 text-xs gap-0.5 d-inline-flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($product->rating >= $i) <i class="fa-solid fa-star"></i>
                                        @elseif($product->rating >= ($i - 0.5)) <i class="fa-solid fa-star-half-stroke"></i>
                                        @else <i class="fa-regular fa-star text-slate-200"></i>
                                        @endif
                                    @endfor
                                </span>
                            <span class="text-xs font-black text-slate-800">{{ $product->rating ?? '0.0' }}</span>
                        </div>
                    </td>
                @endforeach
            </tr>
            <!-- Brand -->
            <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                <td class="p-3 font-bold text-slate-800 text-sm ps-8">Manufacturer</td>
                @foreach($products as $index => $product)
                    <td class="p-3 text-center {{ $index === 0 ? 'bg-blue-50/10' : '' }} text-slate-700 font-semibold text-sm">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1.5 rounded-xl text-xs font-bold tracking-wide">
                                {{ $product->brand->name ?? 'Generic' }}
                            </span>
                    </td>
                @endforeach
            </tr>
            <!-- Dynamic Specs -->
            @foreach($comparisonFields as $field)
                <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                    <td class="p-3 font-bold text-slate-800 text-sm ps-8">{{ $field->name }}</td>
                    @foreach($products as $index => $product)
                        <td class="p-3 text-center {{ $index === 0 ? 'bg-blue-50/10' : '' }} text-sm">
                            @php
                                $linkedField = $product->specifications->where('spec_name', $field->name)->first();
                            @endphp
                            @if($linkedField && $linkedField->spec_value)
                                <span class="font-semibold text-slate-800 tracking-tight">{{ $linkedField->spec_value }}</span>
                            @else
                                <span class="text-slate-300 font-bold">—</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            <!-- Pros -->
            <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                <td class="p-3 font-bold text-slate-800 text-sm ps-8 align-top pt-5">Key Benefits</td>
                @foreach($products as $index => $product)
                    <td class="p-3 {{ $index === 0 ? 'bg-blue-50/10' : '' }} text-xs text-slate-700 align-top">
                        <div class="p-3 bg-emerald-50/30 border border-emerald-100/60 rounded-2xl min-h-[70px]">
                            @if($product->pros)
                                <div class="leading-relaxed text-emerald-900 font-medium">
                                    {!! $product->pros !!}
                                </div>
                            @else
                                <ul class="list-unstyled m-0 d-flex flex-column gap-3 text-emerald-900 font-semibold text-start">
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i>
                                        <span>Premium Grade Production Quality</span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i>
                                        <span>Top-Tier Market Demand</span>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </td>
                @endforeach
            </tr>
            <!-- CTAs -->
            <tr class="bg-slate-50/30">
                <td class="p-2"></td>
                @foreach($products as $index => $product)
                    <td class="p-3 text-center {{ $index === 0 ? 'bg-blue-50/10' : '' }}">
                        @if($product->affiliate_url)
                            <a href="{{ $product->affiliate_url }}" target="_blank" class="no-underline d-inline-flex align-items-center justify-content-center gap-2 px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl shadow-lg shadow-blue-600/10 hover:shadow-xl hover:shadow-blue-600/20 hover:translate-y-[-1px] transition-all w-full max-w-[200px] font-bold text-xs uppercase tracking-wide">
                                Get on {{ $product->affiliate_network ?? 'Store' }} <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-80"></i>
                            </a>
                        @else
                            <a href="{{ route('product.details', $product->slug) }}" class="no-underline d-inline-flex align-items-center justify-content-center px-6 py-3.5 bg-white hover:bg-slate-900 text-slate-800 hover:text-white rounded-2xl shadow-sm border border-slate-200 transition-all w-full max-w-[200px] font-bold text-xs uppercase tracking-wide">
                                View Details
                            </a>
                        @endif
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
@endif
