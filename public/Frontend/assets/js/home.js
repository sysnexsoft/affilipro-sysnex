/* ==========================================================================
   AffiliPro — Homepage dynamic rendering
   ========================================================================== */
(function () {
  const D = window.AFFILI; if (!D) return;
  const $ = id => document.getElementById(id);

  const stars = r => {
    let h = '';
    for (let i = 1; i <= 5; i++) {
      if (r >= i) h += '<i class="fa-solid fa-star"></i>';
      else if (r >= i - 0.5) h += '<i class="fa-solid fa-star-half-stroke"></i>';
      else h += '<i class="fa-regular fa-star"></i>';
    }
    return `<span class="stars text-sm">${h}</span>`;
  };

  const badgeHTML = b => ({
    pick: '<span class="badge-pick"><i class="fa-solid fa-crown me-1"></i>Top Pick</span>',
    editor: '<span class="badge-editor"><i class="fa-solid fa-award me-1"></i>Editor</span>',
    deal: '<span class="badge-deal"><i class="fa-solid fa-fire me-1"></i>Deal</span>'
  }[b] || '');

  const productCard = p => `
    <div class="card-premium" data-aos="fade-up" data-search-item="${p.name} ${p.cat}" data-cat="${p.cat}">
      <div class="relative">
        <div class="aspect-[4/3] bg-gradient-to-br from-blue-50 to-violet-50 grid place-items-center text-5xl text-primary"><i class="fa-solid fa-${p.icon}"></i></div>
        <div class="absolute top-3 left-3">${badgeHTML(p.badge)}</div>
        <button class="absolute top-3 right-3 w-9 h-9 rounded-full glass grid place-items-center text-slate-600 hover:text-red-500"><i class="fa-regular fa-heart"></i></button>
      </div>
      <div class="p-5">
        <span class="text-xs font-semibold text-primary">${p.cat}</span>
        <h3 class="font-display font-bold text-lg mt-1"><a href="product-details.html" class="text-slate-900 no-underline hover:text-primary">${p.name}</a></h3>
        <div class="flex items-center gap-2 mt-2">${stars(p.rating)}<span class="text-sm text-slate-400">${p.rating} (${p.reviews.toLocaleString()})</span></div>
        <div class="flex items-center justify-between mt-4">
          <div><span class="text-xl font-extrabold text-slate-900">$${p.price}</span> <span class="text-slate-400 line-through text-sm">$${p.old}</span></div>
          <a href="product-details.html" class="btn-grad text-sm no-underline">View <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
      </div>
    </div>`;

  // Categories
  if ($('catGrid')) $('catGrid').innerHTML = D.categories.slice(0, 6).map(c => `
    <a href="category.html" class="card-premium p-5 text-center no-underline" data-aos="zoom-in">
      <span class="w-14 h-14 rounded-2xl bg-gradient-primary text-white grid place-items-center text-2xl mx-auto"><i class="fa-solid fa-${c.icon}"></i></span>
      <h3 class="font-bold text-slate-900 mt-3 mb-0">${c.name}</h3>
      <p class="text-sm text-slate-400 m-0">${c.count} products</p>
    </a>`).join('');

  // Featured
  if ($('featuredGrid')) $('featuredGrid').innerHTML = D.products.slice(0, 4).map(productCard).join('');

  // Best rated table
  if ($('bestTable')) $('bestTable').innerHTML = D.products.slice(0, 4).map((p, i) => `
    <tr>
      <td class="p-4"><div class="flex items-center gap-3"><span class="w-11 h-11 rounded-xl bg-blue-50 grid place-items-center text-primary text-xl"><i class="fa-solid fa-${p.icon}"></i></span><div><div class="font-bold">${p.name}</div><div class="text-xs text-slate-400">${p.tag}</div></div></div></td>
      <td class="p-4">${stars(p.rating)}<div class="text-xs text-slate-400">${p.rating}/5</div></td>
      <td class="p-4 font-semibold">${p.battery}</td>
      <td class="p-4"><span class="font-extrabold">$${p.price}</span></td>
      <td class="p-4 text-slate-500">${p.best}</td>
      <td class="p-4"><a href="product-details.html" class="btn-grad text-sm no-underline">Check Price</a></td>
    </tr>`).join('');

  // Testimonials
  if ($('testiWrap')) $('testiWrap').innerHTML = D.testimonials.map(t => `
    <div class="swiper-slide h-auto">
      <div class="card-premium p-6 h-full">
        <div class="text-amber-400 mb-3"><i class="fa-solid fa-quote-left text-2xl"></i></div>
        <p class="text-slate-600">${t.text}</p>
        <div class="flex items-center gap-3 mt-5">
          <span class="w-11 h-11 rounded-full bg-gradient-primary text-white grid place-items-center font-bold">${t.avatar}</span>
          <div><div class="font-bold text-slate-900">${t.name}</div><div class="text-xs text-slate-400">${t.role}</div></div>
        </div>
      </div>
    </div>`).join('');

  // Blog
  if ($('blogGrid')) $('blogGrid').innerHTML = D.blog.slice(0, 3).map(b => `
    <article class="card-premium" data-aos="fade-up">
      <a href="blog-details.html" class="block aspect-video bg-gradient-to-br from-violet-50 to-cyan-50 grid place-items-center text-5xl text-secondary no-underline"><i class="fa-solid fa-${b.icon}"></i></a>
      <div class="p-5">
        <div class="flex items-center gap-2 text-xs"><span class="eyebrow">${b.cat}</span><span class="text-slate-400">${b.read} read</span></div>
        <h3 class="font-display font-bold text-lg mt-3"><a href="blog-details.html" class="text-slate-900 no-underline hover:text-primary">${b.title}</a></h3>
        <div class="flex items-center justify-between mt-4 text-sm text-slate-400">
          <span><i class="fa-regular fa-user me-1"></i>${b.author}</span><span>${b.date}</span>
        </div>
      </div>
    </article>`).join('');

  // Brands
  if ($('brandWrap')) $('brandWrap').innerHTML = D.brands.map(b => `
    <div class="swiper-slide"><div class="text-slate-400 text-3xl text-center grayscale opacity-70 hover:opacity-100 transition"><i class="fa-brands fa-${b}"></i></div></div>`).join('');

  // Trust
  if ($('trustGrid')) $('trustGrid').innerHTML = D.trust.map(t => `
    <div class="card-premium p-6 text-center">
      <span class="w-14 h-14 rounded-2xl bg-success/10 text-success grid place-items-center text-2xl mx-auto"><i class="fa-solid fa-${t.icon}"></i></span>
      <h3 class="font-bold mt-3 mb-1">${t.title}</h3>
      <p class="text-sm text-slate-400 m-0">${t.text}</p>
    </div>`).join('');

  // FAQ
  if ($('faqWrap')) $('faqWrap').innerHTML = D.faqs.map(f => `
    <div class="card-premium p-5" data-faq>
      <button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0">
        <span class="font-bold text-slate-900">${f.q}</span>
        <i data-faq-icon class="fa-solid fa-plus text-primary transition-transform"></i>
      </button>
      <div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">${f.a}</p></div>
    </div>`).join('');
})();
