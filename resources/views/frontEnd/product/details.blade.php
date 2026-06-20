@extends('frontEnd.layout.app')
@section('title','Product Details')
@section('body')
    <section class="py-8">
        <div class="container-x grid lg:grid-cols-2 gap-10">
            <!-- Gallery -->
            <div data-aos="fade-right">
                <div class="card-premium p-4">
                    <div class="swiper gallery-swiper rounded-xl overflow-hidden">
                        <div class="swiper-wrapper" id="galleryWrap"></div>
                        <button class="gallery-prev absolute left-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-left"></i></button>
                        <button class="gallery-next absolute right-3 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full glass grid place-items-center"><i class="fa-solid fa-angle-right"></i></button>
                    </div>
                    <div class="swiper gallery-thumbs mt-3">
                        <div class="swiper-wrapper" id="thumbWrap"></div>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <div data-aos="fade-left">
                <div class="flex items-center gap-2 mb-3">
                    <span class="badge-pick"><i class="fa-solid fa-crown me-1"></i>#1 Top Pick</span>
                    <span class="badge-editor"><i class="fa-solid fa-award me-1"></i>Editor's Choice</span>
                </div>
                <h1 class="font-display text-3xl md:text-4xl font-extrabold">AuraSound Pro 3 Wireless Earbuds</h1>
                <div class="flex items-center gap-3 mt-3">
                    <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span>
                    <span class="text-slate-500">4.8 · 2,840 reviews</span>
                    <span class="text-success font-semibold"><i class="fa-solid fa-circle-check"></i> Verified tested</span>
                </div>
                <p class="text-slate-600 mt-4">The AuraSound Pro 3 delivers class-leading active noise cancellation, a warm balanced sound signature and an outstanding 32-hour battery life — all under $200. After 3 weeks of lab and real-world testing, it's our #1 earbud pick of 2025.</p>

                <!-- Score widget -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6" id="scoreGrid"></div>

                <!-- Pricing -->
                <div class="card-premium p-5 mt-6">
                    <div class="flex items-end gap-3">
                        <span class="text-4xl font-extrabold">$149</span>
                        <span class="text-slate-400 line-through text-xl">$229</span>
                        <span class="badge-deal mb-2">Save 35%</span>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 mt-4">
                        <a href="#" class="btn-grad flex-1 text-center no-underline"><i class="fa-solid fa-cart-shopping me-2"></i>Check Price on Amazon</a>
                        <a href="#" class="btn-ghost flex-1 text-center no-underline">View at BestBuy</a>
                    </div>
                    <p class="text-xs text-slate-400 mt-3 mb-0"><i class="fa-solid fa-circle-info me-1"></i>We may earn a commission, at no extra cost to you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Body grid -->
    <section class="py-8">
        <div class="container-x grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Features -->
                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Key Features</h2>
                    <div class="grid sm:grid-cols-2 gap-4" id="featList"></div>
                </div>

                <!-- Pros & cons -->
                <div class="grid sm:grid-cols-2 gap-6" data-aos="fade-up">
                    <div class="card-premium p-6">
                        <h3 class="font-bold text-success mb-4"><i class="fa-solid fa-thumbs-up me-2"></i>Pros</h3>
                        <ul class="list-none p-0 space-y-3" id="prosList"></ul>
                    </div>
                    <div class="card-premium p-6">
                        <h3 class="font-bold text-red-500 mb-4"><i class="fa-solid fa-thumbs-down me-2"></i>Cons</h3>
                        <ul class="list-none p-0 space-y-3" id="consList"></ul>
                    </div>
                </div>

                <!-- Specs -->
                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Specifications</h2>
                    <div class="overflow-x-auto"><table class="table mb-0" id="specTable"></table></div>
                </div>

                <!-- User reviews -->
                <div class="card-premium p-6" data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">User Reviews</h2>
                    <div class="space-y-5" id="reviewList"></div>
                    <a href="#" class="btn-ghost mt-5 no-underline">Load more reviews</a>
                </div>

                <!-- FAQ -->
                <div data-aos="fade-up">
                    <h2 class="font-display text-2xl font-extrabold mb-4">Product FAQ</h2>
                    <div class="space-y-4" id="faqWrap"></div>
                </div>
            </div>

            <!-- Sticky sidebar CTA -->
            <aside class="lg:col-span-1">
                <div class="sticky space-y-6" style="top:90px">
                    <div class="card-premium p-6" data-aos="fade-left">
                        <h3 class="font-bold mb-3">Best Deal Today</h3>
                        <div class="text-3xl font-extrabold">$149 <span class="text-slate-400 line-through text-lg">$229</span></div>
                        <div class="mt-2 text-sm text-slate-500" data-countdown>Deal ends in <strong><span data-h>00</span>h <span data-m>00</span>m <span data-s>00</span>s</strong></div>
                        <a href="#" class="btn-grad w-full text-center mt-4 no-underline">Get This Deal</a>
                        <div class="mt-3 glass rounded-xl p-3 text-center text-sm">Coupon: <strong>AURA35</strong></div>
                    </div>
                    <div class="card-premium p-6" data-aos="fade-left">
                        <h3 class="font-bold mb-2">Editor's Verdict</h3>
                        <div class="text-5xl font-extrabold text-gradient">9.4</div>
                        <p class="text-sm text-slate-500 mt-2">Best balance of sound, comfort and value we tested this year.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- Related -->
    <section class="py-12 bg-white">
        <div class="container-x">
            <h2 class="font-display text-3xl font-extrabold mb-8" data-aos="fade-up">Related Products</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" id="relatedGrid"></div>
        </div>
    </section>
@endsection

