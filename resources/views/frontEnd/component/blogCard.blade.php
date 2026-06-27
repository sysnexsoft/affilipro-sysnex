<article class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full"
         data-aos="fade-up"
         data-search-item="{{ strtolower($blog->title) }} {{ strtolower($blog->category->name ?? '') }}"
         data-cat="{{ Str::slug($blog->category->name ?? '') }}">

    <!-- ইমেজ সেকশন + হোভার জুম অ্যানিমেশন -->
    <a href="{{ route('blog.details', $blog->slug) }}" class="block aspect-video bg-gradient-to-br from-violet-50 to-cyan-50 overflow-hidden no-underline relative">
        @if($blog->thumbnail)
            <img src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-full grid place-items-center text-5xl text-secondary transition-transform duration-500 group-hover:scale-105">
                <i class="fa-solid fa-file-lines text-slate-300"></i>
            </div>
    @endif

    <!-- ক্যাটাগরি ব্যাজ (ইমেজের ওপর টপ-লেফটে প্রিমিয়াম লুকের জন্য) -->
        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-xs font-bold px-2.5 py-1 rounded-lg text-slate-800 shadow-sm border border-white/20">
            {{ $blog->category->name ?? 'Uncategorized' }}
        </span>
    </a>

    <!-- কন্টেন্ট সেকশন -->
    <div class="p-5 flex flex-col flex-1">
        <!-- টাইটেল -->
        <h3 class="font-display font-bold text-xl text-slate-900 leading-snug group-hover:text-primary transition-colors duration-200">
            <a href="{{ route('blog.details', $blog->slug) }}" class="no-underline text-inherit">
                {{ $blog->title }}
            </a>
        </h3>

        <!-- শর্ট ডেসক্রিপশন (লাইন-ক্ল্যাম্প ব্যবহার করে ২ লাইনে ফিক্সড করা হয়েছে) -->
        <p class="text-slate-500 text-sm mt-3 line-clamp-2 flex-1 leading-relaxed">
            {{ strip_tags($blog->description) }}
        </p>

        <!-- ডিভাইডার লাইন -->
        <div class="border-t border-slate-100 my-4"></div>

        <!-- মেটা ইনফো (লেখক ও তারিখ) -->
        <div class="flex items-center justify-between text-xs font-medium text-slate-500">
            <span class="flex items-center gap-1.5 bg-slate-50 px-2.5 py-1 rounded-md">
                <i class="fa-regular fa-user text-slate-400"></i>
                <span class="text-slate-700">{{ $blog->user->name ?? env('APP_NAME') }}</span>
            </span>
            <span class="flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-slate-400"></i>
                {{ $blog->created_at->format('M d, Y') }}
            </span>
        </div>
    </div>
</article>
