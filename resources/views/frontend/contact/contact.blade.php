@extends('landing.landing')

@section('title', 'Kontak')

@section('content')
    <section id="kontak" class="bg-white">
        {{-- HERO --}}
        <div class="border-b border-slate-200 bg-slate-100">
            <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
                <h1 class="text-3xl font-extrabold text-[#07587a] md:text-5xl">
                    {{ $contact['title'] ?? 'Connect with Our Maritime Experts' }}
                </h1>

                <p class="mx-auto mt-6 max-w-3xl text-base leading-relaxed text-slate-600 md:text-lg">
                    {{ $contact['subtitle'] ?? 'Have questions about our shipping services or want to discuss a partnership opportunity? Our team is ready to assist you.' }}
                </p>
            </div>
        </div>

        {{-- CONTACT AREA --}}
        <div class="relative overflow-hidden bg-[#07587a]">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-16">

                {{-- LEFT INFO --}}
                <div class="text-white lg:col-span-7">
                    <h2 class="text-2xl font-extrabold">
                        {{ $contact['company_name'] ?? 'PT. Gurita Lintas Samudera' }}
                    </h2>

                    <div class="mt-8 grid gap-8 sm:grid-cols-2">
                        <div>
                            <p class="text-sm font-semibold text-white/70">Phone</p>
                            <p class="mt-3 text-base font-bold">
                                {{ $contact['phone'] ?? '+6221 568 6369' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-white/70">Address</p>
                            <p class="mt-3 max-w-xs text-base font-bold leading-relaxed">
                                {{ $contact['address'] ?? 'Jl. Tomang Raya No. 47 E, Jakarta 11440, Indonesia' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-white/70">Email</p>
                            <a href="mailto:{{ $contact['email'] ?? 'ops@glsship.com' }}"
                                class="mt-3 inline-block text-base font-bold hover:underline">
                                {{ $contact['email'] ?? 'ops@glsship.com' }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <div class="lg:col-span-5">
                    <div class="rounded-[28px] bg-white px-8 py-9 shadow-2xl md:px-10">
                        <h3 class="text-3xl font-extrabold text-[#07587a]">
                            {{ $contact['form_title'] ?? 'Get In Touch' }}
                        </h3>

                        <form id="contactForm" class="mt-8 space-y-8">
                            <div class="grid gap-7 md:grid-cols-2">
                                <input type="text" name="name"
                                    placeholder="{{ $contact['name_placeholder'] ?? 'Your Name' }}"
                                    class="w-full border-0 border-b border-slate-200 px-0 py-3 text-sm text-slate-700 placeholder:text-slate-500 focus:border-[#07587a] focus:ring-0">

                                <input type="email" name="email"
                                    placeholder="{{ $contact['email_placeholder'] ?? 'Your Email' }}"
                                    class="w-full border-0 border-b border-slate-200 px-0 py-3 text-sm text-slate-700 placeholder:text-slate-500 focus:border-[#07587a] focus:ring-0">

                                <input type="text" name="phone"
                                    placeholder="{{ $contact['phone_placeholder'] ?? 'Your Phone' }}"
                                    class="w-full border-0 border-b border-slate-200 px-0 py-3 text-sm text-slate-700 placeholder:text-slate-500 focus:border-[#07587a] focus:ring-0">

                                <input type="text" name="subject"
                                    placeholder="{{ $contact['subject_placeholder'] ?? 'Your Subject' }}"
                                    class="w-full border-0 border-b border-slate-200 px-0 py-3 text-sm text-slate-700 placeholder:text-slate-500 focus:border-[#07587a] focus:ring-0">
                            </div>

                            <textarea rows="4" name="message" placeholder="{{ $contact['message_placeholder'] ?? 'Write Your Message' }}"
                                class="w-full resize-none border-0 border-b border-slate-200 px-0 py-3 text-sm text-slate-700 placeholder:text-slate-500 focus:border-[#07587a] focus:ring-0"></textarea>

                            <x-button.button-menu type="submit" variant="primary" class="w-full">
                                {{ $contact['button_text'] ?? 'Submit Message' }}
                            </x-button.button-menu>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MAP STRIP --}}
            <div class="h-[120px] w-full overflow-hidden border-t border-white/10 bg-slate-300">
                <iframe src="{{ $contact['map_embed'] ?? 'https://www.google.com/maps?q=Jakarta&output=embed' }}"
                    class="h-[220px] w-full -translate-y-12 border-0" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
@endsection
