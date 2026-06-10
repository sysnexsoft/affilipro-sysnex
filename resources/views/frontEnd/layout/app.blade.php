<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AffiliPro — Expert Product Reviews, Comparisons & Best Deals</title>
    <meta name="description" content="AffiliPro delivers independent, data-driven product reviews, side-by-side comparisons and the best verified deals across tech, home and lifestyle." />
    <meta name="keywords" content="product reviews, best deals, affiliate, comparisons, buying guides" />
    <link rel="canonical" href="{{route('home')}}" />
    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="AffiliPro — Expert Product Reviews & Best Deals" />
    <meta property="og:description" content="Independent, data-driven product reviews and the best verified deals." />
    <meta property="og:image" content="{{asset('/')}}Frontend/assets/img/hero.jpg" />
    <meta name="twitter:card" content="summary_large_image" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- Swiper -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                        primary: '#2563eb', secondary: '#7c3aed', accent: '#06b6d4', success: '#10b981'
                    }, fontFamily: { display: ['Sora','sans-serif'], sans: ['Plus Jakarta Sans','sans-serif'] } } }
        };
    </script>
    <link rel="stylesheet" href="{{asset('/')}}Frontend/assets/css/style.css" />
    <!-- Schema markup -->
    <script type="application/ld+json">
  {"@context":"https://schema.org","@type":"WebSite","name":"AffiliPro","url":"/","potentialAction":{"@type":"SearchAction","target":"/products.html?q={query}","query-input":"required name=query"}}
  </script>
</head>
<body>
<div class="read-progress"></div>
{{----}}

<!-- ===================== HERO ===================== -->
@include('frontEnd.layout.header')

@yield('body')

@include('frontEnd.layout.footer')

<!-- Sticky mobile CTA -->
<div class="sticky-cta lg:hidden p-3">
    <div class="glass-dark rounded-2xl p-3 flex items-center justify-between gap-3 mx-3">
        <div class="text-white text-sm"><strong>Today's #1 Pick</strong><br><span class="text-white/70">Save 38% — ends soon</span></div>
        <a href="product-details.html" class="btn-accent text-sm no-underline whitespace-nowrap">View Deal</a>
    </div>
</div>

<!-- Exit intent popup -->
<div class="exit-overlay" id="exitPopup">
    <div class="card-premium max-w-md w-full p-8 text-center relative">
        <button data-exit-close class="absolute top-4 right-4 text-slate-400 text-xl"><i class="fa-solid fa-xmark"></i></button>
        <span class="w-16 h-16 rounded-2xl bg-gradient-primary grid place-items-center text-white text-3xl mx-auto"><i class="fa-solid fa-gift"></i></span>
        <h3 class="font-display text-2xl font-extrabold mt-5">Wait! Grab your free deals guide</h3>
        <p class="text-slate-500 mt-2">Get our 2025 "Best Value Buys" PDF + exclusive coupons sent instantly.</p>
        <form data-form class="mt-5 space-y-3">
            <input type="email" required placeholder="Enter your email" class="w-full rounded-full border border-slate-200 px-5 py-3 outline-none focus:border-primary" />
            <button class="btn-grad w-full">Send me the deals</button>
        </form>
        <button data-exit-close class="text-slate-400 text-sm mt-3 bg-transparent border-0">No thanks, I'll pay full price</button>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{asset('/')}}Frontend/assets/js/data.js"></script>
{{--<script src="{{asset('/')}}Frontend/assets/js/components.js"></script>--}}
<script src="{{asset('/')}}Frontend/assets/js/home.js"></script>
<script src="{{asset('/')}}Frontend/assets/js/main.js"></script>

@stack('js')
@yield('js')
</body>
</html>

