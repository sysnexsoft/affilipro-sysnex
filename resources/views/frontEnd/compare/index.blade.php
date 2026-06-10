@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <section class="bg-hero pt-12 pb-12">
        <div class="container-x">
            <nav class="crumb text-sm mb-4" data-aos="fade-up"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">Compare</span></nav>
            <span class="eyebrow" data-aos="fade-up">Make the smart choice</span>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold mt-4" data-aos="fade-up">Side-by-Side Comparison</h1>
            <p class="text-slate-600 mt-3 max-w-xl" data-aos="fade-up">Our top 3 picks compared across every metric that matters.</p>
        </div>
    </section>
    <section class="py-12">
        <div class="container-x overflow-x-auto card-premium" data-aos="fade-up">
            <table class="table align-middle mb-0 min-w-[760px]" id="compTable"></table>
        </div>
    </section>
@endsection
@push('js')
    <script>
        (function(){
            const D=window.AFFILI; const items=D.products.slice(0,3);
            const stars=r=>{let h='';for(let i=1;i<=5;i++)h+= r>=i?'<i class="fa-solid fa-star"></i>':(r>=i-0.5?'<i class="fa-solid fa-star-half-stroke"></i>':'<i class="fa-regular fa-star"></i>');return '<span class="stars">'+h+'</span>';};
            const head=`<thead><tr><th class="p-4 bg-slate-50">Compare</th>${items.map((p,i)=>`<th class="p-4 text-center ${i===0?'bg-blue-50':''}">${i===0?'<span class="badge-pick mb-2 d-inline-block">Best Pick</span><br>':''}<div class="text-4xl text-primary mb-2"><i class="fa-solid fa-${p.icon}"></i></div><div class="font-bold">${p.name}</div></th>`).join('')}</tr></thead>`;
            const rows=[
                ['Rating',items.map(p=>`${stars(p.rating)}<div class="text-xs text-slate-400">${p.rating}/5</div>`)],
                ['Price',items.map(p=>`<span class="text-xl font-extrabold">$${p.price}</span> <span class="line-through text-slate-400 text-sm">$${p.old}</span>`)],
                ['Reviews',items.map(p=>p.reviews.toLocaleString())],
                ['Battery',items.map(p=>p.battery)],
                ['Best for',items.map(p=>p.best)],
                ['Pros',items.map(()=>'<i class="fa-solid fa-circle-check text-success me-1"></i>Great value<br><i class="fa-solid fa-circle-check text-success me-1"></i>Reliable')],
                ['Cons',items.map(()=>'<i class="fa-solid fa-circle-xmark text-red-500 me-1"></i>Minor quirks')],
                ['Warranty',items.map(()=>'2 years')]
            ];
            const body='<tbody>'+rows.map(r=>`<tr><td class="p-4 fw-bold text-slate-500">${r[0]}</td>${r[1].map((c,i)=>`<td class="p-4 text-center ${i===0?'bg-blue-50/40':''}">${c}</td>`).join('')}</tr>`).join('')
                +`<tr><td class="p-4"></td>${items.map(()=>`<td class="p-4 text-center"><a href="product-details.html" class="btn-grad text-sm no-underline">Buy Now</a></td>`).join('')}</tr></tbody>`;
            document.getElementById('compTable').innerHTML=head+body;
        })();
    </script>
@endpush
