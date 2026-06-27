@extends('frontEnd.layout.app')
@section('title', 'Customer Reviews')
@section('body')
    <section class="bg-hero pt-8 pb-4">
        <div class="container-x">
            <nav class="crumb text-sm mb-4" data-aos="fade-up">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i>
                <span class="text-slate-700 font-semibold">Reviews</span>
            </nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">Customer Feedbacks</h1>
            <p class="text-slate-600 mt-1 max-w-xl" data-aos="fade-up">See what our verified buyers are saying about their independently tested products.</p>
        </div>
    </section>

    <section class="py-12">
        <div class="container-x">
            <div class="grid md:grid-cols-3 gap-6" id="allReviewsContainer">
                @forelse($reviews as $review)
                    @include('frontEnd.component.reviewCard')
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        <i class="fa-regular fa-comment-dots text-4xl mb-3 text-slate-300 d-block"></i>
                        <p class="m-0 font-medium text-sm">No reviews found!</p>
                    </div>
                @endforelse
            </div>

            @if($reviews->hasMorePages())
                <div class="text-center mt-12" id="loadMoreContainer">
                    <button id="loadMoreReviewsBtn" class="px-6 py-2.5 rounded-xl font-medium shadow-md transition-all inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white border-0 hover:opacity-90">
                        <span>Load More Reviews</span>
                        <i class="fa-solid fa-spinner fa-spin d-none" id="reviewSpinner"></i>
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let currentPage = 1;

            $('#loadMoreReviewsBtn').on('click', function() {
                currentPage++;

                let btn = $(this);
                let spinner = $('#reviewSpinner');

                btn.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: `{{ route('review') }}?page=${currentPage}`,
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        // ব্যাকএন্ড থেকে রেণ্ডার হয়ে আসা কম্পোনেন্টের HTML যুক্ত হবে
                        $('#allReviewsContainer').append(data.html);

                        btn.prop('disabled', false);
                        spinner.addClass('d-none');

                        // যদি আর কোনো ডাটা না থাকে তবে বাটন হাইড হবে
                        if (!data.has_more) {
                            $('#loadMoreContainer').addClass('d-none');
                        }

                        // AOS অ্যানিমেশন রিফ্রেশ করা
                        if (window.AOS) {
                            window.AOS.refresh();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching reviews:', error);
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush
