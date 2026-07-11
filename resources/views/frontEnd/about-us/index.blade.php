@extends('frontEnd.layout.app')
@section('title', 'About Our Mission')
@section('body')
    @php
        $about = is_array($about_us) ? $about_us : json_decode($about_us, true) ?? [];
    @endphp

    <section class="relative bg-slate-50 border-b border-slate-100 pt-20 pb-16 overflow-hidden">
        <div class="absolute inset-0 opacity-40 pointer-events-none bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="container-xxl max-w-4xl relative text-center">
            <nav class="crumb inline-flex items-center gap-2 text-xs bg-white px-3 py-1.5 rounded-full shadow-sm border border-slate-100 mb-6">
                <a href="{{route('home')}}" class="text-slate-500 hover:text-primary transition">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 text-[10px]"></i>
                <span class="text-slate-800 font-medium">About Us</span>
            </nav>
            <br>
            <span class="inline-block bg-blue-50 text-primary text-xs uppercase font-extrabold tracking-wider px-3 py-1 rounded-md mb-4" data-aos="fade-up">
                {{ $about['hero_badge'] ?? 'Our Mission' }}
            </span>
            <h1 class="font-display text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight max-w-3xl mx-auto" data-aos="fade-up">
                {{ $about['hero_title'] ?? 'Honest reviews you can actually trust' }}
            </h1>
            <p class="text-lg md:text-xl text-slate-600 font-normal mt-6 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up">
                {{ $about['hero_desc'] ?? 'AffiliPro exists to cut through marketing hype. We buy, test and score products independently so you make confident decisions and never overpay.' }}
            </p>
        </div>
    </section>

    <section class="relative -mt-8 z-10">
        <div class="container-xxl max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white p-4 rounded-2xl shadow-xl shadow-slate-100 border border-slate-100/80">
                <div class="p-6 text-center border-b md:border-b-0 md:border-r border-slate-100" data-aos="fade-up">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $about['stat1_val'] ?? '2.4M+' }}</div>
                    <p class="text-slate-500 font-medium text-sm mt-2 mb-0">{{ $about['stat1_lbl'] ?? 'Monthly readers' }}</p>
                </div>
                <div class="p-6 text-center border-b md:border-b-0 md:border-r border-slate-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $about['stat2_val'] ?? '5,000+' }}</div>
                    <p class="text-slate-500 font-medium text-sm mt-2 mb-0">{{ $about['stat2_lbl'] ?? 'Products tested' }}</p>
                </div>
                <div class="p-6 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $about['stat3_val'] ?? '30-pt' }}</div>
                    <p class="text-slate-500 font-medium text-sm mt-2 mb-0">{{ $about['stat3_lbl'] ?? 'Testing rubric' }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container-xxl max-w-5xl">
            <div class="text-center mb-12">
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl">
                    {{ $about['feat_title'] ?? 'How We Maintain Editorial Integrity' }}
                </h2>
                <div class="w-12 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-50 border border-slate-100 p-8 rounded-2xl hover:scale-[1.02] hover:shadow-lg transition-all duration-300" data-aos="fade-up">
                    <span class="w-12 h-12 rounded-xl bg-blue-100 text-primary grid place-items-center text-xl mb-5 shadow-sm"><i class="fa-solid fa-box-open"></i></span>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $about['f1_title'] ?? 'We buy it ourselves.' }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed m-0">{{ $about['f1_desc'] ?? 'No free samples or vendor kickbacks that bias our evaluation scores.' }}</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 p-8 rounded-2xl hover:scale-[1.02] hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <span class="w-12 h-12 rounded-xl bg-blue-100 text-primary grid place-items-center text-xl mb-5 shadow-sm"><i class="fa-solid fa-flask-vial"></i></span>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $about['f2_title'] ?? 'Lab + real-world tests.' }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed m-0">{{ $about['f2_desc'] ?? 'Standardized measurement rubrics across everyday use cases.' }}</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 p-8 rounded-2xl hover:scale-[1.02] hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <span class="w-12 h-12 rounded-xl bg-blue-100 text-primary grid place-items-center text-xl mb-5 shadow-sm"><i class="fa-solid fa-scale-balanced"></i></span>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $about['f3_title'] ?? 'Score & compare.' }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed m-0">{{ $about['f3_desc'] ?? 'Transparent data and repeatable metrics with no black box math.' }}</p>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($about['quote_text']))
        <section class="py-12 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/40 to-indigo-900/40 opacity-70"></div>
            <div class="container-xxl max-w-4xl relative text-center px-6" data-aos="zoom-in">
                <i class="fa-solid fa-quote-left text-4xl text-blue-400 opacity-60 mb-4"></i>
                <blockquote class="text-xl md:text-2xl font-medium italic leading-relaxed max-w-3xl mx-auto">
                    "{{ $about['quote_text'] }}"
                </blockquote>
                <div class="mt-6 text-sm font-semibold uppercase tracking-wider text-blue-400">
                    {{ $about['quote_author'] ?? '— The Editorial Team' }}
                </div>
            </div>
        </section>
    @endif

    {{--<section class="py-20 bg-slate-50/50">
        <div class="container-xxl max-w-5xl text-center">
            <h2 class="font-display text-3xl font-extrabold tracking-tight text-slate-900 mb-12" data-aos="fade-up">Meet our product experts</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm" data-aos="fade-up"><span class="w-16 h-16 rounded-full bg-blue-600 text-white grid place-items-center text-2xl font-bold mx-auto shadow-md shadow-blue-100">A</span><h3 class="font-bold text-slate-800 mt-4 mb-0">Alex Reed</h3><p class="text-xs text-slate-400 mt-1">Audio Lead</p></div>
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm" data-aos="fade-up" data-aos-delay="100"><span class="w-16 h-16 rounded-full bg-indigo-500 text-white grid place-items-center text-2xl font-bold mx-auto shadow-md shadow-indigo-100">M</span><h3 class="font-bold text-slate-800 mt-4 mb-0">Mia Chen</h3><p class="text-xs text-slate-400 mt-1">Laptops & Tech</p></div>
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm" data-aos="fade-up" data-aos-delay="200"><span class="w-16 h-16 rounded-full bg-emerald-500 text-white grid place-items-center text-2xl font-bold mx-auto shadow-md shadow-emerald-100">T</span><h3 class="font-bold text-slate-800 mt-4 mb-0">Tom Blake</h3><p class="text-xs text-slate-400 mt-1">Smart Home</p></div>
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm" data-aos="fade-up" data-aos-delay="300"><span class="w-16 h-16 rounded-full bg-violet-500 text-white grid place-items-center text-2xl font-bold mx-auto shadow-md shadow-violet-100">L</span><h3 class="font-bold text-slate-800 mt-4 mb-0">Lisa Romano</h3><p class="text-xs text-slate-400 mt-1">Cameras</p></div>
            </div>
        </div>
    </section>--}}
@endsection
