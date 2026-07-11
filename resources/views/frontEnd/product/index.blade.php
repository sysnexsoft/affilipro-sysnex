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
            <aside class="lg:col-span-0">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] sticky top-6" data-aos="fade-right">

                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-sliders text-sm"></i>
                            </div>
                            <h3 class="font-bold text-base text-slate-800 tracking-tight">Filters</h3>
                        </div>
                        <a href="{{ route('product') }}" class="text-xs font-semibold text-slate-400 hover:text-primary transition-colors flex items-center gap-1.5 bg-slate-50 hover:bg-primary/5 px-3 py-1.5 rounded-full no-underline">
                            <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset
                        </a>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold mb-3 text-[11px] uppercase tracking-widest text-slate-400/90 flex items-center gap-2">
                            <span>Category</span>
                            <span class="h-px bg-slate-100 flex-1"></span>
                        </h4>

                        <div class="flex flex-col gap-1 max-h-100 overflow-y-auto pr-1 scrollbar-thin" id="catChips">
                            <label class="flex items-center justify-between px-3 py-1 rounded-xl cursor-pointer hover:bg-slate-50 group transition-all duration-200 dynamic-filter-row">
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-primary transition-colors">All Categories</span>
                                <input type="radio" name="category_filter" data-c="all" checked class="peer sr-only">
                                <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all flex-shrink-0">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                            </label>

                            {{-- ক্যাটাগরি লুপ (শুধু প্যারেন্ট ক্যাটাগরিগুলো আসবে প্রথমে) --}}
                            @foreach($categories->where('parent_id', null) as $cat)
                                <div class="category-group flex flex-col w-full">

                                    <div class="flex items-center justify-between rounded-xl hover:bg-slate-50/80 group transition-all duration-200 pr-3 class-row dynamic-filter-row">
                                        <label class="flex-1 flex items-center justify-between px-3 cursor-pointer">
                                            <span class="text-sm font-semibold text-slate-700 group-hover:text-primary transition-colors text-left break-words max-w-[80%]">{{ $cat->name }}</span>
                                            <input type="radio" name="category_filter" data-c="{{ $cat->slug }}" class="peer sr-only">
                                            <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all flex-shrink-0">
                                                <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                            </div>
                                        </label>

                                        @if($cat->children->count() > 0)
                                            <button class="w-6 h-6 rounded-lg hover:bg-slate-200/50 flex items-center justify-center text-slate-400 text-[10px] transition-transform toggle-children-btn" type="button">
                                                <i class="fa-solid fa-chevron-right transition-transform duration-200"></i>
                                            </button>
                                        @endif
                                    </div>

                                    @if($cat->children->count() > 0)
                                        <div class="child-wrapper hidden flex-col pl-4 border-l border-slate-100 ml-5 my-1 gap-0.5">
                                            @foreach($cat->children as $child)
                                                <label class="flex items-center justify-between px-3 py-2 rounded-lg cursor-pointer hover:bg-slate-50 group transition-all duration-200 dynamic-filter-row">
                                                    <span class="text-xs font-medium text-slate-500 group-hover:text-primary transition-colors text-left break-words max-w-[80%]">{{ $child->name }}</span>
                                                    <input type="radio" name="category_filter" data-c="{{ $child->slug }}" class="peer sr-only">
                                                    <div class="w-3.5 h-3.5 rounded-full border border-slate-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all flex-shrink-0">
                                                        <div class="w-1 h-1 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold mb-3 text-[11px] uppercase tracking-widest text-slate-400/90 flex items-center gap-2">
                            <span>Brands</span>
                            <span class="h-px bg-slate-100 flex-1"></span>
                        </h4>
                        <div class="flex flex-col gap-1 max-h-56 overflow-y-auto pr-1 scrollbar-thin" id="brandChips">
                            <label class="flex items-center justify-between px-3 rounded-xl cursor-pointer hover:bg-slate-50 group transition-all duration-200 dynamic-filter-row">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-primary transition-colors">All Brands</span>
                                <input type="radio" name="brand_filter" data-b="all" checked class="peer sr-only">
                                <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all flex-shrink-0">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                            </label>

                            @foreach($brands as $brand)
                                <label class="flex items-center justify-between px-3 rounded-xl cursor-pointer hover:bg-slate-50 group transition-all duration-200 dynamic-filter-row">
                                    <span class="text-sm font-medium text-slate-500 group-hover:text-primary transition-colors text-left break-words max-w-[85%]">{{ $brand->name }}</span>
                                    <input type="radio" name="brand_filter" data-b="{{ $brand->slug }}" class="peer sr-only">
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all flex-shrink-0">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold mb-3 text-[11px] uppercase tracking-widest text-slate-400/90 flex items-center gap-2">
                            <span>Sort by</span>
                            <span class="h-px bg-slate-100 flex-1"></span>
                        </h4>
                        <div class="relative group">
                            <select id="sortSel" class="w-full bg-slate-50/60 border border-slate-200/80 rounded-2xl pl-10 pr-4 py-3 text-sm font-semibold text-slate-700 focus:outline-none focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/5 appearance-none cursor-pointer transition-all duration-200">
                                <option value="rating">⭐ Top rated</option>
                                <option value="low">📉 Price: Low to High</option>
                                <option value="high">📈 Price: High to Low</option>
                                <option value="reviews">💬 Most reviewed</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                <i class="fa-solid fa-arrow-down-short-wide text-xs"></i>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-[10px]">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <style>
                .dynamic-filter-row:has(input:checked) {
                    background-color: rgb(var(--primary-rgb, 59, 130, 246) / 0.05) !important;
                }
                .dynamic-filter-row:has(input:checked) span {
                    color: var(--primary-color, rgb(59, 130, 246)) !important;
                }
                .scrollbar-thin::-webkit-scrollbar { width: 4px; }
                .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
                .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
            </style>
            <style>
                /* রেডিও বাটন এবং কাস্টম সার্কেল ইন্ডিকেটর হাইড করার লজিক */
                #catChips input[type="radio"],
                #brandChips input[type="radio"],
                #catChips .w-4.h-4.rounded-full.border, /* কাস্টম সার্কেল হাইড */
                #brandChips .w-4.h-4.rounded-full.border {
                    display: none !important;
                }

                /* সিলেক্টেড রো-এর ব্যাকগ্রাউন্ড এবং টেক্সট কালার পরিবর্তন */
                .dynamic-filter-row:has(input:checked) {
                    background-color: #9cc3ee !important; /* Premium Slate-100 (Light Gray) */
                    border-radius: 12px;
                }

                .dynamic-filter-row:has(input:checked) span {
                    color: #0f172a !important; /* Dark Slate-900 (টেক্সট স্পষ্ট দেখানোর জন্য) */
                    font-weight: 600 !important; /* সিলেক্টেড টেক্সট একটু বোল্ড হবে */
                }

                /* চাইল্ড ক্যাটাগরি সিলেক্টেড হলে তার স্টাইলিং */
                .child-wrapper .dynamic-filter-row:has(input:checked) {
                    background-color: #9cc3ee !important; /* চাইল্ডের জন্য আরও হালকা Slate-50 */
                }

                /* স্ক্রোলবার স্টাইলিং (আগের মতোই থাকবে) */
                .scrollbar-thin::-webkit-scrollbar { width: 4px; }
                .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
                .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
                .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            </style>
            <div class="lg:col-span-3">
                {{--<div class="flex items-center justify-between mb-6">
                    <p class="text-slate-500 m-0"><span id="resultCount">{{ count($products) }}</span> products found</p>
                </div>--}}

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
            setActiveRadio('category_filter', currentCat);
            setActiveRadio('brand_filter', currentBrand);

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

                // রিফ্রেশ ছাড়া URL আপডেট করা
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

            // ৩. ইভেন্ট হ্যান্ডলারসমূহ (নতুন রেডিও ডিজাইনের জন্য ফিক্সড)

            // লোড মোর বাটন ক্লিক
            $('#loadMoreBtn').on('click', function() {
                currentPage++;
                fetchProducts(true);
            });

            // ⚡ ফিক্সড: ক্যাটাগরি রেডিও চেঞ্জ ইভেন্ট
            $('#catChips').on('change', 'input[name="category_filter"]', function() {
                currentCat = $(this).data('c');
                fetchProducts(false);
            });

            // ⚡ ফিক্সড: ব্র্যান্ড রেডিও চেঞ্জ ইভেন্ট
            $('#brandChips').on('change', 'input[name="brand_filter"]', function() {
                currentBrand = $(this).data('b');
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

            // ⚡ ফিক্সড: রেডিও বাটন একটিভ করার নতুন হেল্পার ফাংশন
            function setActiveRadio(name, value) {
                $(`input[name="${name}"]`).each(function() {
                    const dataVal = name === 'category_filter' ? $(this).data('c') : $(this).data('b');
                    if (dataVal == value) {
                        $(this).prop('checked', true);
                    }
                });
            }

            // ব্রাউজার ব্যাক/ফরওয়ার্ড বাটন হ্যান্ডলার (পপস্টেট)
            $(window).on('popstate', function() {
                const updatedParams = new URLSearchParams(window.location.search);
                currentCat = updatedParams.get('category') || 'all';
                currentBrand = updatedParams.get('brand') || 'all';
                currentSort = updatedParams.get('sort') || 'rating';
                searchQuery = updatedParams.get('search') || '';

                $('#liveSearch').val(searchQuery);
                $('#sortSel').val(currentSort);

                // রেডিও বাটন স্টেট রিস্টোর
                setActiveRadio('category_filter', currentCat);
                setActiveRadio('brand_filter', currentBrand);

                fetchProducts(false);
            });
        });
    </script>
    <script>
        // ==========================================
        // ৪. আল্ট্রা-প্রিমিয়াম হাইব্রিড অ্যাকোর্ডিয়ন লজিক
        // (ডেস্কটপে হোভার, মোবাইলে ক্লিক এবং সিলেক্টেড আইটেম লক)
        // ==========================================

        // ডিভাইস ডিটেকশন হেল্পার (স্ক্রিন উইডথ ৯৯২ পিক্সেল বা তার কম হলে মোবাইল/ট্যাবলেট ধরা হবে)
        function isMobileDevice() {
            return window.innerWidth <= 992;
        }

        // --- ১. ডেস্কটপ হোভার লজিক ---
        $('#catChips').on('mouseenter', '.category-group', function() {
            if (isMobileDevice()) return; // মোবাইলে হোভার লজিক স্কিপ করবে

            const wrapper = $(this).find('.child-wrapper');
            const icon = $(this).find('.toggle-children-btn i');

            if (wrapper.length && wrapper.hasClass('hidden')) {
                wrapper.stop(true, true).slideDown(200).removeClass('hidden').css('display', 'flex');
                icon.addClass('rotate-90');
            }
        }).on('mouseleave', '.category-group', function() {
            if (isMobileDevice()) return; // মোবাইলে হোভার লজিক স্কিপ করবে

            const wrapper = $(this).find('.child-wrapper');
            const icon = $(this).find('.toggle-children-btn i');

            // চেক করা হচ্ছে: এই গ্রুপের ভেতর কোনো রেডিও ইনপুট 'checked' (সিলেক্টেড) আছে কি না
            const hasCheckedInput = $(this).find('input[name="category_filter"]').is(':checked');

            // যদি সিলেক্টেড না থাকে, তবেই মাউস সরালে ক্লোজ হবে
            if (wrapper.length && !hasCheckedInput) {
                wrapper.stop(true, true).slideUp(200, function() {
                    wrapper.addClass('hidden');
                });
                icon.removeClass('rotate-90');
            }
        });


        // --- ২. মোবাইল ক্লিক/টাচ লজিক ---
        // মোবাইলে ডানপাশের ছোট অ্যারো বাটনে ক্লিক করলে সাব-ক্যাটাগরি ওপেন বা ক্লোজ হবে
        $('#catChips').on('click', '.toggle-children-btn', function(e) {
            e.preventDefault();
            e.stopPropagation(); // প্যারেন্ট রেডিও সিলেক্ট হওয়া আটকাবে

            const group = $(this).closest('.category-group');
            const wrapper = group.find('.child-wrapper');
            const icon = $(this).find('i');

            wrapper.stop(true, true).slideToggle(200, function() {
                wrapper.toggleClass('hidden', !wrapper.is(':visible')).css('display', wrapper.is(':visible') ? 'flex' : 'none');
            });
            icon.toggleClass('rotate-90');
        });


        // --- ৩. গ্লোবাল স্টেট লজিক (সিলেক্টেড আইটেম সবসময় ওপেন রাখবে) ---
        function autoExpandSelectedCategory() {
            // প্রথমে সব ক্লোজ করে রিসেট করা
            $('.child-wrapper').addClass('hidden').css('display', 'none');
            $('.toggle-children-btn i').removeClass('rotate-90');

            // শুধু সিলেক্টেড আইটেমের প্যারেন্ট অটো ওপেন হবে
            $('input[name="category_filter"]:checked').each(function() {
                const group = $(this).closest('.category-group');
                const childWrapper = group.find('.child-wrapper');
                const icon = group.find('.toggle-children-btn i');

                if (childWrapper.length) {
                    childWrapper.removeClass('hidden').css('display', 'flex');
                    icon.addClass('rotate-90');
                }
            });
        }

        // প্রথমবার পেজ লোডে রান করার জন্য
        autoExpandSelectedCategory();
    </script>
@endpush
