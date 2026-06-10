/* AffiliPro — Product details rendering */
(function () {
  const D = window.AFFILI; const $ = id => document.getElementById(id);
  const icons = ['headphones-simple','box-open','volume-high','microphone','battery-full'];
  if ($('galleryWrap')) $('galleryWrap').innerHTML = icons.map(i =>
    `<div class="swiper-slide"><div class="aspect-square bg-gradient-to-br from-blue-50 to-violet-50 grid place-items-center text-7xl text-primary"><i class="fa-solid fa-${i}"></i></div></div>`).join('');
  if ($('thumbWrap')) $('thumbWrap').innerHTML = icons.map(i =>
    `<div class="swiper-slide cursor-pointer"><div class="aspect-square rounded-lg bg-slate-50 grid place-items-center text-xl text-primary border border-slate-200"><i class="fa-solid fa-${i}"></i></div></div>`).join('');

  const scores = [['Sound','9.5'],['Battery','9.2'],['Comfort','9.0'],['Value','9.6']];
  if ($('scoreGrid')) $('scoreGrid').innerHTML = scores.map(s =>
    `<div class="card-premium p-4 text-center"><div class="text-2xl font-extrabold text-gradient">${s[1]}</div><div class="text-xs text-slate-500 mt-1">${s[0]}</div></div>`).join('');

  const feats = [
    ['wave-square','Hybrid ANC','Blocks up to 42dB of ambient noise'],
    ['battery-full','32h Battery','8h buds + 24h case, USB-C fast charge'],
    ['droplet','IPX5 Water Resistant','Sweat & rain proof for workouts'],
    ['bluetooth','Bluetooth 5.4','Multipoint pairing, ultra-low latency']
  ];
  if ($('featList')) $('featList').innerHTML = feats.map(f =>
    `<div class="flex gap-3"><span class="w-11 h-11 rounded-xl bg-blue-50 text-primary grid place-items-center text-lg shrink-0"><i class="fa-solid fa-${f[0]}"></i></span><div><div class="font-bold">${f[1]}</div><div class="text-sm text-slate-500">${f[2]}</div></div></div>`).join('');

  const pros = ['Class-leading noise cancellation','Outstanding 32h battery life','Comfortable for long sessions','Excellent value for money','Crisp, balanced sound'];
  const cons = ['No wireless charging case','App could be more intuitive','Average call quality in wind'];
  if ($('prosList')) $('prosList').innerHTML = pros.map(p => `<li class="flex gap-2 pro-item"><i class="fa-solid fa-circle-check mt-1"></i><span>${p}</span></li>`).join('');
  if ($('consList')) $('consList').innerHTML = cons.map(c => `<li class="flex gap-2 con-item"><i class="fa-solid fa-circle-xmark mt-1"></i><span>${c}</span></li>`).join('');

  const specs = [['Driver','11mm dynamic'],['ANC','Hybrid, up to 42dB'],['Battery','8h (buds) / 32h (total)'],['Charging','USB-C, fast charge'],['Bluetooth','5.4 multipoint'],['Water resistance','IPX5'],['Weight','4.8g per bud'],['Warranty','2 years']];
  if ($('specTable')) $('specTable').innerHTML = '<tbody>' + specs.map(s => `<tr><td class="fw-semibold text-slate-500" style="width:40%">${s[0]}</td><td>${s[1]}</td></tr>`).join('') + '</tbody>';

  const reviews = [
    ['Michael T.',5,'Incredible value. The ANC rivals headphones twice the price.'],
    ['Priya S.',5,'Battery life is unreal — I charge once a week. Super comfy too.'],
    ['Jordan W.',4,'Great sound, but I wish the case had wireless charging.']
  ];
  if ($('reviewList')) $('reviewList').innerHTML = reviews.map(r => {
    let st=''; for(let i=1;i<=5;i++) st += `<i class="fa-${i<=r[1]?'solid':'regular'} fa-star"></i>`;
    return `<div class="border-b border-slate-100 pb-4"><div class="flex items-center gap-3"><span class="w-10 h-10 rounded-full bg-gradient-primary text-white grid place-items-center font-bold">${r[0][0]}</span><div><div class="font-bold">${r[0]}</div><div class="stars text-sm">${st}</div></div><span class="ms-auto text-xs text-success"><i class="fa-solid fa-circle-check"></i> Verified</span></div><p class="text-slate-600 mt-2 mb-0">${r[2]}</p></div>`;
  }).join('');

  const faqs = D.faqs.slice(0,4);
  if ($('faqWrap')) $('faqWrap').innerHTML = faqs.map(f =>
    `<div class="card-premium p-5" data-faq><button data-faq-btn class="w-full flex items-center justify-between text-left bg-transparent border-0 p-0"><span class="font-bold">${f.q}</span><i data-faq-icon class="fa-solid fa-plus text-primary"></i></button><div data-faq-body style="max-height:0;overflow:hidden;transition:max-height .35s ease"><p class="text-slate-500 pt-3 mb-0">${f.a}</p></div></div>`).join('');

  const stars=r=>{let h='';for(let i=1;i<=5;i++)h+= r>=i?'<i class="fa-solid fa-star"></i>':'<i class="fa-regular fa-star"></i>';return '<span class="stars text-sm">'+h+'</span>';};
  if ($('relatedGrid')) $('relatedGrid').innerHTML = D.products.slice(1,5).map(p =>
    `<div class="card-premium"><div class="aspect-[4/3] bg-gradient-to-br from-blue-50 to-violet-50 grid place-items-center text-5xl text-primary"><i class="fa-solid fa-${p.icon}"></i></div><div class="p-5"><h3 class="font-bold"><a href="product-details.html" class="text-slate-900 no-underline hover:text-primary">${p.name}</a></h3>${stars(p.rating)}<div class="flex items-center justify-between mt-3"><span class="font-extrabold">$${p.price}</span><a href="product-details.html" class="btn-grad text-sm no-underline">View</a></div></div></div>`).join('');
})();
