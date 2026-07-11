@extends('frontEnd.layout.app')
@section('title', 'Compare Products')
@section('body')
    <!-- প্রিমিয়াম হিরো সেকশন - মোবাইলের জন্য প্যাডিং কমানো হয়েছে -->
    <section class="bg-gradient-to-b from-slate-50 to-slate-100/50 pt-6 pb-6 md:pt-16 md:pb-16 border-b border-slate-200/60">
        <div class="container-xxl  px-3 md:px-4">
            <!-- ব্রেডক্রাম্ব - মোবাইলের জন্য মার্জিন কমানো হয়েছে -->
            <nav class="crumb text-xs md:text-sm mb-3 md:mb-5" data-aos="fade-up">
                <a href="{{route('home')}}" class="text-slate-400 hover:text-primary transition no-underline">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 mx-1.5 md:mx-2 text-[10px] md:text-xs"></i>
                <span class="text-slate-600 font-semibold">Compare</span>
            </nav>
            <span class="eyebrow bg-blue-50 text-blue-600 px-2.5 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-bold tracking-wider uppercase" data-aos="fade-up">Make the smart choice</span>

            <!-- হিরো কন্টেন্ট টাইটেল - মোবাইলের জন্য মার্জিন এবং ফন্ট অপ্টিমাইজড -->
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mt-3 md:mt-4" data-aos="fade-up">
                <div>
                    <h1 class="font-display text-2xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">Side-by-Side Comparison</h1>
                    <p class="text-slate-500 mt-1 md:mt-2 text-xs md:text-base max-w-xl leading-relaxed">Compare specifications, pricing, pros and cons effortlessly to choose the best option.</p>
                </div>
                {{-- Clear All বাটন - মোবাইলের জন্য কম প্যাডিং --}}
                <button type="button" id="btnClearCompare" class="btn px-3 py-2 md:px-4 md:py-2.5 rounded-xl font-bold text-xs md:text-sm transition d-flex align-items-center gap-1.5 {{ count(session()->get('compare_products', [])) >= 2 ? '' : 'd-none' }}" style="border: 1px solid #fee2e2; color: #ef4444; background-color: #fef2f2; cursor:pointer;">
                    <i class="fa-solid fa-trash-can text-[10px] md:text-xs"></i> Clear List
                </button>
            </div>
        </div>
    </section>

    <!-- টেবিল সেকশন - মোবাইলের প্যাডিং py-16 থেকে কমিয়ে py-4 করা হয়েছে -->
    <section class="py-4 md:py-16 bg-white">
        <div class="container-xxl  px-2 md:px-4">
            {{-- টেবিল কন্টেইনার - AJAX শ্যাডো এবং বর্ডার মোবাইলের জন্য কম্প্যাক্ট করা হয়েছে --}}
            <div class="overflow-x-auto card-premium shadow-md md:shadow-xl rounded-xl md:rounded-2xl border border-slate-100" id="compareTableContainer" data-aos="fade-up">
                @include('frontEnd.compare.compare_table')
            </div>
        </div>
    </section>
@endsection
