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
        <div class="container-x">
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
        <div class="container-x">
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
                        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-950 leading-tight mb-6">
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
                            {!! $blog->description !!}
                        </div>
                    </article>

                    <hr class="my-12 border-slate-100">

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
            <div class="container-x">
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
