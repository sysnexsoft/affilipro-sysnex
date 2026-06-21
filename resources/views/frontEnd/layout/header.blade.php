<div class="bg-slate-900 text-white py-2 border-b border-slate-800" style="font-size: 13px; position: relative; z-index: 1050;">
    <div class="container-x flex items-center justify-between gap-4" style="position: relative;">

        <div class="flex items-center gap-2 flex-grow max-w-xl lg:max-w-2xl position-relative">
            <span class="badge bg-primary text-xs uppercase px-2 py-0.5 rounded fw-bold text-white shadow-sm flex-shrink-0 z-10">
                Update
            </span>
            <div class="w-100 overflow-hidden">
                <marquee behavior="scroll" direction="left" scrollamount="4" class="text-slate-300 font-medium cursor-pointer m-0 pt-1" onmouseover="this.stop();" onmouseout="this.start();">
                    🚀 Big Summer Sale! Get up to 40% off on top-rated tech gadgets. • New comparison analytics feature is now live! • Check out our latest expert reviews before buying.
                </marquee>
            </div>
        </div>

        <div class="flex items-center gap-4 flex-shrink-0 position-static">

            <!-- Language Switcher Dropdown (notranslate ক্লাস যোগ করা হয়েছে যাতে গুগল এটিকে কখনো পরিবর্তন না করে) -->
            <div class="dropdown position-relative notranslate">
                <a class="text-slate-300 hover:text-white no-underline flex items-center gap-1 dropdown-toggle cursor-pointer"
                   data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="fa-solid fa-globe opacity-75"></i>
                    <!-- মেইন লেবেল যাতে অনুবাদ না হয় -->
                    <span id="current-lang-label" class="notranslate">English</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg rounded-3 border-slate-700 mt-2 notranslate" style="z-index: 1100; min-width: 130px;">
                    <!-- ভেতরের টেক্সটগুলোতেও ক্লাস নিশ্চিত করা হয়েছে -->
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector active notranslate" href="javascript:void(0);" data-lang="en">English</a></li>
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector notranslate" href="javascript:void(0);" data-lang="bn">বাংলা</a></li>
                    <li><a class="dropdown-item py-1.5 px-3 font-medium lang-selector notranslate" href="javascript:void(0);" data-lang="es">Español</a></li>
                </ul>
            </div>

            <!-- আসল গুগল ট্রান্সলেটর উইজেট (Invisible) -->
            <div id="google_translate_element" style="display: none !important;"></div>

            <div class="w-px h-3 bg-slate-700"></div>

            <div class="dropdown position-relative">
                <a class="text-slate-300 hover:text-white no-underline flex items-center gap-1 dropdown-toggle cursor-pointer"
                   data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="fa-solid fa-money-bill-wave opacity-75"></i>
                    <span class="fw-bold">{{ session('current_currency', 'USD') }}</span>
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
<nav class="navbar-premium">
    <div class="container-x flex items-center justify-between py-3">
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <span class="w-10 h-10 rounded-xl bg-gradient-primary grid place-items-center text-white shadow-soft">
                <i class="fa-solid fa-bolt"></i>
            </span>
            <span class="font-display text-xl font-extrabold text-slate-900">
                Affili<span class="text-gradient">Pro</span>
            </span>
        </a>

        <div class="hidden lg:flex items-center gap-7">
            <a href="{{ route('home') }}" class="nav-link-premium {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
            <a href="{{ route('product') }}" class="nav-link-premium {{ request()->routeIs('product') ? 'text-primary' : '' }}">Products</a>
            <a href="{{ route('compare') }}" class="nav-link-premium {{ request()->routeIs('compare') ? 'text-primary' : '' }}">Compare</a>
            <a href="{{ route('categories') }}" class="nav-link-premium {{ request()->routeIs('categories') ? 'text-primary' : '' }}">Categories</a>
            <a href="{{ route('review') }}" class="nav-link-premium {{ request()->routeIs('review') ? 'text-primary' : '' }}">Reviews</a>
            <a href="{{ route('blogs') }}" class="nav-link-premium {{ request()->routeIs('blogs') ? 'text-primary' : '' }}">Blog</a>
            <a href="{{ route('about-us') }}" class="nav-link-premium {{ request()->routeIs('about-us') ? 'text-primary' : '' }}">About</a>
            <a href="{{ route('contact-us') }}" class="nav-link-premium {{ request()->routeIs('contact-us') ? 'text-primary' : '' }}">Contact</a>
        </div>

        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ route('product') }}" class="text-slate-600 hover:text-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <a href="{{ route('compare') }}" class="btn-grad text-sm no-underline">
                <i class="fa-solid fa-scale-balanced me-1"></i> Compare Top Picks
            </a>
        </div>

        <button id="burger" class="lg:hidden text-2xl text-slate-800">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

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
