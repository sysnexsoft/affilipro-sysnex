<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">

    <title>{{ $seo->meta_title ?? 'Home' }} — {{ config('app.name') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="title" content="{{ $seo->meta_title ?? '' }}">
    <meta name="description" content="{{ $seo->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $seo->meta_keywords ?? '' }}">
    <meta name="robots" content="{{ $seo->meta_robots ?? 'index, follow' }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="theme-color" content="#2563eb">
    <meta name="google" content="notranslate" />
    <link rel="canonical" href="{{ $seo->canonical_url ?? url()->current() }}">

    <!-- Open Graph / Facebook / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo->meta_title ?? '' }}">
    <meta property="og:description" content="{{ $seo->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($seo->meta_image) ? asset($seo->meta_image) : asset('default-og-image.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo->meta_title ?? '' }}">
    <meta name="twitter:description" content="{{ $seo->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($seo->meta_image) ? asset($seo->meta_image) : asset('default-og-image.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($web_setting->favicon_logo) }}">

    <!-- Preload Critical Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}" />

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#2563eb', secondary: '#7c3aed', accent: '#06b6d4', success: '#10b981' },
                    fontFamily: { display: ['Sora','sans-serif'], sans: ['Plus Jakarta Sans','sans-serif'] }
                }
            }
        };
    </script>

    <!-- DataLayer & Dynamic Scripts -->
    @if(!empty($seo->datalayer_json))
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({!! $seo->datalayer_json !!});
        </script>
@endif

@if(!empty($seo->schema_script))
    {!! $seo->schema_script !!}
@endif

<!-- Schema Markup: WebSite & Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ config('app.name') }}",
        "url": "{{ url('/') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{!! url('/product') !!}?category=all\u0026brand=all\u0026sort=rating\u0026search={query}\u0026page=1",
            "query-input": "required name=query"
        }
    }
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NY180Q5L3T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-NY180Q5L3T');
    </script>

    <style>
        /* Google Translate & UX Fixes */
        body { top: 0 !important; position: static !important; }
        html { background-color: transparent !important; }
        .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; }
    </style>
</head>
<body>
<div class="read-progress"></div>

<!-- ===================== HERO ===================== -->
@include('frontEnd.layout.header')

    @yield('body')

@include('frontEnd.layout.footer')



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('subscriberForm');
        const popup = document.getElementById('exitPopup');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            try {
                const response = await fetch("{{ route('subscribe.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert(data.message);
                    form.reset();
                    popup.style.display = 'none';
                } else {
                    // লারাভেলের ভ্যালিডেশন এররগুলো দেখানোর জন্য
                    alert(data.message || 'ভুল কিছু ঘটেছে। আবার চেষ্টা করুন।');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('সার্ভারে সমস্যা হয়েছে। দয়া করে পরে চেষ্টা করুন।');
            } finally {
                // বাটন আগের অবস্থায় ফিরিয়ে আনা
                submitButton.disabled = false;
                submitButton.textContent = 'Send me the deals';
            }
        });
    });
</script>
<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('/')}}Frontend/assets/js/data.js"></script>
{{--<script src="{{asset('/')}}Frontend/assets/js/components.js"></script>--}}
<script src="{{asset('/')}}Frontend/assets/js/home.js"></script>
<script src="{{asset('/')}}Frontend/assets/js/main.js"></script>

@stack('js')
@yield('js')
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,bn,es',
            // এটি গুগলকে নির্দেশ দেবে কোনো ডিফল্ট ব্যানার বা পপআপ না তৈরি করতে
            floatPosition: google.translate.TranslateElement.FloatPosition.TOP_LEFT
        }, 'google_translate_element');
    }
    document.addEventListener("DOMContentLoaded", function() {
        // ড্রপডাউন আইটেমে ক্লিক করার লজিক
        const langSelectors = document.querySelectorAll('.lang-selector');
        langSelectors.forEach(selector => {
            selector.addEventListener('click', function(e) {
                e.preventDefault();

                const langCode = this.getAttribute('data-lang');
                const langText = this.innerText;

                // গুগলের ভেতরের ডিফল্ট ড্রপডাউন সিলেক্টর খুঁজে বের করা
                const googleSelect = document.querySelector('.goog-te-combo');

                if (googleSelect) {
                    googleSelect.value = langCode;
                    // গুগলকে ট্রিগার করার জন্য চেঞ্জ ইভেন্ট ফায়ার করা
                    googleSelect.dispatchEvent(new Event('change'));

                    // মেইন লেবেল পরিবর্তন করা
                    document.getElementById('current-lang-label').innerText = langText;

                    // অ্যাক্টিভ ক্লাস চেঞ্জ করা
                    langSelectors.forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                } else {
                    console.error("Google Translate script not fully loaded yet.");
                }
            });
        });
    });
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
    $(document).ready(function () {
        // CSRF টোকেন গ্লোবাল সেটআপ
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // কমন SweetAlert2 টোস্ট ফাংশন
        function showToast(icon, message, timer = 2500) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: true
            });
        }

        // কাউন্টার এবং ক্লিয়ার বাটন রিয়েল-টাইম আপডেট করার ফাংশন
        function updateUIVisuals(count) {
            $('.compare-count-badge').text(count);

            if(count >= 2) {
                $('#btnClearCompare').removeClass('d-none');
            } else {
                $('#btnClearCompare').addClass('d-none');
            }
        }

        // ১. প্রোডাক্ট অ্যাড করার AJAX
        $(document).on('click', '.btn-add-to-compare', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            let rawUrl = "{{ route('compare.add', ':id') }}";
            let ajaxUrl = rawUrl.replace(':id', id);

            $.ajax({
                url: ajaxUrl,
                type: "POST",
                success: function (response) {
                    if (response.status === 'success') {
                        showToast('success', response.message);
                        updateUIVisuals(response.count);
                    } else {
                        showToast('warning', response.message, 3000);
                    }
                },
                error: function () {
                    showToast('error', 'Something went wrong. Please try again.', 3000);
                }
            });
        });

        // ২. প্রোডাক্ট রিমুভ করার AJAX (সরাসরি রিমুভ)
        $(document).on('click', '.btn-remove-compare', function (e) {
            e.preventDefault();
            let productId = $(this).data('id');

            let rawUrl = "{{ route('compare.remove', ':id') }}";
            let ajaxUrl = rawUrl.replace(':id', productId);

            $.ajax({
                url: ajaxUrl,
                type: "POST",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#compareTableContainer').html(response.html);
                        updateUIVisuals(response.count);
                        showToast('success', response.message); // রিমুভ হওয়ার পর টোস্ট
                    } else {
                        showToast('warning', response.message);
                    }
                },
                error: function () {
                    showToast('error', 'Something went wrong!');
                }
            });
        });

        // ৩. সম্পূর্ণ লিস্ট ক্লিয়ার করার AJAX (সরাসরি ক্লিয়ার)
        $('#btnClearCompare').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('compare.clear') }}",
                type: "POST",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#compareTableContainer').html(response.html);
                        updateUIVisuals(response.count);
                        showToast('success', response.message); // ক্লিয়ার হওয়ার পর টোস্ট
                    } else {
                        showToast('warning', response.message);
                    }
                },
                error: function () {
                    showToast('error', 'Something went wrong!');
                }
            });
        });
    });
</script>
</body>
</html>

