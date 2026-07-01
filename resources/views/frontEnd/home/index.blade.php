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

                    <form action="#" method="GET" class="mt-7 glass rounded-2xl p-2 flex items-center shadow-soft max-w-xl">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 px-3"></i>
                        <input type="text" name="search" placeholder="Search 5,000+ reviews — e.g. 'best wireless earbuds'" class="flex-1 bg-transparent border-0 outline-none py-2 text-slate-700" />
                        <button type="submit" class="btn-grad text-sm">Search</button>
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
                    @if($bestRatedProducts->count() > 0)
                        @php $topPick = $bestRatedProducts->first(); @endphp
                        <div class="card-premium p-6 float">
                            <div class="flex items-center justify-between mb-4">
                                <span class="badge-pick"><i class="fa-solid fa-crown me-1"></i> #1 Top Pick</span>
                                <span class="stars text-sm text-amber-400">@for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid {{ $i <= round($topPick->reviews_avg_rating) ? 'fa-star' : 'fa-star-half-stroke' }}"></i>
                                    @endfor
                                </span>
                            </div>
                            <div class="">
                            @if($topPick->featured_image)
                                <!-- ইউআরএল-এ top_pick=1 প্যারামিটার পাঠানো হয়েছে -->
                                    <a href="{{ route('product.details', ['slug' => $topPick->slug, 'top_pick' => 1]) }}">
                                        <img src="{{ asset($topPick->featured_image) }}" alt="{{ $topPick->title }}" class="w-full h-full object-contain">
                                    </a>
                                @else
                                    <i class="fa-solid fa-headphones-simple"></i>
                                @endif
                            </div>
                            <h3 class="font-display font-bold text-lg mt-4">
                                <!-- ইউআরএল-এ top_pick=1 প্যারামিটার পাঠানো হয়েছে -->
                                <a href="{{ route('product.details', ['slug' => $topPick->slug, 'top_pick' => 1]) }}" class="">{{ $topPick->title }} </a>
                            </h3>
                            <p class="text-sm text-slate-500">{{ Str::limit($topPick->short_description, 60) }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <div><span class="text-2xl font-extrabold text-slate-900">{{ format_price($topPick->sale_price) }}</span></div>
                                <!-- ইউআরএল-এ top_pick=1 প্যারামিটার পাঠানো হয়েছে -->
                                <a href="{{ route('product.details', ['slug' => $topPick->slug, 'top_pick' => 1]) }}" class="btn-accent text-sm no-underline">View Deal <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    @endif
                    {{--<div class="card-premium p-4 absolute -bottom-6 -left-4 w-48 hidden md:block" data-aos="zoom-in" data-aos-delay="300">
                        <div class="flex items-center gap-2"><span class="w-9 h-9 rounded-full bg-success/15 grid place-items-center text-success"><i class="fa-solid fa-bolt"></i></span>
                            <div><div class="text-xs text-slate-500">Saved this week</div><div class="font-bold text-slate-900">$182,400</div></div></div>
                    </div>--}}
                </div>
            </div>

            {{--<div class="mt-16 overflow-hidden">
                <p class="text-center text-sm text-slate-400 mb-5 uppercase tracking-widest">As featured & compared across</p>
                <div class="swiper brand-swiper">
                    <div class="swiper-wrapper items-center" id="brandWrap">
                        <div class="swiper-slide text-center text-slate-400 font-bold">BBC NEWS</div>
                        <div class="swiper-slide text-center text-slate-400 font-bold">FORBES</div>
                        <div class="swiper-slide text-center text-slate-400 font-bold">TECHCRUNCH</div>
                        <div class="swiper-slide text-center text-slate-400 font-bold">WIRED</div>
                    </div>
                </div>
            </div>--}}
        </div>
    </section>

    <section class="py-20">
        <div class="container-x">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="eyebrow">Browse by need</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Top Categories</h2>
                <p class="text-slate-500 mt-3">Hand-curated picks across the categories people shop most.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mt-12">
                @foreach($categories as $cat)
                    <a href="#" class="card-premium p-4 text-center no-underline block hover:scale-105 transition-all">
                        <div class="w-70 h-70 rounded-full grid place-items-center mx-auto text-xl mb-3">
                            <img class=" rounded-full" src="{{ asset($cat->image) }}" alt="">
                        </div>
                        <h4 class="font-bold text-sm text-slate-900 m-0">{{ $cat->name }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container-x">
            <div class="flex items-end justify-between flex-wrap gap-4" data-aos="fade-up">
                <div>
                    <span class="eyebrow">Editor curated</span>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Featured Products</h2>
                </div>
                <a href="{{route('product')}}" class="btn-grad  no-underline">View all <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
                @foreach($featuredProducts as $product)
                    @include('frontEnd.component.productcard',['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

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
                            <a href="#" class="btn-accent no-underline">Grab the Deal</a>
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
                        <th class="p-4">Product</th>
                        <th class="p-4">Rating</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Best for</th>
                        <th class="p-4"></th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($bestRatedProducts as $bProduct)
                        <tr>
                            <td class="p-4">
                                <a href="{{route('product.details',$bProduct->slug)}}">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 rounded-2" src="{{asset($bProduct->featured_image)}}" alt="">
                                        <span class="font-bold text-slate-900">{{ $bProduct->title }}</span>
                                    </div>
                                </a>
                            </td>
                            <td class="p-4 font-bold text-amber-500">
                                {{ number_format($bProduct->reviews_avg_rating, 1) }} ★
                            </td>
                            <td class="p-4 font-bold">${{ $bProduct->sale_price }}</td>
                            <td class="p-4"><span class="badge bg-success text-xs text-white px-2 py-1 rounded">Top Choice</span></td>
                            <td class="p-4 text-end">
                                <a href="{{route('product.details',$bProduct->slug)}}" class="btn-grad  btn-sm no-underline">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container-x">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="eyebrow">Loved by readers</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">What Our Community Says</h2>
            </div>
            <div class="swiper testimonial-swiper mt-12 pb-12">
                <div class="swiper-wrapper">
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                    <div class="swiper-slide card-premium p-6">
                        <p class="text-slate-600">"This site saved me over $200 on my laptop purchase! The comparison data is extremely accurate."</p>
                        <h5 class="font-bold mt-4 text-slate-900">- John Doe</h5>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container-x">
            <div class="flex items-end justify-between flex-wrap gap-4" data-aos="fade-up">
                <div><span class="eyebrow">Fresh off the bench</span><h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Latest Reviews & Articles</h2></div>
                <a href="#" class="btn-grad no-underline">All posts <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mt-10">
                @foreach($latestReviews as $review)
                    <div class="card-premium p-5 flex flex-col justify-between">
                        <div>
                            <span class="text-amber-500 text-sm">
                                @for($i=1; $i<=5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </span>
                            <h4 class="font-bold text-slate-900 mt-2">ON : <a href="">{{ $review->product->title ?? 'Product' }}</a></h4>
                            <p class="text-slate-600 text-sm mt-2">"{{ Str::limit($review->review, 100) }}"</p>
                        </div>
                        <div class="text-xs text-slate-400 mt-4 pt-3 border-t"> By {{ $review->name }} — {{ $review->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container-x grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up" id="trustGrid">
            <div class="text-center p-4">
                <i class="fa-solid fa-shield text-3xl text-primary mb-2"></i>
                <h5 class="font-bold text-slate-900">100% Independent</h5>
            </div>
            <div class="text-center p-4">
                <i class="fa-solid fa-flask text-3xl text-primary mb-2"></i>
                <h5 class="font-bold text-slate-900">Expertly Tested</h5>
            </div>
            <div class="text-center p-4">
                <i class="fa-solid fa-bolt text-3xl text-primary mb-2"></i>
                <h5 class="font-bold text-slate-900">Real-time Deals</h5>
            </div>
            <div class="text-center p-4">
                <i class="fa-solid fa-face-smile text-3xl text-primary mb-2"></i>
                <h5 class="font-bold text-slate-900">Trusted Community</h5>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container-x grid lg:grid-cols-2 gap-12 items-start">
            <div data-aos="fade-right">
                <span class="eyebrow">Good to know</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold mt-4">Frequently Asked Questions</h2>
                <p class="text-slate-500 mt-3">Everything you need to know about how we test, score and recommend products.</p>
                <div class="card-premium p-6 mt-6">
                    <p class="text-slate-600 m-0"><i class="fa-solid fa-headset text-primary me-2"></i> Still have questions? <a href="#" class="text-primary font-semibold no-underline">Contact our team</a>.</p>
                </div>
            </div>
            <div class="space-y-3" data-aos="fade-left">
                <div class="card-premium p-4" data-faq>
                    <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
                        <span class="font-bold text-slate-900">How do you score products?</span>
                        <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
                    </button>
                    <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">We combine hands-on testing data with advanced sentiment analytics from verified buyers.</p></div>
                </div>
                <div class="card-premium p-4" data-faq>
                    <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
                        <span class="font-bold text-slate-900">How do you score products?</span>
                        <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
                    </button>
                    <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">We combine hands-on testing data with advanced sentiment analytics from verified buyers.</p></div>
                </div>
                <div class="card-premium p-4" data-faq>
                    <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
                        <span class="font-bold text-slate-900">How do you score products?</span>
                        <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
                    </button>
                    <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">We combine hands-on testing data with advanced sentiment analytics from verified buyers.</p></div>
                </div>
                <div class="card-premium p-4" data-faq>
                    <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
                        <span class="font-bold text-slate-900">How do you score products?</span>
                        <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
                    </button>
                    <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">We combine hands-on testing data with advanced sentiment analytics from verified buyers.</p></div>
                </div>
            </div>
        </div>
    </section>

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
                </div>
            </div>
        </div>
    </section>
@endsection
