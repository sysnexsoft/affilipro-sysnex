@extends('frontEnd.layout.app')

{{-- ডাইনামিক প্রিমিয়াম SEO মেটা ট্যাগস --}}
@section('title', $blog->meta_title ?? $blog->title . ' - Blog')
@push('meta')
    <meta name="description" content="{{ $blog->meta_description ?? Str::limit(strip_tags($blog->description), 150) }}">
    <meta name="keywords" content="{{ $blog->meta_keywords }}">
    @if($blog->canonical_url)
        <link rel="canonical" href="{{ $blog->canonical_url }}">
    @endif
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($blog->description), 150) }}">
    <meta property="og:image" content="{{ asset($blog->thumbnail) }}">
@endpush

@section('body')
    <!-- ব্রেডক্রাম্ব এবং মিনিমাল হেডার -->
    <section class="bg-slate-50 border-b border-slate-100 py-6">
        <div class="container-xxl ">
            <nav class="crumb text-sm mb-3 flex items-center gap-2 text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-primary transition">Home</a>
                <i class="fa-solid fa-angle-right text-xs text-slate-300"></i>
                <a href="{{ route('blogs') }}" class="hover:text-primary transition">Blog</a>
                <i class="fa-solid fa-angle-right text-xs text-slate-300"></i>
                <span class="text-slate-800 font-semibold truncate">{{ Str::limit($blog->title, 40) }}</span>
            </nav>
        </div>
    </section>

    <!-- মেইন কন্টেন্ট সেকশন -->
    <section class="py-12 bg-white">
        <div class="container-xxl ">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- বামপাশ: ব্লগ ডিটেইলস (8 Columns) -->
                <main class="lg:col-span-8">
                    <article>
                        <!-- ক্যাটাগরি ও মেটা ইনফো -->
                        <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-slate-500">
                            @if($blog->category)
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full font-semibold text-xs uppercase tracking-wider">
                                    {{ $blog->category->name }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-eye"></i> {{ $blog->views }} Views
                            </span>
                        </div>

                        <!-- টাইটেল -->
                        <h1 class="font-display text-3xl md:text-4xl lg:text-3xl font-extrabold text-slate-950 leading-tight mb-6">
                            {{ $blog->title }}
                        </h1>

                        <!-- প্রিমিয়াম থাম্বনেইল ইমেজ -->
                        @if($blog->thumbnail)
                            <div class="rounded-2xl overflow-hidden shadow-soft mb-8 bg-slate-100 group">
                                <img src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-auto max-h-[460px] object-cover object-center transform group-hover:scale-[1.01] transition duration-500">
                            </div>
                    @endif

                    <!-- ব্লগ ডেসক্রিপশন (প্রিমিয়াম টাইপোগ্রাফি স্টাইল) -->
                        <div class="prose prose-slate max-w-none text-slate-800 space-y-6 leading-relaxed text-base md:text-lg">
                            @php
                                $finalDescription = $blog->description;

                                if (!empty($blog->product_ids) && is_array($blog->product_ids)) {

                                    $referredProducts = \App\Models\Product::whereIn('id', $blog->product_ids)
                                                        ->orderByRaw("FIELD(id, " . implode(',', $blog->product_ids) . ")")
                                                        ->get();

                                    foreach ($referredProducts as $product) {
                                        // কম্পোনেন্টের এইচটিএমএল রেন্ডার করা
                                        $componentHtml = view('frontEnd.component.productsection', compact('product'))->render();

                                        // ⚡ ফিক্সড লজিক: preg_replace এর বদলে সাবস্ট্রিং দিয়ে শুধুমাত্র প্রথম __product__ কে রিপ্লেস করা
                                        $pos = strpos($finalDescription, '__product__');
                                        if ($pos !== false) {
                                            $finalDescription = substr_replace($finalDescription, $componentHtml, $pos, strlen('__product__'));
                                        }
                                    }
                                }

                                $finalDescription = str_replace('__product__', '', $finalDescription);
                            @endphp

                            {!! $finalDescription !!}
                        </div>
                    </article>

                    <hr class="my-12 border-slate-100">
                    <!-- ১. মেইন ডিরেক্ট অ্যাফিলিয়েট কার্ড -->
                    <div class="card blog-direct-affiliate-card shadow-sm position-relative overflow-hidden mb-4"
                         style="border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 20px; background: #ffffff;">

                        <!-- ব্যাকগ্রাউন্ডে একটি হালকা প্রিমিয়াম শাইন দেওয়ার জন্য -->
                        <div class="position-absolute top-0 end-0 p-3 opacity-10" style="font-size: 5rem; color: #3b82f6; pointer-events: none; line-height: 0;">
                            <i class="fa-solid fa-tags"></i>
                        </div>

                        <div class="p-3.5 p-md-4 position-relative" style="z-index: 2;">
                            <div class="row align-items-center g-3">

                                <!-- বামে আইকন/ব্যাজ সেকশন (মোবাইলে সেন্টারে, ডেক্সটপে বামে) -->
                                <div class="col-12 col-md-auto text-center text-md-start">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-4"
                                         style="width: 65px; height: 65px; font-size: 1.75rem;">
                                        <i class="fa-solid fa-gift animate-pulse"></i>
                                    </div>
                                </div>

                                <!-- মাঝে কন্টেন্ট ও নেটওয়ার্ক ইনফো -->
                                <div class="col-12 col-md text-center text-md-start">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-1.5">
                                        <span class="badge bg-emerald-500 text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                            Verified Deal
                                        </span>
                                        @if($blog->affiliate_source)
                                            <span class="text-slate-500 small font-medium">
                                                via <strong class="text-slate-800">{{ $blog->affiliate_source }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- ডানে বা নিচে অ্যাকশন বাটন -->
                                <div class="col-12 col-md-4 text-center text-md-end">
                                    <a href="{{ $blog->affiliate_url }}"
                                       target="_blank"
                                       rel="nofollow noopener"
                                       class="btn blog-blink-btn btn-lg w-100 d-inline-flex align-items-center justify-content-center gap-2 text-white py-3 shadow-md fw-bold"
                                       style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none; border-radius: 14px; font-size: 0.95rem;">
                                        <span>Claim Offer At {{ $blog->affiliate_source ?? 'Store' }}</span>
                                        <svg class="font-medium transition-transform duration-300 button-icon"
                                             style="width: 1.0rem; height: 1.0rem; fill: currentColor; display: inline-block; vertical-align: middle;"
                                             viewBox="0 0 512 512"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/>
                                        </svg>
                                    </a>
                                    <span class="text-[10px] text-slate-400 d-block mt-1.5">
                                        <i class="fa-solid fa-shield-halved text-emerald-500"></i> Secure Affiliate Redirect
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 🎨 এই কার্ডের জন্য এক্সক্লুসিভ ব্লু-থিম অ্যানিমেশন সিএসএস -->
                    <style>
                        /* কার্ডের উপর মাউস নিলে বর্ডারের কালার পরিবর্তন */
                        .blog-direct-affiliate-card {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        .blog-direct-affiliate-card:hover {
                            transform: translateY(-2px);
                            border-color: #3b82f6 !important;
                            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1) !important;
                        }

                        /* বাটনের স্মুথ পালস ও শাইন ইফেক্ট */
                        .blog-blink-btn {
                            position: relative;
                            overflow: hidden;
                            animation: blogButtonPulse 2.5s infinite;
                        }

                        .blog-blink-btn:hover .button-icon {
                            transform: translateX(4px);
                        }

                        @keyframes blogButtonPulse {
                            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
                            70% { transform: scale(1.015); box-shadow: 0 0 0 12px rgba(59, 130, 246, 0); }
                            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
                        }

                        /* বাটন শাইন অ্যানিমেশন */
                        .blog-blink-btn::after {
                            content: '';
                            position: absolute;
                            top: -50%; left: -60%;
                            width: 30%; height: 200%;
                            background: rgba(255, 255, 255, 0.25);
                            transform: rotate(25deg);
                            animation: blogLightShine 4s infinite linear;
                        }

                        @keyframes blogLightShine {
                            0% { left: -60%; }
                            25% { left: 140%; }
                            100% { left: 140%; }
                        }
                    </style>
                    <!-- সোশ্যাল শেয়ার বাটনসমূহ -->
                    <div class="flex items-center flex-wrap gap-4 bg-slate-50 p-4 rounded-xl">
                        <span class="font-semibold text-slate-700 text-sm">Share this article:</span>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2] text-white flex items-center justify-content-center shadow-sm hover:opacity-90 transition"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1DA1F2] text-white flex items-center justify-content-center shadow-sm hover:opacity-90 transition"><i class="fa-brands fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#0A66C2] text-white flex items-center justify-content-center shadow-sm hover:opacity-90 transition"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </main>

                <!-- ডানপাশ: স্টিকি সাইডবার (4 Columns) -->
                <aside class="lg:col-span-4 lg:sticky lg:top-6 space-y-6">

                    <!-- ১. প্রিমিয়াম লাইভ সার্চ বক্স -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-soft">
                        <h4 class="font-display font-bold text-slate-900 mb-4 text-base flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-primary rounded-full"></span> Search Articles
                        </h4>
                        <div class="glass border border-slate-200 rounded-xl p-2 flex items-center shadow-inner relative">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 px-2"></i>
                            <input id="sidebarSearch" type="text" placeholder="Type keywords..." class="w-full bg-transparent border-0 outline-none py-1.5 text-sm text-slate-800" autocomplete="off" />

                            <!-- লাইভ সার্চ ড্রপডাউন রেজাল্ট কন্টেইনার -->
                            <div id="searchResults" class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-64 overflow-y-auto hidden z-50"></div>
                        </div>
                    </div>

                    <!-- ২. লেটেস্ট ব্লগ লিস্ট উইজেট -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-soft">
                        <h4 class="font-display font-bold text-slate-900 mb-4 text-base flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-primary rounded-full"></span> Latest Publications
                        </h4>
                        <div class="space-y-4">
                            @foreach($latestBlogs as $latest)
                                <a href="{{ route('blog.details', $latest->slug) }}" class="flex items-center gap-3 group no-underline">
                                    @if($latest->thumbnail)
                                        <img src="{{ asset($latest->thumbnail) }}" alt="{{ $latest->title }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0 bg-slate-100 shadow-sm border border-slate-100">
                                    @endif
                                    <div class="min-w-0">
                                        <h5 class="text-sm font-semibold text-slate-800 line-clamp-2 group-hover:text-primary transition-colors duration-200 mb-1" style="line-height: 1.3;">
                                            {{ $latest->title }}
                                        </h5>
                                        <span class="text-xs text-slate-400 flex items-center gap-1">
                                            <i class="fa-regular fa-calendar"></i> {{ $latest->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- ৩. রিলেটেড ব্লগ সেকশন (নিচে) -->
    @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
        <section class="py-16 bg-slate-50 border-t border-slate-100">
            <div class="container-xxl ">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="font-display text-2xl md:text-3xl font-extrabold text-slate-950">Related Articles</h2>
                        <p class="text-slate-500 text-sm mt-1">More guides and reviews you might enjoy reading</p>
                    </div>
                    <a href="{{ route('blog.index') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
                        View All <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedBlogs as $related)
                    <!-- আপনার এক্সিস্টিং কম্পোনেন্ট কার্ডটি এখানে লোড হবে -->
                        @include('frontEnd.component.blogCard', ['blog' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('sidebarSearch');
            const searchResults = document.getElementById('searchResults');

            // সাইডবার লাইভ সার্চের জন্য AJAX লজিক (Input event)
            searchInput.addEventListener('input', function () {
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.innerHTML = '';
                    searchResults.classList.add('hidden');
                    return;
                }

                // আপনার সার্চ এপিআই রাউট অনুযায়ী ফেচ কল
                fetch(`{{ route('blog.search') }}?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.html && data.count > 0) {
                            searchResults.innerHTML = data.html;
                            searchResults.classList.remove('hidden');
                        } else {
                            searchResults.innerHTML = '<div class="p-3 text-sm text-slate-400 text-center">No articles found</div>';
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(err => console.error('Error fetching search results:', err));
            });

            // ক্লিকের মাধ্যমে সার্চ বক্স হাইড করা
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        });
    </script>
