@extends('frontEnd.layout.app')
@section('title','')
@section('body')
    <section class="bg-hero pt-12 pb-12">
        <div class="container-x">
            <nav class="crumb text-sm mb-4"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right text-slate-300 mx-1"></i> <span class="text-slate-700 font-semibold">Contact</span></nav>
            <h1 class="font-display text-4xl md:text-5xl font-extrabold" data-aos="fade-up">Get in touch</h1>
            <p class="text-slate-600 mt-3 max-w-xl" data-aos="fade-up">Questions, suggestions or partnership ideas? We'd love to hear from you.</p>
        </div>
    </section>
    <section class="py-12">
        <div class="container-x grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-4" data-aos="fade-right">
                <div class="card-premium p-6 flex gap-4"><span class="w-12 h-12 rounded-xl bg-blue-50 text-primary grid place-items-center text-xl"><i class="fa-solid fa-envelope"></i></span><div><div class="font-bold">Email</div><p class="text-slate-500 m-0">hello@affilipro.com</p></div></div>
                <div class="card-premium p-6 flex gap-4"><span class="w-12 h-12 rounded-xl bg-blue-50 text-primary grid place-items-center text-xl"><i class="fa-solid fa-headset"></i></span><div><div class="font-bold">Support</div><p class="text-slate-500 m-0">Mon–Fri, 9am–6pm</p></div></div>
                <div class="card-premium p-6 flex gap-4"><span class="w-12 h-12 rounded-xl bg-blue-50 text-primary grid place-items-center text-xl"><i class="fa-solid fa-location-dot"></i></span><div><div class="font-bold">Office</div><p class="text-slate-500 m-0">San Francisco, CA</p></div></div>
            </div>
            <div class="lg:col-span-2">
                <form data-form class="card-premium p-8 space-y-4" data-aos="fade-left">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div><label class="form-label fw-semibold">Name</label><input required class="form-control rounded-xl py-2" placeholder="Your name" /></div>
                        <div><label class="form-label fw-semibold">Email</label><input required type="email" class="form-control rounded-xl py-2" placeholder="you@email.com" /></div>
                    </div>
                    <div><label class="form-label fw-semibold">Subject</label><input class="form-control rounded-xl py-2" placeholder="How can we help?" /></div>
                    <div><label class="form-label fw-semibold">Message</label><textarea required rows="5" class="form-control rounded-xl" placeholder="Write your message..."></textarea></div>
                    <button class="btn-grad">Send Message <i class="fa-solid fa-paper-plane ms-1"></i></button>
                    <p data-form-note class="hidden text-success mt-2"><i class="fa-solid fa-check"></i> Thanks! We'll get back to you within 24 hours.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
