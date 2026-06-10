/* ==========================================================================
   AffiliPro — Shared JavaScript interactions (vanilla JS)
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  /* ---- AOS init ---- */
  if (window.AOS) {
    AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });
  }

  /* ---- Navbar scroll state ---- */
  const nav = document.querySelector('.navbar-premium');
  if (nav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 30);
    window.addEventListener('scroll', onScroll);
    onScroll();
  }

  /* ---- Mobile menu toggle ---- */
  const burger = document.getElementById('burger');
  const mobileMenu = document.getElementById('mobileMenu');
  if (burger && mobileMenu) {
    burger.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    mobileMenu.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => mobileMenu.classList.add('hidden')));
  }

  /* ---- Read progress bar ---- */
  const bar = document.querySelector('.read-progress');
  if (bar) {
    window.addEventListener('scroll', () => {
      const h = document.documentElement;
      const pct = (h.scrollTop / (h.scrollHeight - h.clientHeight)) * 100;
      bar.style.width = pct + '%';
    });
  }

  /* ---- Swiper carousels ---- */
  if (window.Swiper) {
    if (document.querySelector('.testimonial-swiper')) {
      new Swiper('.testimonial-swiper', {
        slidesPerView: 1, spaceBetween: 24, loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.testimonial-swiper .swiper-pagination', clickable: true },
        breakpoints: { 768: { slidesPerView: 2 }, 1100: { slidesPerView: 3 } }
      });
    }
    if (document.querySelector('.gallery-swiper')) {
      const thumbs = new Swiper('.gallery-thumbs', {
        slidesPerView: 4, spaceBetween: 12, watchSlidesProgress: true
      });
      new Swiper('.gallery-swiper', {
        spaceBetween: 12, loop: false,
        navigation: { nextEl: '.gallery-next', prevEl: '.gallery-prev' },
        thumbs: { swiper: thumbs }
      });
    }
    if (document.querySelector('.brand-swiper')) {
      new Swiper('.brand-swiper', {
        slidesPerView: 2, spaceBetween: 32, loop: true,
        autoplay: { delay: 1800, disableOnInteraction: false },
        breakpoints: { 576: { slidesPerView: 3 }, 992: { slidesPerView: 5 } }
      });
    }
  }

  /* ---- FAQ accordion (vanilla) ---- */
  document.querySelectorAll('[data-faq]').forEach(item => {
    const btn = item.querySelector('[data-faq-btn]');
    const body = item.querySelector('[data-faq-body]');
    const icon = item.querySelector('[data-faq-icon]');
    if (!btn || !body) return;
    btn.addEventListener('click', () => {
      const open = body.style.maxHeight && body.style.maxHeight !== '0px';
      document.querySelectorAll('[data-faq-body]').forEach(b => { b.style.maxHeight = '0px'; });
      document.querySelectorAll('[data-faq-icon]').forEach(i => i.classList.remove('rotate-45'));
      if (!open) {
        body.style.maxHeight = body.scrollHeight + 'px';
        if (icon) icon.classList.add('rotate-45');
      }
    });
  });

  /* ---- Countdown timer ---- */
  const cd = document.querySelector('[data-countdown]');
  if (cd) {
    const target = Date.now() + 1000 * 60 * 60 * 26 + 1000 * 60 * 12; // ~26h
    const tick = () => {
      let diff = Math.max(0, target - Date.now());
      const d = Math.floor(diff / 86400000); diff -= d * 86400000;
      const h = Math.floor(diff / 3600000); diff -= h * 3600000;
      const m = Math.floor(diff / 60000); diff -= m * 60000;
      const s = Math.floor(diff / 1000);
      const set = (k, v) => { const el = cd.querySelector('[data-' + k + ']'); if (el) el.textContent = String(v).padStart(2, '0'); };
      set('d', d); set('h', h); set('m', m); set('s', s);
    };
    tick(); setInterval(tick, 1000);
  }

  /* ---- Sticky mobile CTA ---- */
  const sticky = document.querySelector('.sticky-cta');
  if (sticky) {
    window.addEventListener('scroll', () => sticky.classList.toggle('show', window.scrollY > 600));
  }

  /* ---- Exit intent popup ---- */
  const exit = document.getElementById('exitPopup');
  if (exit) {
    let shown = sessionStorage.getItem('exitShown');
    const open = () => { if (!shown) { exit.classList.add('show'); shown = true; sessionStorage.setItem('exitShown', '1'); } };
    document.addEventListener('mouseout', e => { if (e.clientY <= 0) open(); });
    setTimeout(() => { if (!shown && window.innerWidth < 768) open(); }, 25000);
    exit.querySelectorAll('[data-exit-close]').forEach(b => b.addEventListener('click', () => exit.classList.remove('show')));
    exit.addEventListener('click', e => { if (e.target === exit) exit.classList.remove('show'); });
  }

  /* ---- Product / blog live filter ---- */
  const search = document.getElementById('liveSearch');
  if (search) {
    search.addEventListener('input', () => {
      const q = search.value.toLowerCase();
      document.querySelectorAll('[data-search-item]').forEach(card => {
        const txt = card.getAttribute('data-search-item').toLowerCase();
        card.style.display = txt.includes(q) ? '' : 'none';
      });
    });
  }

  /* ---- Category chip filter ---- */
  document.querySelectorAll('[data-filter]').forEach(chip => {
    chip.addEventListener('click', () => {
      const cat = chip.getAttribute('data-filter');
      document.querySelectorAll('[data-filter]').forEach(c => c.classList.remove('btn-grad'));
      document.querySelectorAll('[data-filter]').forEach(c => c.classList.add('btn-ghost'));
      chip.classList.add('btn-grad'); chip.classList.remove('btn-ghost');
      document.querySelectorAll('[data-cat]').forEach(card => {
        card.style.display = (cat === 'all' || card.getAttribute('data-cat') === cat) ? '' : 'none';
      });
    });
  });

  /* ---- TOC scroll spy ---- */
  const tocLinks = document.querySelectorAll('.toc a');
  if (tocLinks.length) {
    const sections = [...tocLinks].map(l => document.querySelector(l.getAttribute('href'))).filter(Boolean);
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(s => { if (window.scrollY >= s.offsetTop - 120) current = '#' + s.id; });
      tocLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === current));
    });
  }

  /* ---- Newsletter / contact form feedback ---- */
  document.querySelectorAll('[data-form]').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const note = form.querySelector('[data-form-note]');
      if (note) { note.classList.remove('hidden'); }
      form.reset();
    });
  });

  /* ---- Social share ---- */
  document.querySelectorAll('[data-share]').forEach(btn => {
    btn.addEventListener('click', () => {
      const net = btn.getAttribute('data-share');
      const url = encodeURIComponent(window.location.href);
      const text = encodeURIComponent(document.title);
      const map = {
        twitter: `https://twitter.com/intent/tweet?url=${url}&text=${text}`,
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`
      };
      if (map[net]) window.open(map[net], '_blank', 'width=600,height=500');
    });
  });

  /* ---- Footer year ---- */
  document.querySelectorAll('[data-year]').forEach(el => el.textContent = new Date().getFullYear());
});
