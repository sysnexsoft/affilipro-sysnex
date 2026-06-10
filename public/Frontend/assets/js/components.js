/* ==========================================================================
   AffiliPro — Shared Navbar + Footer injector
   (In Laravel Blade these become @include('partials.navbar') etc.)
   ========================================================================== */
(function () {
  const NAV = [
    { label: 'Home', href: '{{route('home')}}' },
    { label: 'Products', href: 'products.html' },
    { label: 'Compare', href: 'comparison.html' },
    { label: 'Categories', href: 'category.html' },
    { label: 'Reviews', href: 'product-details.html' },
    { label: 'Blog', href: 'blog.html' },
    { label: 'About', href: 'about.html' },
    { label: 'Contact', href: 'contact.html' }
  ];

  const current = location.pathname.split('/').pop() || '{{route('home')}}';

  const links = NAV.map(n =>
    `<a href="${n.href}" class="nav-link-premium ${n.href === current ? 'text-primary' : ''}">${n.label}</a>`
  ).join('');

  const mobileLinks = NAV.map(n =>
    `<a href="${n.href}" class="block py-2 font-semibold text-slate-700 hover:text-primary">${n.label}</a>`
  ).join('');

  const navHTML = `
  <nav class="navbar-premium">
    <div class="container-x flex items-center justify-between py-3">
      <a href="{{route('home')}}" class="flex items-center gap-2 no-underline">
        <span class="w-10 h-10 rounded-xl bg-gradient-primary grid place-items-center text-white shadow-soft">
          <i class="fa-solid fa-bolt"></i>
        </span>
        <span class="font-display text-xl font-extrabold text-slate-900">Affili<span class="text-gradient">Pro</span></span>
      </a>
      <div class="hidden lg:flex items-center gap-7">${links}</div>
      <div class="hidden lg:flex items-center gap-3">
        <a href="products.html" class="text-slate-600 hover:text-primary"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="comparison.html" class="btn-grad text-sm no-underline"><i class="fa-solid fa-scale-balanced me-1"></i> Compare Top Picks</a>
      </div>
      <button id="burger" class="lg:hidden text-2xl text-slate-800"><i class="fa-solid fa-bars"></i></button>
    </div>
    <div id="mobileMenu" class="hidden lg:hidden glass border-t border-slate-200 px-5 py-4">
      ${mobileLinks}
      <a href="comparison.html" class="btn-grad w-full text-center mt-3 no-underline block">Compare Top Picks</a>
    </div>
  </nav>`;

  const footHTML = `
  <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-20">
    <div class="container-x">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
        <div class="lg:col-span-2">
          <a href="{{route('home')}}" class="flex items-center gap-2 no-underline mb-4">
            <span class="w-10 h-10 rounded-xl bg-gradient-primary grid place-items-center text-white"><i class="fa-solid fa-bolt"></i></span>
            <span class="font-display text-xl font-extrabold text-white">Affili<span class="text-accent">Pro</span></span>
          </a>
          <p class="text-slate-400 max-w-sm">Independent, data-driven reviews and comparisons. We test the products so you buy with total confidence.</p>
          <div class="flex gap-3 mt-5">
            ${['twitter','facebook-f','instagram','youtube','linkedin-in'].map(i =>
              `<a href="#" class="w-10 h-10 rounded-full bg-white/10 grid place-items-center text-white hover:bg-gradient-primary transition no-underline"><i class="fa-brands fa-${i}"></i></a>`).join('')}
          </div>
        </div>
        <div>
          <h5 class="text-white font-bold mb-4">Explore</h5>
          <ul class="space-y-2 list-none p-0">
            <li><a class="footer-link" href="products.html">All Products</a></li>
            <li><a class="footer-link" href="comparison.html">Comparisons</a></li>
            <li><a class="footer-link" href="category.html">Categories</a></li>
            <li><a class="footer-link" href="blog.html">Blog</a></li>
          </ul>
        </div>
        <div>
          <h5 class="text-white font-bold mb-4">Company</h5>
          <ul class="space-y-2 list-none p-0">
            <li><a class="footer-link" href="about.html">About Us</a></li>
            <li><a class="footer-link" href="contact.html">Contact</a></li>
            <li><a class="footer-link" href="affiliate-disclosure.html">Affiliate Disclosure</a></li>
          </ul>
        </div>
        <div>
          <h5 class="text-white font-bold mb-4">Legal</h5>
          <ul class="space-y-2 list-none p-0">
            <li><a class="footer-link" href="privacy.html">Privacy Policy</a></li>
            <li><a class="footer-link" href="terms.html">Terms & Conditions</a></li>
            <li><a class="footer-link" href="affiliate-disclosure.html">Disclosure</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-white/10 mt-12 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-slate-400">
        <p class="m-0">© <span data-year></span> AffiliPro. All rights reserved.</p>
        <p class="m-0"><i class="fa-solid fa-circle-info me-1 text-accent"></i> As an affiliate we may earn from qualifying purchases.</p>
      </div>
    </div>
  </footer>`;

  const navMount = document.getElementById('site-nav');
  const footMount = document.getElementById('site-footer');
  if (navMount) navMount.innerHTML = navHTML;
  if (footMount) footMount.innerHTML = footHTML;
})();
