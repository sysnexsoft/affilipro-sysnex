<footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-20">
    <div class="container-xxl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-2 no-underline">
                    @if($web_setting->header_logo)
                        <img class="img-fluid h-10 w-auto object-contain" src="{{ asset($web_setting->header_logo) }}" alt="{{ $web_setting->site_name ?? 'Logo' }}">
                    @else
                        <span class="w-10 h-10 rounded-xl bg-gradient-primary grid place-items-center text-white shadow-soft">
                            <i class="fa-solid fa-bolt"></i>
                        </span>
                        <span class="font-display text-xl font-extrabold text-white">
                            Affili <span class="text-gradient">Product</span>
                        </span>
                    @endif
                </a>
                <p class="text-slate-400 max-w-sm" align="justify">
                    Expert product reviews and side-by-side comparisons. We test the best so you can buy with total confidence.
                </p>
            </div>

            <!-- Explore সেকশন -->
            <div>
                <h5 class="text-white font-bold mb-4">Explore</h5>
                <ul class="space-y-2 list-none p-0">
                    <li><a class="footer-link no-underline" href="{{ route('product') }}">All Products</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('compare') }}">Comparisons</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('categories') }}">Categories</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('blogs') }}">Blog</a></li>
                </ul>
            </div>

            <!-- Company সেকশন (ডাইনামিক লিঙ্ক) -->
            <div>
                <h5 class="text-white font-bold mb-4">Company</h5>
                <ul class="space-y-2 list-none p-0">
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'about-us') }}">About Us</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'contact-info') }}">Contact Info</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'affiliate-disclosure') }}">Affiliate Disclosure</a></li>
                </ul>
            </div>

            <!-- Legal সেকশন (ডাইনামিক লিঙ্ক) -->
            <div>
                <h5 class="text-white font-bold mb-4">Legal</h5>
                <ul class="space-y-2 list-none p-0">
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'privacy-policy') }}">Privacy Policy</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'terms-conditions') }}">Terms & Conditions</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'cookie-policy') }}">Cookie Policy</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'disclosure') }}">Disclosure</a></li>
                    <li><a class="footer-link no-underline" href="{{ route('dynamic.page', 'disclaimer') }}">Disclaimer</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-slate-400">
            <p class="m-0">© {{ date('Y') }} {{ $web_setting->site_name ?? 'AffiliPro' }}. All rights reserved.</p>
            <p class="m-0"><i class="fa-solid fa-circle-info me-1 text-accent"></i> As an affiliate we may earn from qualifying purchases.</p>
        </div>
    </div>
</footer>
