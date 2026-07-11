@extends('frontEnd.layout.app')

@section('body')
    @php
        // কন্টেন্টের শব্দ সংখ্যার ওপর ভিত্তি করে রিডিং টাইম হিসাব করা (অটোমেটিক)
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = max(1, ceil($wordCount / 200));
    @endphp

    <!-- স্ক্রোল প্রোগ্রেস বার -->
    <div class="fixed top-0 left-0 w-full h-[3px] bg-slate-100 z-50">
        <div id="scroll-bar" class="h-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 transition-all duration-75 shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: 0%"></div>
    </div>

    <!-- আল্ট্রা-মিনিমাল হেডার সেকশন -->
    <div class="relative bg-slate-950 text-white overflow-hidden py-20 border-b border-slate-900">
        <!-- ব্যাকগ্রাউন্ড মডার্ন গ্লো ইফেক্ট -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="container-xxl relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <!-- ডাইনামিক বোল্ড টাইটেল -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white mb-4 leading-tight">
                    {{ $title }}
                </h1>

                <!-- মিনিমাল রিডিং টাইম ও ট্রাস্ট ইন্ডিকেটর -->
                <div class="flex items-center justify-center gap-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <span class="flex items-center gap-1.5 text-indigo-400">
                    <i class="fa-regular fa-clock"></i> {{ $readingTime }} Min Read
                </span>
                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                    <span class="text-emerald-400 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i> Verified
                </span>
                </div>
            </div>
        </div>
    </div>

    <!-- মেইন কন্টেন্ট এরিয়া (ক্লিন ১-কলাম মেথড) -->
    <div class="bg-[#fcfdfe] py-16">
        <div class="container-xxl">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white p-6 sm:p-10 md:p-14 rounded-3xl border border-slate-200/40 shadow-[0_10px_30px_rgba(0,0,0,0.02)]">

                    <!-- আল্ট্রা-প্রিমিয়াম টাইপোগ্রাফি স্টাইলিং -->
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-[16px]
                            prose-headings:font-black prose-headings:text-slate-900 prose-headings:tracking-tight prose-headings:mt-10 prose-headings:mb-4
                            prose-h2:text-2xl prose-h2:border-b prose-h2:border-slate-100 prose-h2:pb-2
                            prose-p:text-justify prose-p:mb-6 prose-p:leading-8
                            prose-li:my-2 prose-ul:pl-5
                            prose-a:text-indigo-600 prose-a:underline-offset-4 prose-a:decoration-indigo-300 hover:prose-a:text-indigo-700 prose-a:font-semibold">
                        {!! $content !!}
                    </div>

                    <!-- ফুটনোট নোটিশ বক্স -->
                    <div class="mt-12 p-6 rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50/30 border border-slate-200/60 flex flex-col sm:flex-row gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-indigo-200">
                            <i class="fa-solid fa-circle-info text-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-slate-900 font-bold mb-1">Need help or further clarification?</h6>
                            <p class="text-xs text-slate-500 leading-relaxed mb-3">
                                If you have questions regarding the terms or policies outlined on this page, please feel free to reach out to our team.
                            </p>
                            <a href="{{ route('contact-us') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 no-underline inline-flex items-center gap-1 transition-all">
                                Contact Us <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- স্ক্রোল বার স্ক্রিপ্ট -->
    <script>
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("scroll-bar").style.width = scrolled + "%";
        };
    </script>
@endsection
