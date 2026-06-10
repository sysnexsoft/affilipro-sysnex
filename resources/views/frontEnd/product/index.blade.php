@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <!-- Breadcrumb + header -->
    <section class="bg-hero pt-12 pb-16">
        <div class="container-x">
            <nav class="crumb text-sm mb-4" data-aos="fade-up"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">Products</span></nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">All Products</h1>
            <p class="text-slate-600 mt-3 max-w-xl" data-aos="fade-up">Every product, independently tested and scored. Filter to find your perfect match.</p>
            <div class="mt-6 glass rounded-2xl p-2 flex items-center shadow-soft max-w-xl" data-aos="fade-up">
                <i class="fa-solid fa-magnifying-glass text-slate-400 px-3"></i>
                <input id="liveSearch" type="text" placeholder="Search products..." class="flex-1 bg-transparent border-0 outline-none py-2" />
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container-x grid lg:grid-cols-4 gap-8">
            <!-- Sidebar filters -->
            <aside class="lg:col-span-1">
                <div class="card-premium p-5 sticky" style="top:90px" data-aos="fade-right">
                    <h3 class="font-bold mb-4"><i class="fa-solid fa-sliders text-primary me-2"></i>Filters</h3>
                    <div class="flex flex-wrap gap-2" id="catChips"></div>
                    <hr class="my-5" />
                    <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-500">Sort by</h4>
                    <select id="sortSel" class="form-select rounded-xl">
                        <option value="rating">Top rated</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="reviews">Most reviewed</option>
                    </select>
                    <hr class="my-5" />
                    <div class="rounded-2xl bg-gradient-primary text-white p-5 text-center">
                        <i class="fa-solid fa-gift text-2xl"></i>
                        <p class="mt-2 mb-3 text-sm">Get exclusive coupons weekly</p>
                        <a href="#nl" class="btn-accent text-sm no-underline">Join Free</a>
                    </div>
                </div>
            </aside>

            <!-- Grid -->
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-slate-500 m-0"><span id="resultCount"></span> products found</p>
                </div>
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6" id="prodGrid"></div>
                {{--<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">

                    @foreach($products as $product)
                        <div class="card-premium" data-aos="fade-up">

                            <div class="relative">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full aspect-[4/3] object-cover">

                                <div class="absolute top-3 left-3">
                                    @if($product->badge == 'pick')
                                        <span class="badge-pick">
                            <i class="fa-solid fa-crown me-1"></i>Top Pick
                        </span>
                                    @elseif($product->badge == 'editor')
                                        <span class="badge-editor">
                            <i class="fa-solid fa-award me-1"></i>Editor
                        </span>
                                    @elseif($product->badge == 'deal')
                                        <span class="badge-deal">
                            <i class="fa-solid fa-fire me-1"></i>Deal
                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5">

                <span class="text-xs font-semibold text-primary">
                    {{ $product->category->name ?? '' }}
                </span>

                                <h3 class="font-display font-bold text-lg mt-1">
                                    <a href="{{ route('product-details',$product->slug) }}"
                                       class="text-slate-900 no-underline hover:text-primary">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="flex items-center gap-2 mt-2">
                    <span class="stars text-sm">
                        ★★★★★
                    </span>

                                    <span class="text-sm text-slate-400">
                        {{ $product->rating }}
                        ({{ number_format($product->reviews) }})
                    </span>
                                </div>

                                <ul class="text-sm text-slate-500 mt-3 list-none p-0 space-y-1">
                                    <li>
                                        <i class="fa-solid fa-check text-success me-2"></i>
                                        {{ $product->best_for }}
                                    </li>

                                    <li>
                                        <i class="fa-solid fa-battery-full text-success me-2"></i>
                                        {{ $product->battery }} battery
                                    </li>
                                </ul>

                                <div class="flex items-center justify-between mt-4">
                                    <div>
                        <span class="text-xl font-extrabold">
                            ${{ $product->price }}
                        </span>

                                        @if($product->old_price)
                                            <span class="text-slate-400 line-through text-sm">
                                ${{ $product->old_price }}
                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('product-details',$product->slug) }}"
                                       class="btn-grad text-sm no-underline">
                                        View
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>--}}
                <nav class="flex justify-center gap-2 mt-10">
                    <a href="#" class="btn-ghost text-sm no-underline"><i class="fa-solid fa-angle-left"></i></a>
                    <a href="#" class="btn-grad text-sm no-underline">1</a>
                    <a href="#" class="btn-ghost text-sm no-underline">2</a>
                    <a href="#" class="btn-ghost text-sm no-underline">3</a>
                    <a href="#" class="btn-ghost text-sm no-underline"><i class="fa-solid fa-angle-right"></i></a>
                </nav>
            </div>
        </div>
    </section>
@endsection


@push('js')

    <script>
        (function(){
            const D=window.AFFILI; const grid=document.getElementById('prodGrid');
            const stars=r=>{let h='';for(let i=1;i<=5;i++){h+= r>=i?'<i class="fa-solid fa-star"></i>':(r>=i-0.5?'<i class="fa-solid fa-star-half-stroke"></i>':'<i class="fa-regular fa-star"></i>');}return '<span class="stars text-sm">'+h+'</span>';};
            const badge=b=>({pick:'<span class="badge-pick"><i class="fa-solid fa-crown me-1"></i>Top Pick</span>',editor:'<span class="badge-editor"><i class="fa-solid fa-award me-1"></i>Editor</span>',deal:'<span class="badge-deal"><i class="fa-solid fa-fire me-1"></i>Deal</span>'}[b]||'');
            const card=p=>`<div class="card-premium" data-aos="fade-up" data-search-item="${p.name} ${p.cat}" data-cat="${p.cat}">
      <div class="relative"><div class="aspect-[4/3] bg-gradient-to-br from-blue-50 to-violet-50 grid place-items-center text-5xl text-primary"><i class="fa-solid fa-${p.icon}"></i></div><div class="absolute top-3 left-3">${badge(p.badge)}</div></div>
      <div class="p-5"><span class="text-xs font-semibold text-primary">${p.cat}</span>
      <h3 class="font-display font-bold text-lg mt-1"><a href="product-details.html" class="text-slate-900 no-underline hover:text-primary">${p.name}</a></h3>
      <div class="flex items-center gap-2 mt-2">${stars(p.rating)}<span class="text-sm text-slate-400">${p.rating} (${p.reviews.toLocaleString()})</span></div>
      <ul class="text-sm text-slate-500 mt-3 list-none p-0 space-y-1"><li><i class="fa-solid fa-check text-success me-2"></i>${p.best}</li><li><i class="fa-solid fa-battery-full text-success me-2"></i>${p.battery} battery</li></ul>
      <div class="flex items-center justify-between mt-4"><div><span class="text-xl font-extrabold">$${p.price}</span> <span class="text-slate-400 line-through text-sm">$${p.old}</span></div><a href="product-details.html" class="btn-grad text-sm no-underline">View</a></div></div></div>`;
            let cat='all',sort='rating';
            function render(){let arr=D.products.filter(p=>cat==='all'||p.cat===cat);
                arr.sort((a,b)=> sort==='low'?a.price-b.price: sort==='high'?b.price-a.price: sort==='reviews'?b.reviews-a.reviews: b.rating-a.rating);
                grid.innerHTML=arr.map(card).join(''); document.getElementById('resultCount').textContent=arr.length; if(window.AOS)AOS.refresh();}
            const cats=['all',...new Set(D.products.map(p=>p.cat))];
            document.getElementById('catChips').innerHTML=cats.map((c,i)=>`<button data-c="${c}" class="text-sm ${i===0?'btn-grad':'btn-ghost'} no-underline mb-1">${c==='all'?'All':c}</button>`).join('');
            document.querySelectorAll('#catChips button').forEach(b=>b.addEventListener('click',()=>{cat=b.dataset.c;document.querySelectorAll('#catChips button').forEach(x=>{x.classList.remove('btn-grad');x.classList.add('btn-ghost');});b.classList.add('btn-grad');b.classList.remove('btn-ghost');render();}));
            document.getElementById('sortSel').addEventListener('change',e=>{sort=e.target.value;render();});
            render();
        })();
    </script>
@endpush
