@extends('frontEnd.layout.app')
@section('title','Home')
@section('body')
    <section class="relative overflow-hidden bg-hero pt-16 pb-24">
        <div class="blob bg-secondary w-72 h-72 -top-10 -left-10"></div>
        <div class="blob bg-accent w-80 h-80 top-20 right-0"></div>
        <div class="container-x relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <span class="eyebrow"><i class="fa-solid fa-shield-halved me-1"></i> Trusted by 2.4M+ smart shoppers</span>
                    <h1 class="font-display text-4xl md:text-6xl font-extrabold leading-tight mt-5 text-slate-900">
                        Buy smarter with <span class="text-gradient">expert-tested</span> reviews & real deals
                    </h1>
                    <p class="text-lg text-slate-600 mt-5 max-w-xl">
                        We independently test, score and compare thousands of products so you never overpay or pick the wrong one again.
                    </p>

                    <!-- Search bar -->
                    <form data-form class="mt-7 glass rounded-2xl p-2 flex items-center shadow-soft max-w-xl">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 px-3"></i>
                        <input type="text" placeholder="Search 5,000+ reviews — e.g. 'best wireless earbuds'" class="flex-1 bg-transparent border-0 outline-none py-2 text-slate-700" />
                        <button class="btn-grad text-sm">Search</button>
                    </form>
                    <p data-form-note class="hidden text-success text-sm mt-2"><i class="fa-solid fa-check"></i> Showing top matches for your search.</p>

                    <div class="flex flex-wrap items-center gap-6 mt-8">
                        <div><div class="text-2xl font-extrabold text-slate-900">5,000+</div><div class="text-sm text-slate-500">Reviews</div></div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div><div class="text-2xl font-extrabold text-slate-900">98%</div><div class="text-sm text-slate-500">Accuracy</div></div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div><div class="text-2xl font-extrabold text-slate-900">4.9 <i class="fa-solid fa-star text-amber-400 text-base"></i></div><div class="text-sm text-slate-500">User rating</div></div>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left">
                    <div class="card-premium p-6 float">
                        <div class="flex items-center justify-between mb-4">
                            <span class="badge-pick"><i class="fa-solid fa-crown me-1"></i> #1 Top Pick 2025</span>
                            <span class="stars text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-violet-50 aspect-video grid place-items-center text-6xl text-primary">
                            <i class="fa-solid fa-headphones-simple"></i>
                        </div>
                        <h3 class="font-display font-bold text-lg mt-4">AuraSound Pro 3 Earbuds</h3>
                        <p class="text-sm text-slate-500">Best noise cancelling under $200</p>
                        <div class="flex items-center justify-between mt-4">
                            <div><span class="text-2xl font-extrabold text-slate-900">$149</span> <span class="text-slate-400 line-through text-sm">$229</span></div>
                            <a href="product-details.html" class="btn-accent text-sm no-underline">View Deal <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    <div class="card-premium p-4 absolute -bottom-6 -left-4 w-48 hidden md:block" data-aos="zoom-in" data-aos-delay="300">
                        <div class="flex items-center gap-2"><span class="w-9 h-9 rounded-full bg-success/15 grid place-items-center text-success"><i class="fa-solid fa-bolt"></i></span>
                            <div><div class="text-xs text-slate-500">Saved this week</div><div class="font-bold text-slate-900">$182,400</div></div></div>
                    </div>
                </div>
            </div>

            <!-- Trust badges / brand marquee -->
            <div class="mt-16 overflow-hidden">
                <p class="text-center text-sm text-slate-400 mb-5 uppercase tracking-widest">As featured & compared across</p>
                <div class="swiper brand-swiper">
                    <div class="swiper-wrapper items-center" id="brandWrap"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================== TOP CATEGORIES ===================== -->
    <section class="py-20">
        <div class="container-x">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="eyebrow">Browse by need</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Top Categories</h2>
                <p class="text-slate-500 mt-3">Hand-curated picks across the categories people shop most.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mt-12" id="catGrid"></div>
        </div>
    </section>

    <!-- ===================== FEATURED PRODUCTS ===================== -->
    <section class="py-16 bg-white">
        <div class="container-x">
            <div class="flex items-end justify-between flex-wrap gap-4" data-aos="fade-up">
                <div>
                    <span class="eyebrow">Editor curated</span>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Featured Products</h2>
                </div>
                <a href="products.html" class="btn-ghost no-underline">View all <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10" id="featuredGrid"></div>
        </div>
    </section>

    <!-- ===================== TRENDING DEALS + COUNTDOWN ===================== -->
    <section class="py-16">
        <div class="container-x">
            <div class="rounded-3xl bg-gradient-primary text-white p-8 md:p-12 relative overflow-hidden" data-aos="zoom-in">
                <div class="blob bg-white/30 w-72 h-72 -top-20 -right-10"></div>
                <div class="grid lg:grid-cols-2 gap-8 items-center relative z-10">
                    <div>
                        <span class="badge-deal"><i class="fa-solid fa-fire me-1"></i> Flash Deal</span>
                        <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Trending Deal of the Day</h2>
                        <p class="text-white/80 mt-3 max-w-md">Editor's #1 4K monitor with a 38% verified discount. Limited stock — coupon ends soon.</p>
                        <div class="flex gap-3 mt-6" data-countdown>
                            <div class="count-box text-center"><div class="text-2xl font-extrabold" data-d>00</div><div class="text-xs">Days</div></div>
                            <div class="count-box text-center"><div class="text-2xl font-extrabold" data-h>00</div><div class="text-xs">Hrs</div></div>
                            <div class="count-box text-center"><div class="text-2xl font-extrabold" data-m>00</div><div class="text-xs">Min</div></div>
                            <div class="count-box text-center"><div class="text-2xl font-extrabold" data-s>00</div><div class="text-xs">Sec</div></div>
                        </div>
                        <div class="mt-6 flex items-center gap-3 flex-wrap">
                            <a href="product-details.html" class="btn-accent no-underline">Grab the Deal</a>
                            <span class="glass-dark px-4 py-2 rounded-full text-sm">Coupon: <strong>AFFILI38</strong></span>
                        </div>
                    </div>
                    <div class="card-premium p-6 text-slate-900">
                        <div class="rounded-xl bg-gradient-to-br from-cyan-50 to-blue-50 aspect-video grid place-items-center text-6xl text-accent"><i class="fa-solid fa-desktop"></i></div>
                        <div class="flex items-center justify-between mt-4">
                            <h3 class="font-bold">UltraView 32" 4K Monitor</h3>
                            <span class="badge-editor">Editor's Choice</span>
                        </div>
                        <div class="mt-3 text-3xl font-extrabold">$399 <span class="text-slate-400 line-through text-lg">$649</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== BEST RATED + COMPARISON TABLE ===================== -->
    <section class="py-16 bg-white">
        <div class="container-x">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="eyebrow">Data-backed</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Best Rated — Side by Side</h2>
                <p class="text-slate-500 mt-3">Our top 4 picks scored on what actually matters.</p>
            </div>
            <div class="overflow-x-auto mt-10 card-premium" data-aos="fade-up">
                <table class="table align-middle mb-0 min-w-[820px]">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4">Product</th><th class="p-4">Rating</th><th class="p-4">Battery</th><th class="p-4">Price</th><th class="p-4">Best for</th><th class="p-4"></th>
                    </tr>
                    </thead>
                    <tbody id="bestTable"></tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ===================== TESTIMONIALS ===================== -->
    <section class="py-20">
        <div class="container-x">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="eyebrow">Loved by readers</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">What Our Community Says</h2>
            </div>
            <div class="swiper testimonial-swiper mt-12 pb-12">
                <div class="swiper-wrapper" id="testiWrap"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- ===================== LATEST REVIEWS + BLOG ===================== -->
    <section class="py-16 bg-white">
        <div class="container-x">
            <div class="flex items-end justify-between flex-wrap gap-4" data-aos="fade-up">
                <div><span class="eyebrow">Fresh off the bench</span><h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Latest Reviews & Articles</h2></div>
                <a href="blog.html" class="btn-ghost no-underline">All posts <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mt-10" id="blogGrid"></div>
        </div>
    </section>

    <!-- ===================== TRUST BADGES ===================== -->
    <section class="py-12">
        <div class="container-x grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up" id="trustGrid"></div>
    </section>

    <!-- ===================== FAQ ===================== -->
    <section class="py-16 bg-white">
        <div class="container-x grid lg:grid-cols-2 gap-12 items-start">
            <div data-aos="fade-right">
                <span class="eyebrow">Good to know</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Frequently Asked Questions</h2>
                <p class="text-slate-500 mt-3">Everything you need to know about how we test, score and recommend products.</p>
                <div class="card-premium p-6 mt-6">
                    <p class="text-slate-600 m-0"><i class="fa-solid fa-headset text-primary me-2"></i> Still have questions? <a href="contact.html" class="text-primary font-semibold no-underline">Contact our team</a>.</p>
                </div>
            </div>
            <div class="space-y-4" id="faqWrap" data-aos="fade-left"></div>
        </div>
    </section>

    <!-- ===================== NEWSLETTER ===================== -->
    <section class="py-16">
        <div class="container-x">
            <div class="rounded-3xl glass shadow-soft p-8 md:p-12 text-center relative overflow-hidden" data-aos="zoom-in">
                <div class="blob bg-secondary w-64 h-64 -top-20 -left-10"></div>
                <div class="relative z-10 max-w-2xl mx-auto">
                    <span class="eyebrow"><i class="fa-solid fa-envelope-open-text me-1"></i> Join 240k subscribers</span>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Get the best deals before they sell out</h2>
                    <p class="text-slate-600 mt-3">Weekly hand-picked deals & new reviews. No spam, unsubscribe anytime.</p>
                    <form data-form class="mt-6 flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                        <input type="email" required placeholder="you@email.com" class="flex-1 rounded-full border border-slate-200 px-5 py-3 outline-none focus:border-primary" />
                        <button class="btn-grad">Subscribe Free</button>
                    </form>
                    <p data-form-note class="hidden text-success mt-3"><i class="fa-solid fa-check"></i> You're in! Check your inbox to confirm.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
