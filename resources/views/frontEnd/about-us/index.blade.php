@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <section class="bg-hero pt-14 pb-14">
        <div class="container-x max-w-3xl">
            <nav class="crumb text-sm mb-4"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">About</span></nav>
            <span class="eyebrow" data-aos="fade-up">Our mission</span>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold mt-4" data-aos="fade-up">Honest reviews you can actually trust</h1>
            <p class="text-lg text-slate-600 mt-4" data-aos="fade-up">AffiliPro exists to cut through marketing hype. We buy, test and score products independently so you make confident decisions and never overpay.</p>
        </div>
    </section>
    <section class="py-14">
        <div class="container-x grid md:grid-cols-3 gap-6">
            <div class="card-premium p-6 text-center" data-aos="fade-up"><div class="text-4xl font-extrabold text-gradient">2.4M+</div><p class="text-slate-500 mt-2 mb-0">Monthly readers</p></div>
            <div class="card-premium p-6 text-center" data-aos="fade-up"><div class="text-4xl font-extrabold text-gradient">5,000+</div><p class="text-slate-500 mt-2 mb-0">Products tested</p></div>
            <div class="card-premium p-6 text-center" data-aos="fade-up"><div class="text-4xl font-extrabold text-gradient">30-pt</div><p class="text-slate-500 mt-2 mb-0">Testing rubric</p></div>
        </div>
    </section>
    <section class="py-10 bg-white">
        <div class="container-x grid lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h2 class="font-display text-3xl font-extrabold mb-4">How we test</h2>
                <ul class="list-none p-0 space-y-4">
                    <li class="flex gap-3"><span class="w-10 h-10 rounded-xl bg-blue-50 text-primary grid place-items-center shrink-0"><i class="fa-solid fa-box-open"></i></span><div><strong>We buy it ourselves.</strong><p class="text-slate-500 m-0">No free samples that bias our scores.</p></div></li>
                    <li class="flex gap-3"><span class="w-10 h-10 rounded-xl bg-blue-50 text-primary grid place-items-center shrink-0"><i class="fa-solid fa-flask-vial"></i></span><div><strong>Lab + real-world tests.</strong><p class="text-slate-500 m-0">Standardized 30-point measurement.</p></div></li>
                    <li class="flex gap-3"><span class="w-10 h-10 rounded-xl bg-blue-50 text-primary grid place-items-center shrink-0"><i class="fa-solid fa-scale-balanced"></i></span><div><strong>Score & compare.</strong><p class="text-slate-500 m-0">Transparent, repeatable rankings.</p></div></li>
                </ul>
            </div>
            <div class="card-premium p-8 bg-gradient-primary text-white" data-aos="fade-left">
                <i class="fa-solid fa-quote-left text-3xl"></i>
                <p class="text-xl mt-3">"We only recommend what we'd buy ourselves. That promise drives everything we publish."</p>
                <div class="mt-4 font-bold">— The AffiliPro Editorial Team</div>
            </div>
        </div>
    </section>
    <section class="py-14">
        <div class="container-x text-center">
            <h2 class="font-display text-3xl font-extrabold mb-8" data-aos="fade-up">Meet the team</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card-premium p-6" data-aos="fade-up"><span class="w-20 h-20 rounded-full bg-gradient-primary text-white grid place-items-center text-3xl font-bold mx-auto">A</span><h3 class="font-bold mt-4 mb-0">Alex Reed</h3><p class="text-sm text-slate-400">Audio Lead</p></div>
                <div class="card-premium p-6" data-aos="fade-up"><span class="w-20 h-20 rounded-full bg-gradient-accent text-white grid place-items-center text-3xl font-bold mx-auto">M</span><h3 class="font-bold mt-4 mb-0">Mia Chen</h3><p class="text-sm text-slate-400">Laptops & Tech</p></div>
                <div class="card-premium p-6" data-aos="fade-up"><span class="w-20 h-20 rounded-full bg-gradient-success text-white grid place-items-center text-3xl font-bold mx-auto">T</span><h3 class="font-bold mt-4 mb-0">Tom Blake</h3><p class="text-sm text-slate-400">Smart Home</p></div>
                <div class="card-premium p-6" data-aos="fade-up"><span class="w-20 h-20 rounded-full bg-gradient-primary text-white grid place-items-center text-3xl font-bold mx-auto">L</span><h3 class="font-bold mt-4 mb-0">Lisa Romano</h3><p class="text-sm text-slate-400">Cameras</p></div>
            </div>
        </div>
    </section>
@endsection
