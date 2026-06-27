@extends('frontEnd.layout.app')

@section('title', 'Blog - Guides, Reviews & Deals')

@section('body')
    <section class="bg-hero pt-12 pb-12">
        <div class="container-x">
            <nav class="crumb text-sm mb-4" data-aos="fade-up">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i>
                <span class="text-slate-700 font-semibold">Blog</span>
            </nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">Guides, Reviews & Deals</h1>

            <!-- সার্চ বার -->
            <div class="mt-6 glass rounded-2xl p-2 flex items-center shadow-soft max-w-xl" data-aos="fade-up">
                <i class="fa-solid fa-magnifying-glass text-slate-400 px-3"></i>
                <input id="liveSearch" type="text" placeholder="Search articles..." class="flex-1 bg-transparent border-0 outline-none py-2" />
            </div>

            <!-- ক্যাটাগরি ফিল্টার বাটনসমূহ -->
            <div class="flex flex-wrap gap-2 mt-5" id="blogFilters">
                <button data-filter="all" class="text-sm btn-grad no-underline mb-1 px-3" style="height: 30px">All</button>
                @foreach($categories as $cat)
                    <button data-filter="{{ Str::slug($cat->name) }}" class="text-sm btn-ghost no-underline mb-1 px-3" style="height: 30px">{{ $cat->name }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ব্লগ গ্রিড -->
    <section class="py-12">
        <div class="container-x grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
                @include('frontEnd.component.blogCard',['blog' => $blog])
            @endforeach
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('liveSearch');
            const filterButtons = document.querySelectorAll('#blogFilters button');
            const articles = document.querySelectorAll('#blogGrid article');

            // লাইভ সার্চ এবং ক্যাটাগরি ফিল্টারিং এক সাথে কাজ করার জন্য ফাংশন
            function filterBlogs() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const activeFilter = document.querySelector('#blogFilters .btn-grad').getAttribute('data-filter');

                articles.forEach(article => {
                    const searchText = article.getAttribute('data-search-item');
                    const articleCat = article.getAttribute('data-cat');

                    const matchesSearch = searchText.includes(searchTerm);
                    const matchesCategory = (activeFilter === 'all' || articleCat === activeFilter);

                    if (matchesSearch && matchesCategory) {
                        article.style.display = 'block';
                    } else {
                        article.style.display = 'none';
                    }
                });
            }

            // সার্চ ইনপুট লিসেনার
            searchInput.addEventListener('input', filterBlogs);

            // ফিল্টার বাটন লিসেনার
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // অ্যাক্টিভ ক্লাস পরিবর্তন
                    filterButtons.forEach(btn => btn.classList.replace('btn-grad', 'btn-ghost'));
                    this.classList.replace('btn-ghost', 'btn-grad');

                    filterBlogs();
                });
            });
        });
    </script>
@endpush
