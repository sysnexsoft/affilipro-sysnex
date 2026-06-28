@extends('frontEnd.layout.app')
@section('title', 'Compare Products')
@section('body')
    <!-- প্রিমিয়াম হিরো সেকশন -->
    <section class="bg-gradient-to-b from-slate-50 to-slate-100/50 pt-16 pb-16 border-b border-slate-200/60">
        <div class="container-x">
            <nav class="crumb text-sm mb-5" data-aos="fade-up">
                <a href="{{route('home')}}" class="text-slate-400 hover:text-primary transition no-underline">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 mx-2 text-xs"></i>
                <span class="text-slate-600 font-semibold">Compare</span>
            </nav>
            <span class="eyebrow bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase" data-aos="fade-up">Make the smart choice</span>
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-4 mt-4" data-aos="fade-up">
                <div>
                    <h1 class="font-display text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Side-by-Side Comparison</h1>
                    <p class="text-slate-500 mt-2 text-base max-w-xl">Compare specifications, pricing, pros and cons effortlessly to choose the best option.</p>
                </div>
                {{-- Clear All বাটন --}}
                <button type="button" id="btnClearCompare" class="btn px-4 py-2.5 rounded-xl font-medium text-sm transition d-flex align-items-center gap-2 {{ count(session()->get('compare_products', [])) >= 2 ? '' : 'd-none' }}" style="border: 1px solid #fee2e2; color: #ef4444; background-color: #fef2f2; cursor:pointer;">
                    <i class="fa-solid fa-trash-can text-xs"></i> Clear Comparison List
                </button>
            </div>
        </div>
    </section>

    <!-- টেবিল সেকশন -->
    <section class="py-16 bg-white">
        <div class="container-x">
            {{-- টেবিল কন্টেইনার - AJAX এর মাধ্যমে এটার ভেতরের পুরো পার্ট চেঞ্জ হবে --}}
            <div class="overflow-x-auto card-premium shadow-xl rounded-2xl border border-slate-100" id="compareTableContainer" data-aos="fade-up">
                @include('frontEnd.compare.compare_table')
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // CSRF টোকেন সেটআপ
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // কাউন্টার এবং ক্লিয়ার বাটন রিয়েল-টাইম আপডেট করার ফাংশন
            function updateUIVisuals(count) {
                // ১. হেডারের কাউন্টার ব্যাজ লাইভ আপডেট করবে
                $('.compare-count-badge').text(count);

                // ২. টোটাল আইটেম ২ এর কম হলে ক্লিয়ার বাটনটি হাইড করে দেবে
                if(count >= 2) {
                    $('#btnClearCompare').removeClass('d-none');
                } else {
                    $('#btnClearCompare').addClass('d-none');
                }
            }

            // ১. প্রোডাক্ট রিমুভ করার AJAX (Route Name সহ)
            $(document).on('click', '.btn-remove-compare', function (e) {
                e.preventDefault();
                let productId = $(this).data('id');

                // লারাভেল রাউট নেম প্লেসহোল্ডার ট্রিকস
                let rawUrl = "{{ route('compare.remove', ':id') }}";
                let ajaxUrl = rawUrl.replace(':id', productId);

                if(confirm('Are you sure you want to remove this product?')) {
                    $.ajax({
                        url: ajaxUrl,
                        type: "POST",
                        success: function (response) {
                            if (response.status === 'success') {
                                // টেবিল ব্লকের HTML রিয়েল-টাইম রিপ্লেস
                                $('#compareTableContainer').html(response.html);
                                // হেডার কাউন্টার লাইভ আপডেট
                                updateUIVisuals(response.count);
                            }
                        },
                        error: function () {
                            alert('Something went wrong!');
                        }
                    });
                }
            });

            // ২. সম্পূর্ণ লিস্ট ক্লিয়ার করার AJAX (Route Name সহ)
            $('#btnClearCompare').on('click', function (e) {
                e.preventDefault();
                if(confirm('Clear all products from comparison list?')) {
                    $.ajax({
                        url: "{{ route('compare.clear') }}",
                        type: "POST",
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#compareTableContainer').html(response.html);
                                updateUIVisuals(response.count);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
