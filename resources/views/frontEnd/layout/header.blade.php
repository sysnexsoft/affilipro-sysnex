<!-- টপবার: আপনার রাখা ব্যাকগ্রাউন্ড ও z-index হুবহু ঠিক রাখা হয়েছে -->
<div class="text-white py-2 border-b border-slate-800" style="font-size: 13px; position: relative; z-index: 1050; background-color: lightgrey">
    <div class="container-xxl flex items-center justify-between gap-4" style="position: relative;">
        <div class="flex items-center gap-2 flex-grow max-w-xl lg:max-w-2xl position-relative">
            <span class="badge bg-primary text-xs uppercase px-2 py-0.5 rounded fw-bold text-white shadow-sm flex-shrink-0 z-10">
                Update
            </span>
            <div class="w-100 overflow-hidden">
                <!-- মার্কি টেক্সট: ফন্ট একটু বোল্ড (font-bold) এবং কালার text-white করা হয়েছে যাতে ব্যাকগ্রাউন্ডের ওপর লেখাটি দারুণভাবে ফুটে ওঠে -->
                <marquee behavior="scroll" direction="left" scrollamount="4" class="text-dark font-bold cursor-pointer m-0 pt-1" onmouseover="this.stop();" onmouseout="this.start();">
                    🚀 Big Summer Sale! Get up to 40% off on top-rated tech gadgets. • New comparison analytics feature is now live! • Check out our latest expert reviews before buying.
                </marquee>
            </div>
        </div>

        <div class="flex items-center gap-4 flex-shrink-0 position-static">

            <!-- Language Switcher Dropdown -->
            <div class="dropdown position-relative notranslate">
                <!-- টেক্সটকে আরও উজ্জ্বল (text-white) এবং বোল্ড করা হয়েছে -->
                <a class="text-white hover:text-primary fw-bold no-underline flex items-center gap-1 dropdown-toggle cursor-pointer"
                   data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="fa-solid fa-globe opacity-100 text-primary "></i>
                    <span id="current-lang-label" class="notranslate text-dark ">English</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-dark  dropdown-menu-end shadow-lg rounded-3 border-slate-700 mt-2 notranslate" style="z-index: 1100; min-width: 130px;">
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector active notranslate" href="javascript:void(0);" data-lang="en">English</a></li>
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector notranslate" href="javascript:void(0);" data-lang="bn">বাংলা</a></li>
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector notranslate" href="javascript:void(0);" data-lang="es">Español</a></li>
                </ul>
            </div>

            <!-- আসল গুগল ট্রান্সলেটর উইজেট (Invisible) -->
            <div id="google_translate_element" style="display: none !important;"></div>

            <div class="w-px h-3 bg-slate-700"></div>

            <!-- Currency Dropdown -->
            <div class="dropdown position-relative">
                <!-- টেক্সট কালার text-white করা হয়েছে -->
                <a class="text-white hover:text-primary no-underline flex items-center gap-1 dropdown-toggle cursor-pointer"
                   data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="fa-solid fa-money-bill-wave opacity-100 text-primary"></i>
                    <span class="fw-bold text-dark ">{{ session('current_currency', 'USD') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg rounded-3 border-slate-700 mt-2" style="z-index: 1100; min-width: 180px;">
                    @foreach(\App\Models\Currency::where('status', 1)->get() as $currency)
                        <li>
                            <a class="dropdown-item font-medium d-flex justify-content-between gap-3 {{ session('current_currency') == $currency->code ? 'active' : '' }}"
                               href="{{ route('currency.switch', $currency->code) }}">
                                <span class="text-white fw-semibold">{{ $currency->symbol }} {{ $currency->code }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>

<!-- নেভিগেশন বার: আপনার bg-dark ঠিক রেখেই ভেতরের টেক্সট ও বার্গার বাটন হাইলাইট করা হয়েছে -->
<nav class="navbar-premium bg-dark">
    <div class="container-xxl flex items-center justify-between py-3">
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            @if($web_setting->header_logo)
                <img
                    src="{{ asset($web_setting->header_logo) }}"
                    alt="{{ env('APP_NAME') }}"
                    width="180"
                    height="50"
                    class="img-fluid h-10 w-auto object-contain"
                    loading="eager"
                    fetchpriority="high">

            @else
                <span class="w-10 h-10 rounded-xl bg-gradient-primary grid place-items-center text-white shadow-soft">
                    <i class="fa-solid fa-bolt"></i>
                </span>
                <!-- bg-dark ব্যাকগ্রাউন্ডের কারণে এই টেক্সটটিকে text-white করা হয়েছে যাতে এটি পড়া যায় -->
                <span class="font-display text-xl font-extrabold text-white">
                    Affili <span class="text-gradient">Product</span>
                </span>
            @endif
        </a>

        <div class="hidden lg:flex items-center gap-7">
            <a href="{{ route('home') }}" class="nav-link-premium {{ request()->routeIs('home') ? 'text-warning' : 'text-white' }}">Home</a>
            <a href="{{ route('product') }}" class="nav-link-premium {{ request()->routeIs('product') ? 'text-warning' : 'text-white' }}">Products</a>
            <a href="{{ route('categories') }}" class="nav-link-premium {{ request()->routeIs('categories') ? 'text-warning' : 'text-white' }}">Categories</a>
            <a href="{{ route('review') }}" class="nav-link-premium {{ request()->routeIs('review') ? 'text-warning' : 'text-white' }}">Reviews</a>
            <a href="{{ route('blogs') }}" class="nav-link-premium {{ request()->routeIs('blogs') ? 'text-warning' : 'text-white' }}">Blog</a>
            <a href="{{ route('about-us') }}" class="nav-link-premium {{ request()->routeIs('about-us') ? 'text-warning' : 'text-white' }}">About</a>
            <a href="{{ route('contact-us') }}" class="nav-link-premium {{ request()->routeIs('contact-us') ? 'text-warning' : 'text-white' }}">Contact</a>
        </div>

        <div class="hidden lg:flex items-center gap-3">
            <!-- সার্চ আইকনটি স্পষ্ট করার জন্য text-slate-200 করা হয়েছে -->
            <a href="{{ route('product') }}" class="text-slate-200 hover:text-primary transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <a href="{{ route('compare') }}" class="btn-grad text-xs md:text-sm font-bold tracking-wide uppercase no-underline d-inline-flex align-items-center gap-2 px-4 py-2.5 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-xl hover:shadow-blue-500/20 hover:translate-y-[-1px] transition-all duration-200 group">
                <i class="fa-solid fa-arrows-rotate text-slate-200 group-hover:text-white group-hover:rotate-180 transition-transform duration-500"></i>
                <span>Compare</span>
                <span class="compare-count-badge bg-rose-500 text-white text-[10px] font-black h-5 min-w-[20px] px-1.5 rounded-full flex items-center justify-center shadow-sm border border-rose-400/20 transition-all">
                    {{ count(session()->get('compare_products', [])) }}
                </span>
            </a>
        </div>

        <!-- মোবাইল মেনু বার্গার বাটন আইকন bg-dark এ স্পষ্ট করার জন্য text-white করা হয়েছে -->
        <button id="burger" class="lg:hidden text-2xl text-white">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- মোবাইল রেসপনসিভ মেনু: আপনার ক্লাস ও স্ট্রাকচার অপরিবর্তিত রয়েছে -->
    <div id="mobileMenu" class="hidden lg:hidden glass border-t border-slate-200 px-5 py-4">
        <a href="{{ route('home') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Home</a>
        <a href="{{ route('product') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Products</a>
        <a href="{{ route('compare') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Compare</a>
        <a href="{{ route('categories') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Categories</a>
        <a href="{{ route('review') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Reviews</a>
        <a href="{{ route('blogs') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Blog</a>
        <a href="{{ route('about-us') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">About</a>
        <a href="{{ route('contact-us') }}" class="block py-2 font-semibold text-slate-700 hover:text-primary">Contact</a>
        <a href="{{ route('compare') }}" class="btn-grad w-full text-center mt-3 no-underline block">Compare Top Picks</a>
    </div>
</nav>
