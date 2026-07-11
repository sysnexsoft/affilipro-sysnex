<!-- কার্ডের মেইন ডিজাইন এবং কাস্টম অ্যানিমেশন ক্লাসেস -->
<div class="card premium-glow-card shadow-sm referred-product-box animate__animated animate__fadeIn group position-relative" style="max-width: 100%; overflow: hidden; border: 1px solid rgba(0,0,0,0.08); border-radius: 16px;">

    <!-- p-3 থেকে মোবাইলের জন্য প্যাডিং সেট করা এবং md:p-3.5 ডেক্সটপের জন্য করা হয়েছে -->
    <div class="row g-3 align-items-center p-3 p-md-3.5 bg-white position-relative" style="z-index: 2; border-radius: 15px;">

        <!-- ১. ইমেজ সেকশন (মোবাইলে ১২ কলাম পুরো নিবে, ডেক্সটপে ৩ কলাম) -->
        <div class="col-12 col-md-3 text-center position-relative">
            <a href="{{ route('product.details', $product->slug) }}"
               class="d-block overflow-hidden rounded-4 bg-slate-50 border border-slate-100 mx-auto"
               style="aspect-ratio: 4/3; width: 100%; max-width: 240px;"> <!-- মোবাইলের জন্য max-width লক করা হয়েছে যাতে ইমেজ বেশি বড় না হয় -->

                <img src="{{ asset($product->featured_image ?? 'frontEnd/assets/default.png') }}"
                     class="w-full h-full transition-transform duration-500 group-hover:scale-105"
                     alt="{{ $product->title }}"
                     style="object-fit: cover; object-position: center; width: 100%; height: 100%;">

            </a>
        </div>

        <!-- ২. মিডল কন্টেন্ট (মোবাইলে লেখাগুলো সেন্টারে বা সুন্দর এলাইনমেন্টে থাকবে) -->
        <div class="col-12 col-md-6 px-1 px-md-4 text-center text-md-start">
            <div class="card-body p-0">

                <!-- ছোট প্রিমিয়াম ব্যাজ -->
                <span class="badge bg-primary bg-opacity-10 text-primary text-xs uppercase font-bold tracking-wider px-2.5 py-1 rounded-full mb-2 d-inline-block">
                    Featured Choice
                </span>

                <h4 class="card-title fw-extrabold mb-2" style="font-size: 1.15rem;">
                    <a href="{{ route('product.details', $product->slug) }}" class="text-slate-900 no-underline hover:text-primary transition-colors line-clamp-2 line-clamp-md-1">
                        {{ $product->title }}
                    </a>
                </h4>

                <p class="card-text text-slate-500 small mb-3 line-clamp-2">
                    {{ \Illuminate\Support\Str::limit(strip_tags($product->short_description), 140) }}
                </p>

                <div class="flex flex-col items-end sm:flex-row sm:items-center sm:gap-2">
                    @if($product->sale_price && $product->regular_price)
                        <span class="text-lg font-black text-emerald-600 md:text-1xl">
                        {{ format_price($product->sale_price) }}
                    </span>
                        <span class="text-sm font-medium text-slate-400 line-through">
                        {{ format_price($product->regular_price) }}
                    </span>
                    @else
                        <span class="text-lg font-black text-slate-900 md:text-1xl">
                        {{ format_price($product->regular_price ?? $product->sale_price) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- ৩. অ্যাকশন বাটন সেকশন (মোবাইলে বাটনগুলো পাশাপাশি বা সুন্দর গ্রিডে থাকবে) -->
        <div class="col-12 col-md-3 text-center mt-2 mt-md-0">
            <div class="row g-2 flex-row flex-md-column">
                <!-- বাই বাটন (মোবাইলে পাশাপাশি থাকলে অর্ধেক নিবে, ডেক্সটপে পুরো ১ লাইন) -->
                <div class="col-7 col-md-12">
                    <a href="{{ $product->affiliate_url }}"
                       target="_blank"
                       rel="nofollow noopener"
                       class="btn btn-warning fw-bold w-100 blink-button d-flex align-items-center justify-content-center gap-2 text-white h-100 py-2.5 py-md-3 shadow-sm"
                       style="background: linear-gradient(135deg, #ff9f43, #ff5252); border: none; border-radius: 12px; font-size: 0.85rem; md:font-size: 0.95rem;">
                        <i class="fa-solid fa-cart-shopping animate-bounce"></i> <span class="d-none d-sm-inline">Buy From</span> {{ $product->affiliate_network ?? 'Store' }}
                    </a>
                </div>

                <!-- কম্পেয়ার বাটন -->
                <div class="col-5 col-md-12">
                    <button type="button"
                            data-id="{{ $product->id }}"
                            class="btn-add-to-compare btn btn-light text-slate-700 w-100 d-flex align-items-center justify-content-center gap-1.5 h-100 py-2.5 py-md-2"
                            style="border: 1px solid #e2e8f0; border-radius: 10px; font-weight: 500; font-size: 0.85rem;">
                        <i class="fa-solid fa-arrows-rotate text-slate-400"></i> Compare
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 🎨 সিএসএস স্টাইল (আগের মতোই থাকবে, কোনো পরিবর্তন লাগবে না) -->
<style>
    .premium-glow-card::before {
        content: '';
        position: absolute;
        top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(45deg, #ff5252, #ff9f43, #3b82f6, #ff5252);
        background-size: 400%;
        z-index: 1;
        filter: blur(2px);
        animation: glowingBorder 12s linear infinite;
        opacity: 0.4;
        transition: opacity 0.3s ease;
        border-radius: 18px;
    }
    .premium-glow-card:hover::before {
        opacity: 0.9;
        filter: blur(4px);
    }
    @keyframes glowingBorder {
        0% { background-position: 0 0; }
        50% { background-position: 400% 0; }
        100% { background-position: 0 0; }
    }
    .blink-button {
        position: relative;
        overflow: hidden;
        animation: buttonPulse 2s infinite;
        box-shadow: 0 0 0 0 rgba(255, 82, 82, 0.7);
    }
    @keyframes buttonPulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0.5); }
        70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(255, 82, 82, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0); }
    }
    .blink-button::after {
        content: '';
        position: absolute;
        top: -50%; left: -60%;
        width: 30%; height: 200%;
        background: rgba(255, 255, 255, 0.25);
        transform: rotate(25deg);
        animation: lightShine 3s infinite linear;
    }
    @keyframes lightShine {
        0% { left: -60%; }
        30% { left: 140%; }
        100% { left: 140%; }
    }
</style>
