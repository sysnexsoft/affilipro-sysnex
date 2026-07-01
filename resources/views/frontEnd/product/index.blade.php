@extends('frontEnd.layout.app')
@section('title', 'All Products')
@section('body')
    <section class="pt-8 md:pt-12 bg-gradient-to-b from-slate-50 to-slate-100/50 border-b border-slate-200/40">
        <div class="container-xxl px-3 md:px-4">
            <nav class="crumb text-xs md:text-sm mb-3 md:mb-4" data-aos="fade-up">
                <a href="{{route('home')}}" class="text-slate-400 hover:text-primary transition no-underline">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 mx-1.5 text-[10px] md:text-xs"></i>
                <span class="text-slate-700 font-semibold">Products</span>
            </nav>
            <div class="mt-1 md:mt-2 bg-white border border-slate-200 rounded-2xl p-1.5 flex items-center shadow-md max-w-xl w-full transition-all duration-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20" data-aos="fade-up">
                <div class="flex items-center ps-2 pe-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                </div>

                <input id="liveSearch"
                       type="text"
                       placeholder="Search products..."
                       class="flex-1 bg-transparent border-0 shadow-none outline-none px-2 py-1.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-0 focus:ring-0"
                       style="box-shadow: none !important; border: none !important; outline: none !important;" />

                {{--<button type="button"
                        id="btnSearchSubmit"
                        class="bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm hover:shadow flex-shrink-0 cursor-pointer flex items-center gap-1.5 border-0">
                    <span>Search</span>
                    <i class="fa-solid fa-arrow-right text-[10px] opacity-80"></i>
                </button>--}}
            </div>
        </div>
    </section>
    <section class="py-2">
        <div class="container-xxl grid lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                <div class="card-premium p-3 sticky" data-aos="fade-right">
                    <h3 class="font-bold mb-4"><i class="fa-solid fa-sliders text-primary me-2"></i>Filters</h3>

                    <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-500">Category</h4>
                    <div class="flex flex-wrap align-items-center gap-1" id="catChips">
                        <button data-c="all" class="text-sm btn-ghost no-underline mb-1 px-3" style="height: 30px">All</button>
                        @foreach($categories as $cat)
                            <button data-c="{{ $cat->slug }}" class="text-sm btn-ghost no-underline mb-1 px-3" style="height: 30px">{{ $cat->name }}</button>
                        @endforeach
                    </div>

                    <hr class="my-3" />

                    <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-500">Brands</h4>
                    <div class="flex flex-wrap align-items-center gap-1" id="brandChips">
                        <button data-b="all" class="text-sm btn-ghost no-underline mb-1 px-3" style="height: 30px">All</button>
                        @foreach($brands as $brand)
                            <button data-b="{{ $brand->slug }}" class="text-sm btn-ghost no-underline mb-1 px-3" style="height: 30px">{{ $brand->name }}</button>
                        @endforeach
                    </div>

                    <hr class="my-3" />

                    <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-500">Sort by</h4>
                    <select id="sortSel" class="form-select rounded-xl">
                        <option value="rating">Top rated</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="reviews">Most reviewed</option>
                    </select>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-slate-500 m-0"><span id="resultCount">{{ count($products) }}</span> products found</p>
                </div>

                <div id="prodGrid" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('frontEnd.component.productcard',['product' => $product])
                    @endforeach
                </div>

                <div class="text-center mt-12" id="loadMoreContainer">
                    <button id="loadMoreBtn" class="btn-grad px-6 py-2.5 rounded-xl font-medium shadow-md transition-all inline-flex items-center gap-2">
                        <span>Load More Products</span>
                        <i class="fa-solid fa-spinner fa-spin d-none" id="loadMoreSpinner"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // ১. URL এবং পেজিনেশন স্টেট ম্যানেজমেন্ট
            const urlParams = new URLSearchParams(window.location.search);
            let currentCat = urlParams.get('category') || 'all';
            let currentBrand = urlParams.get('brand') || 'all';
            let currentSort = urlParams.get('sort') || 'rating';
            let searchQuery = urlParams.get('search') || '';
            let currentPage = 1;
            let searchTimeout = null;

            // ফর্ম এবং ফিল্টারের প্রাথমিক ভ্যালু সেট করা
            $('#liveSearch').val(searchQuery);
            $('#sortSel').val(currentSort);
            setActiveCatChip(currentCat);
            setActiveBrandChip(currentBrand);

            // ২. প্রধান AJAX প্রোডাক্ট ফেচ ফাংশন
            function fetchProducts(isLoadMore = false) {
                if (!isLoadMore) {
                    currentPage = 1; // ফিল্টার বদলালে পেজ আবার ১ থেকে শুরু হবে
                    $('#prodGrid').css('opacity', '0.5');
                } else {
                    $('#loadMoreBtn').prop('disabled', true);
                    $('#loadMoreSpinner').removeClass('d-none');
                }

                const params = new URLSearchParams({
                    category: currentCat,
                    brand: currentBrand,
                    sort: currentSort,
                    search: searchQuery,
                    page: currentPage
                });

                // রিফ্রেশ ছাড়া URL আপডেট করা
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({ path: newUrl }, '', newUrl);

                // jQuery AJAX কল
                $.ajax({
                    url: `{{ route('product') }}?${params.toString()}`,
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        if (isLoadMore) {
                            $('#prodGrid').append(data.html); // নিচে যুক্ত হবে
                            $('#loadMoreBtn').prop('disabled', false);
                            $('#loadMoreSpinner').addClass('d-none');
                        } else {
                            $('#prodGrid').html(data.html).css('opacity', '1'); // পুরো গ্রিড রিপ্লেস হবে
                        }

                        $('#resultCount').text(data.count);

                        // আরও পেজ আছে কি না তার ওপর ভিত্তি করে বাটন হাইড/শো
                        if (data.has_more) {
                            $('#loadMoreContainer').removeClass('d-none');
                        } else {
                            $('#loadMoreContainer').addClass('d-none');
                        }

                        if (window.AOS) AOS.refresh();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#prodGrid').css('opacity', '1');
                        $('#loadMoreBtn').prop('disabled', false);
                        $('#loadMoreSpinner').addClass('d-none');
                    }
                });
            }

            // ৩. ইভেন্ট হ্যান্ডলারসমূহ (jQuery-তে কনভার্ট করা)

            // লোড মোর বাটন ক্লিক
            $('#loadMoreBtn').on('click', function() {
                currentPage++;
                fetchProducts(true);
            });

            // ক্যাটাগরি চিপস ক্লিক
            $('#catChips').on('click', 'button', function() {
                currentCat = $(this).data('c');
                setActiveCatChip(currentCat);
                fetchProducts(false);
            });

            // ব্র্যান্ড চিপস ক্লিক
            $('#brandChips').on('click', 'button', function() {
                currentBrand = $(this).data('b');
                setActiveBrandChip(currentBrand);
                fetchProducts(false);
            });

            // সর্টিং ড্রপডাউন পরিবর্তন
            $('#sortSel').on('change', function() {
                currentSort = $(this).val();
                fetchProducts(false);
            });

            // লাইভ সার্চ ডিবান্সিং
            $('#liveSearch').on('input', function() {
                searchQuery = $(this).val();
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    fetchProducts(false);
                }, 400);
            });

            // একটিভ চিপ স্টাইল ফাংশন
            function setActiveCatChip(catSlug) {
                $('#catChips button').each(function() {
                    const isMatch = $(this).data('c') == catSlug;
                    $(this).toggleClass('btn-grad', isMatch).toggleClass('btn-ghost', !isMatch);
                });
            }

            function setActiveBrandChip(brandSlug) {
                $('#brandChips button').each(function() {
                    const isMatch = $(this).data('b') == brandSlug;
                    $(this).toggleClass('btn-grad', isMatch).toggleClass('btn-ghost', !isMatch);
                });
            }

            // ব্রাউজার ব্যাক/ফরওয়ার্ড বাটন হ্যান্ডলার
            $(window).on('popstate', function() {
                const updatedParams = new URLSearchParams(window.location.search);
                currentCat = updatedParams.get('category') || 'all';
                currentBrand = updatedParams.get('brand') || 'all';
                currentSort = updatedParams.get('sort') || 'rating';
                searchQuery = updatedParams.get('search') || '';

                $('#liveSearch').val(searchQuery);
                $('#sortSel').val(currentSort);
                setActiveCatChip(currentCat);
                setActiveBrandChip(currentBrand);

                fetchProducts(false);
            });
        });
    </script>
@endpush
