@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <section class="bg-hero pt-12 pb-12">
        <div class="container-x">
            <nav class="crumb text-sm mb-4" data-aos="fade-up"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">Blog</span></nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">Guides, Reviews & Deals</h1>
            <div class="mt-6 glass rounded-2xl p-2 flex items-center shadow-soft max-w-xl" data-aos="fade-up">
                <i class="fa-solid fa-magnifying-glass text-slate-400 px-3"></i>
                <input id="liveSearch" type="text" placeholder="Search articles..." class="flex-1 bg-transparent border-0 outline-none py-2" />
            </div>
            <div class="flex flex-wrap gap-2 mt-5" id="blogFilters"></div>
        </div>
    </section>
    <section class="py-12">
        <div class="container-x grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="blogGrid"></div>
    </section>
@endsection

@push('js')
    <script>
        (function(){
            const D=window.AFFILI;
            document.getElementById('blogGrid').innerHTML=D.blog.map(b=>`
      <article class="card-premium" data-aos="fade-up" data-search-item="${b.title} ${b.cat}" data-cat="${b.cat}">
        <a href="blog-details.html" class="block aspect-video bg-gradient-to-br from-violet-50 to-cyan-50 grid place-items-center text-5xl text-secondary no-underline"><i class="fa-solid fa-${b.icon}"></i></a>
        <div class="p-5"><div class="flex items-center gap-2 text-xs"><span class="eyebrow">${b.cat}</span><span class="text-slate-400">${b.read} read</span></div>
        <h3 class="font-display font-bold text-lg mt-3"><a href="blog-details.html" class="text-slate-900 no-underline hover:text-primary">${b.title}</a></h3>
        <div class="flex items-center justify-between mt-4 text-sm text-slate-400"><span><i class="fa-regular fa-user me-1"></i>${b.author}</span><span>${b.date}</span></div></div>
      </article>`).join('');
            const cats=['all',...new Set(D.blog.map(b=>b.cat))];
            document.getElementById('blogFilters').innerHTML=cats.map((c,i)=>`<button data-filter="${c}" class="text-sm ${i===0?'btn-grad':'btn-ghost'} no-underline">${c==='all'?'All':c}</button>`).join('');
        })();
    </script>
@endpush
