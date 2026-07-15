@extends('frontEnd.layout.app')
@section('title', $product->title ?? 'Product Details')
@section('body')
    <section class="py-4 md:py-8">
        <div class="container px-4 mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
            <!-- Left Side: Image Gallery -->
            <div data-aos="fade-right" class="w-full overflow-hidden">
                <div class="card-premium p-2 md:p-3 h-full">
                    <!-- Main Slider -->
                    <div class="swiper gallery-swiper rounded-xl overflow-hidden relative aspect-square sm:aspect-[4/3] lg:aspect-square bg-slate-50">
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
                        <!-- Navigation Buttons (Hidden on mobile for cleaner look, visible on sm) -->
                        <button class="gallery-prev absolute left-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass hidden sm:grid place-items-center"><i class="fa-solid fa-angle-left"></i></button>
                        <button class="gallery-next absolute right-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass hidden sm:grid place-items-center"><i class="fa-solid fa-angle-right"></i></button>
                    </div>

                    <!-- Thumbnails Slider -->
                    <div class="swiper gallery-thumbs mt-3 overflow-hidden">
                        <div class="swiper-wrapper flex flex-row" id="thumbWrap">
                            <!-- Featured Image Thumb -->
                            <div class="swiper-slide w-16 h-16 md:w-20 md:h-20 flex-shrink-0 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer">
                                <img alt="{{$product->title}}" src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <!-- Gallery Images Thumbs -->
                            @foreach($product->images as $image)
                                <div class="swiper-slide w-16 h-16 md:w-20 md:h-20 flex-shrink-0 rounded-lg overflow-hidden border bg-slate-50 cursor-pointer">
                                    <img alt="{{$product->title}}" src="{{ asset($image->image ?? 'frontEnd/assets/default.png') }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Product Info -->
            <div data-aos="fade-left" class="flex flex-col justify-content-evenly">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @if(request()->has('top_pick'))
                            <span class="badge-pick text-xs px-2 py-1"><i class="fa-solid fa-crown me-1"></i>#1 Top Pick</span>
                        @endif
                        <span class="badge-editor text-xs px-2 py-1"><i class="fa-solid fa-award me-1"></i>Editor's Choice</span>
                    </div>

                    <h1 class="font-display text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $product->title ?? 'AuraSound Pro 3 Wireless Earbuds' }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3 mt-3 text-sm">
                        <span class="stars text-amber-400">
                            @php $rating = round($product->reviews_avg_rating ?? 4.5); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid {{ $i <= $rating ? 'fa-star' : 'fa-star-half-stroke' }}"></i>
                            @endfor
                        </span>
                        <span class="text-slate-500">{{ number_format($product->reviews_avg_rating ?? 4.8, 1) }} · {{ $product->reviews_count ?? '2,840' }} reviews</span>
                        <span class="text-success font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Verified</span>
                    </div>

                    <p class="text-slate-600 mt-4 text-sm md:text-base leading-relaxed">
                        {{ $product->short_description ?? "" }}
                    </p>
                </div>
                <!-- Price Box -->
                <div class="card-premium p-4 md:p-5 mt-6">
                    <div class="flex flex-wrap items-end gap-2 md:gap-3">
                        <span class="text-3xl md:text-4xl font-extrabold text-slate-900">{{ format_price($product->sale_price)  ?? '' }}</span>
                        @if(isset($product->regular_price) && $product->regular_price > ($product->sale_price ?? 0))
                            @php
                                $discount = (($product->regular_price - $product->sale_price) / $product->regular_price) * 100;
                            @endphp
                            <span class="text-slate-400 line-through text-lg md:text-xl">{{ format_price($product->regular_price) }}</span>
                            <span class="badge-deal mb-1 md:mb-2 text-xs">Save {{ round($discount) }}%</span>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-4">
                        <a href="{{ $product->affiliate_url ?? '#' }}" target="_blank" class="btn-grad w-full text-center no-underline py-3 px-4 rounded-xl font-bold flex items-center justify-center">
                            <i class="fa-solid fa-cart-shopping me-2"></i>
                            Check Price on {{ $product->affiliate_network ?? 'Store' }}
                        </a>
                    </div>
                    <p class="text-[11px] md:text-xs text-slate-400 mt-3 mb-0 flex items-center"><i class="fa-solid fa-circle-info me-1"></i>We may earn a commission, at no extra cost to you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Section -->
    <section class="py-6 md:py-8">
        <div class="container px-4 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left 2 Columns -->
            <div class="lg:col-span-2 space-y-6 md:space-y-8">

                <!-- Description -->
                <div class="card-premium p-4 md:p-6" data-aos="fade-up">
                    <h2 class="font-display text-xl md:text-2xl font-extrabold mb-4">Description</h2>
                    <div class="prose max-w-none text-slate-700 text-sm md:text-base leading-relaxed break-words" align="justify">
                        {!! $product->description !!}
                    </div>
                </div>

                <!-- Pros & Cons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6" data-aos="fade-up">
                    <div class="card-premium p-4 md:p-6">
                        <h3 class="font-bold text-success mb-3 flex items-center"><i class="fa-solid fa-thumbs-up me-2"></i>Pros (Good Points)</h3>
                        <div class="text-slate-600 text-sm break-words" align="justify">
                            {!! $product->pros !!}
                        </div>
                    </div>
                    <div class="card-premium p-4 md:p-6">
                        <h3 class="font-bold text-red-500 mb-3 flex items-center"><i class="fa-solid fa-thumbs-down me-2"></i>Cons (Bad Points)</h3>
                        <div class="text-slate-600 text-sm break-words" align="justify">
                            {!! $product->cons !!}
                        </div>
                    </div>
                </div>

                <!-- Specifications Table -->
                <div class="card-premium p-4 md:p-6" data-aos="fade-up">
                    <h2 class="font-display text-xl md:text-2xl font-extrabold mb-4">Specifications</h2>
                    <div class="overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0">
                        <table class="w-full mb-0 align-middle text-sm" id="specTable">
                            <tbody>
                            @foreach($product->specifications as $spec)
                                <tr class="border-b last:border-0">
                                    <td class="py-3 pr-4 font-bold text-slate-500 w-1/3 min-w-[100px]">{{$spec->spec_name}}</td>
                                    <td class="py-3 text-slate-800 font-semibold w-2/3 break-words">{{$spec->spec_value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User Reviews -->
                <div class="card-premium p-4 md:p-6 bg-white rounded-2xl shadow-sm" data-aos="fade-up">
                    <h2 class="font-display text-xl font-black text-slate-900 mb-4 tracking-tight">User Reviews</h2>

                    <div class="divide-y divide-slate-100 space-y-3" id="reviewList">
                        @foreach($reviews ?? [] as $rev)
                            @include('frontEnd.product.single_review', ['rev' => $rev])
                        @endforeach
                    </div>

                    @if(isset($reviews) && $reviews->hasMorePages())
                        <button type="button"
                                id="btnLoadMoreReviews"
                                data-product="{{ $product->id }}"
                                data-page="1"
                                class="w-full mt-4 py-3 bg-slate-50 hover:bg-slate-900 border border-slate-200/60 hover:border-slate-900 text-slate-700 hover:text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-200 shadow-sm cursor-pointer block text-center">
                            <span class="btn-text">Load more reviews</span>
                            <span class="spinner d-none"><i class="fa-solid fa-spinner fa-spin ms-1"></i></span>
                        </button>
                    @endif
                </div>

                <!-- Product FAQ -->
                <div data-aos="fade-up">
                    <h2 class="font-display text-xl md:text-2xl font-extrabold mb-4">Product FAQ</h2>
                    <div class="space-y-3 md:space-y-4">
                        @foreach($product->faqs as $faq)
                            <div class="card-premium p-4" data-faq>
                                <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0 gap-2">
                                    <span class="font-bold text-slate-900 text-sm md:text-base">{{$faq->question}}</span>
                                    <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform flex-shrink-0"></i>
                                </button>
                                <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease">
                                    <p class="text-slate-500 pt-3 mb-0 text-sm leading-relaxed">{{$faq->answer}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (Sticky on Desktop, Bottom/Normal on Mobile) -->
            <aside class="lg:col-span-1">
                <div class="lg:sticky space-y-6" style="top:90px">
                    <div class="card-premium p-4 md:p-6" >
                        <h3 class="font-bold mb-3 text-lg">Best Deal Today</h3>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-2xl md:text-3xl font-extrabold text-slate-900">{{ format_price($product->sale_price) ?? '' }}</span>
                            <span class="text-slate-400 line-through text-base md:text-lg">{{ format_price($product->regular_price) ?? '' }}</span>
                        </div>
                        <div class="mt-2 text-xs md:text-sm text-slate-500" data-countdown>Deal ends in <strong><span data-h>00</span>h <span data-m>00</span>m <span data-s>00</span>s</strong></div>

                        <a href="{{ $product->affiliate_url ?? '#' }}"
                           target="_blank"
                           rel="noopener noreferrer nofollow"
                           data-product-id="{{ $product->id ?? '' }}"
                           class="btn-grad w-full text-center mt-4 no-underline block py-3 rounded-xl font-bold">
                            Get This Deal
                        </a>
                        <div class="mt-3 glass rounded-xl p-3 text-center text-xs md:text-sm">Coupon: <strong class="text-slate-900">{{ $product->coupon ?? 'Not Available' }}</strong></div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- Related Products -->
    <section class="py-8 md:py-12 bg-white">
        <div class="container px-4 mx-auto">
            <h2 class="font-display text-2xl md:text-3xl font-extrabold mb-6 md:mb-8" data-aos="fade-up">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($relatedProducts ?? [] as $relProduct)
                    @include('frontEnd.component.productcard', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sticky mobile CTA -->
    <div class="sticky-cta lg:hidden p-3">
        <div class="glass-dark rounded-2xl p-3 flex items-center justify-between gap-3 mx-3">
            <div class="text-white text-sm"><strong>Today's #1 Pick</strong><br><span class="text-white/70">Save {{ isset($discount) ? round($discount) : 0 }}% — ends soon</span></div>
            <a href="{{ $product->affiliate_url ?? '#' }}" class="btn-accent text-sm no-underline whitespace-nowrap">View Deal</a>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Swiper Initialization Backup (In case it breaks on responsive)
            if (typeof Swiper !== 'undefined') {
                var galleryThumbs = new Swiper('.gallery-thumbs', {
                    spaceBetween: 10,
                    slidesPerView: 'auto',
                    freeMode: true,
                    watchSlidesProgress: true,
                });
                var galleryTop = new Swiper('.gallery-swiper', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.gallery-next',
                        prevEl: '.gallery-prev',
                    },
                    thumbs: {
                        swiper: galleryThumbs
                    }
                });
            }

            $(document).on('click', '#btnLoadMoreReviews', function (e) {
                e.preventDefault();

                let $btn = $(this);
                let productId = $btn.data('product');
                let nextPage = parseInt($btn.data('page')) + 1;

                let $text = $btn.find('.btn-text');
                let $spinner = $btn.find('.spinner');

                let baseRoute = "{{ route('product.reviews', ':id') }}";
                let ajaxUrl = baseRoute.replace(':id', productId) + "?page=" + nextPage;

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
