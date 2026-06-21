@extends('frontEnd.layout.app')
@section('title', $product->title ?? 'Product Details')
@section('body')
    <section class="py-8">
        <div class="container-x grid lg:grid-cols-2 gap-10">
            <div data-aos="fade-right">
                <div class="card-premium p-4" style="height: 100%">
                    <div class="swiper gallery-swiper rounded-xl overflow-hidden relative" style="height: 80%">
                        <div class="swiper-wrapper" id="galleryWrap">
                            <div class="swiper-slide aspect-video grid place-items-center bg-slate-50 overflow-hidden">
                                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}" alt="{{ $product->title ?? 'Product Image' }}" class="w-full h-full object-contain p-2">
                            </div>
                            @foreach($product->images as $image)
                            <div class="swiper-slide aspect-video grid place-items-center bg-slate-50 overflow-hidden">
                                <img src="{{ asset($image->image ?? 'frontEnd/assets/default.png') }}" alt="{{ $product->title ?? 'Product Image' }}" class="w-full h-full object-contain p-2">
                            </div>
                            @endforeach
                        </div>
                        <button class="gallery-prev absolute left-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-left"></i></button>
                        <button class="gallery-next absolute right-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-right"></i></button>
                    </div>
                    <div class="swiper gallery-thumbs mt-3">
                        <div class="swiper-wrapper" id="thumbWrap">
                            <div class="swiper-slide w-20 h-20 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer p-1">
                                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}" class="w-full h-full object-contain">
                            </div>
                            @foreach($product->images as $image)
                                <div class="swiper-slide w-20 h-20 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer p-1">
                                    <img src="{{ asset($image->image ?? 'frontEnd/assets/default.png') }}" class="w-full h-full object-contain">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-left">
                <div class="flex items-center gap-2 mb-3">
                    @if(request()->has('top_pick'))
                    <span class="badge-pick"><i class="fa-solid fa-crown me-1"></i>#1 Top Pick</span>
                    @endif
                    <span class="badge-editor"><i class="fa-solid fa-award me-1"></i>Editor's Choice</span>
                </div>
                <h1 class="font-display text-3xl md:text-4xl font-extrabold text-slate-900">{{ $product->title ?? 'AuraSound Pro 3 Wireless Earbuds' }}</h1>

                <div class="flex items-center gap-3 mt-3">
                    <span class="stars text-amber-400">
                        @php $rating = round($product->reviews_avg_rating ?? 4.5); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid {{ $i <= $rating ? 'fa-star' : 'fa-star-half-stroke' }}"></i>
                        @endfor
                    </span>
                    <span class="text-slate-500">{{ number_format($product->reviews_avg_rating ?? 4.8, 1) }} · {{ $product->reviews_count ?? '2,840' }} reviews</span>
                    <span class="text-success font-semibold"><i class="fa-solid fa-circle-check"></i> Verified tested</span>
                </div>

                <p class="text-slate-600 mt-4">
                    {{ $product->short_description ?? "" }}
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6" id="scoreGrid">
                    @foreach($product->specifications as $spec)
                    <div class="card-premium py-3 px-2 text-center">
                        <div class="text-xs text-slate-400 font-bold uppercase">{{$spec->spec_name}}</div>
                        <div class="text-primary mt-1">
                            <span class="text-dark" style="font-size: 12px">{{$spec->spec_value}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="card-premium p-5 mt-6">
                    <div class="flex items-end gap-3">
                        <span class="text-4xl font-extrabold text-slate-900">{{ format_price($product->sale_price)  ?? '' }}</span>
                        @if(isset($product->regular_price) && $product->regular_price > ($product->sale_price ?? 0))
                            @php
                                // সূত্র: ((Regular Price - Sale Price) / Regular Price) * 100
                                $discount = (($product->regular_price - $product->sale_price) / $product->regular_price) * 100;
                            @endphp
                            <span class="text-slate-400 line-through text-xl">{{ format_price($product->regular_price) }}</span>
                            <span class="badge-deal mb-2">Save {{ round($discount) }}%</span>
                        @elseif(!isset($product))
                        <!-- 💡 ব্যাকআপ স্ট্যাটিক ডেটা (যদি $product অবজেক্টই না থাকে) -->
                            <span class="text-slate-400 line-through text-xl">$229</span>
                            <span class="badge-deal mb-2">Save 35%</span>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 mt-4">
                        <a href="{{ $product->affiliate_url ?? '#' }}" target="_blank" class="btn-grad flex-1 text-center no-underline">
                            <i class="fa-solid fa-cart-shopping me-2"></i>
                            Check Price on {{$product->affiliate_network}}
                        </a>
{{--                        <a href="{{ $product->bestbuy_link ?? '#' }}" target="_blank" class="btn-ghost flex-1 text-center no-underline">View at BestBuy</a>--}}
                    </div>
                    <p class="text-xs text-slate-400 mt-3 mb-0"><i class="fa-solid fa-circle-info me-1"></i>We may earn a commission, at no extra cost to you.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="container-x grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Description</h2>
                    <div class="grid sm:grid-cols-1 gap-4" align="justify">
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6" data-aos="fade-up">
                    <div class="card-premium p-6">
                        <h3 class="font-bold text-success mb-4"><i class="fa-solid fa-thumbs-up me-2"></i>Pros</h3>
                        <ul class="list-none p-0 space-y-3" id="prosList">
                            {!! $product->pros !!}
                            {{--<li class="text-slate-600 text-sm"><i class="fa-solid fa-check text-success me-2"></i> Exceptional ANC for the price segment</li>
                            <li class="text-slate-600 text-sm"><i class="fa-solid fa-check text-success me-2"></i> Comfortable fit for long listening sessions</li>--}}
                        </ul>
                    </div>
                    <div class="card-premium p-6">
                        <h3 class="font-bold text-red-500 mb-4"><i class="fa-solid fa-thumbs-down me-2"></i>Cons</h3>
                        <ul class="list-none p-0 space-y-3" id="consList">
                            {!! $product->cons !!}
                            {{--<li class="text-slate-600 text-sm"><i class="fa-solid fa-xmark text-danger me-2"></i> Companion app UI can feel cluttered</li>
                            <li class="text-slate-600 text-sm"><i class="fa-solid fa-xmark text-danger me-2"></i> Case lacks wireless charging</li>--}}
                        </ul>
                    </div>
                </div>

                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Specifications</h2>
                    <div class="overflow-x-auto">
                        <table class="table mb-0 width-full align-middle text-sm" id="specTable">
                            <tbody>
                                @foreach($product->specifications as $spec)
                                <tr class="border-b">
                                    <td class="p-3 fw-bold text-slate-500">{{$spec->spec_name}}</td>
                                    <td class="p-3 text-slate-800 font-semibold">{{$spec->spec_value}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">User Reviews</h2>
                    <div class="space-y-5" id="reviewList">
                        @forelse($product->reviews ?? [] as $rev)
                            <div class="border-b pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-slate-800">{{ $rev->name }}</span>
                                    <span class="text-warning text-xs">
                                        @for($j=1; $j<=5; $j++)
                                            {{ $j <= $rev->rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-slate-600 text-sm italic mt-2">"{{ $rev->review }}"</p>
                                <span class="text-xs text-slate-400 d-block mt-1">{{ $rev->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-center"><span class="font-bold text-slate-800">Sarah Jenkins</span><span class="text-warning text-xs">★★★★★</span></div>
                                <p class="text-slate-600 text-sm italic mt-2">"Absolutely love these. The ANC rivals my much more expensive over-ear headphones."</p>
                            </div>
                        @endforelse
                    </div>
                    <a href="#" class="btn-ghost mt-5 no-underline">Load more reviews</a>
                </div>

                <div data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Product FAQ</h2>
                    <div class="space-y-4">
                        @foreach($product->faqs as $faq)
                        <div class="card-premium p-4" data-faq>
                            <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
                                <span class="font-bold text-slate-900">{{$faq->question}}</span>
                                <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
                            </button>
                            <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">{{$faq->answer}}</p></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="sticky space-y-6" style="top:90px">
                    <div class="card-premium p-6" data-aos="fade-left">
                        <h3 class="font-bold mb-3">Best Deal Today</h3>
                        <div class="text-3xl font-extrabold text-slate-900">{{ format_price($product->sale_price) ?? '' }} <span class="text-slate-400 line-through text-lg">{{ format_price($product->regular_price) ?? '' }}</span></div>
                        <div class="mt-2 text-sm text-slate-500" data-countdown>Deal ends in <strong><span data-h>00</span>h <span data-m>00</span>m <span data-s>00</span>s</strong></div>
                        <a href="{{ $product->affiliate_url ?? '#' }}" target="_blank" class="btn-grad w-full text-center mt-4 no-underline block">Get This Deal</a>
                        <div class="mt-3 glass rounded-xl p-3 text-center text-sm">Coupon: <strong>{{ $product->coupon ?? 'EXAMPLE9' }}</strong></div>
                    </div>
                    <div class="card-premium p-6" data-aos="fade-left">
                        <h3 class="font-bold mb-2">Editor's Verdict</h3>
                        <div class="text-5xl font-extrabold text-gradient">{{ number_format($product->editor_score ?? 9.4, 1) }}</div>
                        <p class="text-sm text-slate-500 mt-2">Best balance of sound, comfort and value we tested this year.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="container-x">
            <h2 class="font-display text-3xl font-extrabold mb-8" data-aos="fade-up">Related Products</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts ?? [] as $relProduct)
                    @include('frontEnd.component.productcard', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
    </section>
@endsection
