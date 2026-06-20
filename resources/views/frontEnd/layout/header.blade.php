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
            <a href="{{ route('home') }}"
               class="nav-link-premium {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                Home
            </a>

            <a href="{{ route('product') }}"
               class="nav-link-premium {{ request()->routeIs('product') ? 'text-primary' : '' }}">
                Products
            </a>

            <a href="{{ route('compare') }}"
               class="nav-link-premium {{ request()->routeIs('compare') ? 'text-primary' : '' }}">
                Compare
            </a>

            <a href="{{ route('categories') }}"
               class="nav-link-premium {{ request()->routeIs('categories') ? 'text-primary' : '' }}">
                Categories
            </a>

            <a href="{{ route('review') }}"
               class="nav-link-premium {{ request()->routeIs('review') ? 'text-primary' : '' }}">
                Reviews
            </a>

            <a href="{{ route('blogs') }}"
               class="nav-link-premium {{ request()->routeIs('blogs') ? 'text-primary' : '' }}">
                Blog
            </a>

            <a href="{{ route('about-us') }}"
               class="nav-link-premium {{ request()->routeIs('about-us') ? 'text-primary' : '' }}">
                About
            </a>

            <a href="{{ route('contact-us') }}"
               class="nav-link-premium {{ request()->routeIs('contact-us') ? 'text-primary' : '' }}">
                Contact
            </a>
        </div>

        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ route('product') }}" class="text-slate-600 hover:text-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>

            <a href="{{ route('compare') }}" class="btn-grad text-sm no-underline">
                <i class="fa-solid fa-scale-balanced me-1"></i>
                Compare Top Picks
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

        <a href="{{ route('compare') }}" class="btn-grad w-full text-center mt-3 no-underline block">
            Compare Top Picks
        </a>
    </div>
</nav>
