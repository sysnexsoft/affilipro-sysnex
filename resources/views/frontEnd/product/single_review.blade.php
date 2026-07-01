<div class="review-item pt-3 first:pt-0 pb-3 last:pb-0">
    <div class="flex justify-between items-center gap-2">
        <span class="font-bold text-slate-800 text-sm tracking-tight">{{ $rev->name }}</span>

        <span class="text-amber-400 text-[10px] md:text-xs flex gap-0.5">
            @for($j = 1; $j <= 5; $j++)
                @if($j <= $rev->rating)
                    <i class="fa-solid fa-star"></i>
                @else
                    <i class="fa-regular fa-star text-slate-200"></i>
                @endif
            @endfor
        </span>
    </div>

    <p class="text-slate-600 text-xs md:text-sm italic mt-1 leading-relaxed">"{{ $rev->review }}"</p>

    <span class="text-[10px] text-slate-400 block mt-1 font-medium">
        <i class="fa-regular fa-clock me-1 text-[9px]"></i>{{ $rev->created_at->diffForHumans() }}
    </span>
</div>
