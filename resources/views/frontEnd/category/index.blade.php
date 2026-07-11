@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <section class="bg-hero pt-5 pb-5">
        <div class="container-xxl ">
            <nav class="crumb text-sm mb-4" data-aos="fade-up"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">Categories</span></nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">Browse Categories</h1>
        </div>
    </section>
    <section class="py-12">
        <div class="container-xxl ">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach($categories as $category)
                <a href="{{route('product',[ 'category' => $category->slug ])}}" class="card-premium p-4 text-center no-underline aos-init aos-animate" data-aos="zoom-in">
                    <span class="w-14 h-14 rounded-2xl bg-gradient-primary text-white grid place-items-center text-2xl mx-auto">
                        <img class="img-fluid rounded-2" src="{{asset($category->image)}}" alt="">
                    </span>
                    <h3 class="font-bold text-slate-900 mt-3 mb-0">{{$category->name}}</h3>
                    <p class="text-sm text-slate-400 m-0">{{ $category->products_count }} products</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        (function(){const D=window.AFFILI;
            document.getElementById('allCats').innerHTML=D.categories.map(c=>`<a href="category.html" class="card-premium p-5 text-center no-underline" data-aos="zoom-in"><span class="w-14 h-14 rounded-2xl bg-gradient-primary text-white grid place-items-center text-2xl mx-auto"><i class="fa-solid fa-${c.icon}"></i></span><h3 class="font-bold text-slate-900 mt-3 mb-0">${c.name}</h3><p class="text-sm text-slate-400 m-0">${c.count} products</p></a>`).join('');
            const stars=r=>{let h='';for(let i=1;i<=5;i++)h+= r>=i?'<i class="fa-solid fa-star"></i>':'<i class="fa-regular fa-star"></i>';return '<span class="stars text-sm">'+h+'</span>';};
            document.getElementById('catProducts').innerHTML=D.products.map(p=>`<div class="card-premium" data-aos="fade-up"><div class="aspect-[4/3] bg-gradient-to-br from-blue-50 to-violet-50 grid place-items-center text-5xl text-primary"><i class="fa-solid fa-${p.icon}"></i></div><div class="p-5"><h3 class="font-bold"><a href="product-details.html" class="text-slate-900 no-underline hover:text-primary">${p.name}</a></h3>${stars(p.rating)}<div class="flex items-center justify-between mt-3"><span class="font-extrabold">$${p.price}</span><a href="product-details.html" class="btn-grad text-sm no-underline">View</a></div></div></div>`).slice(0,4).join('');
        })();
    </script>
@endpush
