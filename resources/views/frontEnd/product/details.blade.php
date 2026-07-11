@extends('frontEnd.layout.app')
@section('title', $product->title ?? 'Product Details')
@section('body')
    <section class="py-8">
        <div class="container-xl grid lg:grid-cols-2 gap-10">
            <div data-aos="fade-right">
                <div class="card-premium p-2" style="height: 100%">
                    <!-- Main Slider (Height 85%) -->
                    <div class="swiper gallery-swiper rounded-xl overflow-hidden relative">
                        <div class="swiper-wrapper" id="galleryWrap">
                            <!-- Featured Image -->
                            <div class="swiper-slide grid place-items-center bg-slate-50 overflow-hidden w-full h-full group cursor-zoom-in">
                                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}"
                                     alt="{{ $product->title ?? 'Product Image' }}"
                                     class="w-full h-full object-contain transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

                            <!-- Gallery Images -->
                        @foreach($product->images as $image)
                                <div class="swiper-slide grid place-items-center bg-slate-50 overflow-hidden w-full h-full group cursor-zoom-in">
                                    <img src="{{ asset($image->image ?? 'frontEnd/assets/default.png') }}"
                                         alt="{{ $product->title ?? 'Product Image' }}"
                                         class="w-full h-full object-contain transition-transform duration-500 ease-in-out group-hover:scale-110">
                                </div>
                            @endforeach
                        </div>
                        <!-- Navigation Buttons -->
                        <button class="gallery-prev absolute left-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-left"></i></button>
                        <button class="gallery-next absolute right-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-right"></i></button>
                    </div>

                    <!-- Thumbnails Slider (mt-3) -->
                    <div class="swiper gallery-thumbs mt-3">
                        <div class="swiper-wrapper" id="thumbWrap">
                            <!-- Featured Image Thumb -->
                            <div class="swiper-slide w-20 h-20 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer">
                                <!-- 💡 object-fit-cover typo fixed to object-cover -->
                                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <!-- Gallery Images Thumbs -->
                            @foreach($product->images as $image)
                                <div class="swiper-slide w-20 h-20 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer">
                                    <img src="{{ asset($image->image ?? 'frontEnd/assets/default.png') }}"
                                         class="w-full h-full object-cover">
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
                    <span class="text-success font-semibold"><i class="fa-solid fa-circle-check"></i> Verified</span>
                </div>

                <p class="text-slate-600 mt-4">
                    {{ $product->short_description ?? "" }}
                </p>

                {{--<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6" id="scoreGrid">
                    @foreach($product->specifications as $spec)
                    <div class="card-premium py-3 px-2 text-center">
                        <div class="text-xs text-slate-400 font-bold uppercase">{{$spec->spec_name}}</div>
                        <div class="text-primary mt-1">
                            <span class="text-dark" style="font-size: 12px">{{$spec->spec_value}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>--}}

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
                        <h3 class="font-bold text-success mb-4"><i class="fa-solid fa-thumbs-up me-2"></i>Pros (Good Points)</h3>
                        <ul class="list-none p-0 space-y-3" id="prosList" align="justify">
                            {!! $product->pros !!}
                            {{--<li class="text-slate-600 text-sm"><i class="fa-solid fa-check text-success me-2"></i> Exceptional ANC for the price segment</li>
                            <li class="text-slate-600 text-sm"><i class="fa-solid fa-check text-success me-2"></i> Comfortable fit for long listening sessions</li>--}}
                        </ul>
                    </div>
                    <div class="card-premium p-6">
                        <h3 class="font-bold text-red-500 mb-4"><i class="fa-solid fa-thumbs-down me-2"></i>Cons (Bad Points)</h3>
                        <ul class="list-none p-0 space-y-3" id="consList" align="justify">
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

                <div class="card-premium p-4 md:p-5 bg-white border border-slate-100 rounded-2xl shadow-sm" data-aos="fade-up">
                    <h2 class="font-display text-lg md:text-xl font-black text-slate-900 mb-3 tracking-tight">User Reviews</h2>

                    <div class="divide-y divide-slate-100 space-y-3" id="reviewList">
                        {{-- কন্ট্রোলার থেকে পিজিনেট করা প্রথম ২টা রিভিউ এখানে লুপ হবে --}}
                        @foreach($reviews ?? [] as $rev)
                            @include('frontEnd.product.single_review', ['rev' => $rev])
                        @endforeach
                    </div>

                    {{-- ২ টার বেশি রিভিউ থাকলেই কেবল লোড মোর বাটন আসবে --}}
                    @if(isset($reviews) && $reviews->hasMorePages())
                        <button type="button"
                                id="btnLoadMoreReviews"
                                data-product="{{ $product->id }}"
                                data-page="1"
                                class="w-full mt-4 py-2.5 bg-slate-50 hover:bg-slate-900 border border-slate-200/60 hover:border-slate-900 text-slate-700 hover:text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-200 shadow-sm cursor-pointer block text-center">
                            <span class="btn-text">Load more reviews</span>
                            <span class="spinner d-none"><i class="fa-solid fa-spinner fa-spin ms-1"></i></span>
                        </button>
                    @endif
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
                        <a href="{{ $product->affiliate_url ?? '#' }}"
                           target="_blank"
                           rel="noopener noreferrer nofollow"
                           data-product-id="{{ $product->id ?? '' }}"
                           class="btn-grad w-full text-center mt-4 no-underline block">
                            Get This Deal
                        </a>
                        <div class="mt-3 glass rounded-xl p-3 text-center text-sm">Coupon: <strong>{{ $product->coupon ?? 'Not Available' }}</strong></div>

                    </div>
                    {{--<div class="card-premium p-6" data-aos="fade-left">
                        <h3 class="font-bold mb-2">Editor's Verdict</h3>
                        <div class="text-5xl font-extrabold text-gradient">{{ number_format($product->editor_score ?? 9.4, 1) }}</div>
                        <p class="text-sm text-slate-500 mt-2">Best balance of sound, comfort and value we tested this year.</p>
                    </div>--}}
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
@push('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#btnLoadMoreReviews', function (e) {
                e.preventDefault();

                let $btn = $(this);
                let productId = $btn.data('product');
                let nextPage = parseInt($btn.data('page')) + 1;

                let $text = $btn.find('.btn-text');
                let $spinner = $btn.find('.spinner');

                // লারাভেল রাউট ট্রিকস (URL এর পরিবর্তে Route Name ব্যবহার)
                let baseRoute = "{{ route('product.reviews', ':id') }}";
                let ajaxUrl = baseRoute.replace(':id', productId) + "?page=" + nextPage;

                // লোডিং স্টেট চালু
                $text.text('Loading...');
                $spinner.removeClass('d-none');
                $btn.prop('disabled', true);

                $.ajax({
                    url: ajaxUrl,
                    type: "GET",
                    success: function (response) {
                        if (response.html && response.html.trim() !== '') {
                            $('#reviewList').append(response.html);
                            $btn.data('page', nextPage);

                            $text.text('Load more reviews');
                            $spinner.addClass('d-none');
                            $btn.prop('disabled', false);

                            if (!response.hasMorePages) {
                                $btn.fadeOut(300, function() { $(this).remove(); });
                            }
                        } else {
                            $btn.fadeOut(300, function() { $(this).remove(); });
                        }
                    },
                    error: function () {
                        alert('Failed to load reviews.');
                        $text.text('Load more reviews');
                        $spinner.addClass('d-none');
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
