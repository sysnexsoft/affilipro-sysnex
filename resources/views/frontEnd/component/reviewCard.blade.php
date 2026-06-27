<div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-soft hover:shadow-md transition-all duration-300 flex flex-col justify-between" data-aos="fade-up">
    <div>
        <div class="flex items-start justify-between gap-4">
            <div class="flex gap-3.5">
                @php
                    $words = explode(' ', $review->name);
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                @endphp
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ $initials }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-base m-0">{{ $review->name }}</h4>
                    @if($review->product)
                        <a href="{{ route('product.details', $review->product->slug) }}" class="no-underline">
                                                <span class=" bg-slate-100 text-slate-600 border border-slate-200/60 rounded-lg px-2.5 py-1 text-xs font-semibold max-w-[250px] block">
                                                    <i class="fa-solid fa-box text-[10px] me-1"></i>{{ $review->product->title }}
                                                </span>
                        </a>
                    @endif
                    <div class="flex items-center gap-2 mt-1">
                        <div class="text-amber-400 text-xs flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-slate-400 font-medium">{{ $review->created_at ? $review->created_at->diffForHumans() : 'Recently' }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <p class="text-slate-600 text-sm leading-relaxed m-0 italic">
                "{{ $review->review }}"
            </p>
        </div>
    </div>
    {{--<div class="mt-5 flex items-center gap-4 border-t border-slate-50 pt-3 text-xs text-slate-400 font-medium">
        <span>Was this review helpful?</span>
        <button class="flex items-center gap-1.5 hover:text-primary transition-colors focus:outline-none">
            <i class="fa-regular fa-thumbs-up"></i> Helpful
        </button>
    </div>--}}
</div>

