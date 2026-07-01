@extends('layouts.app')

@section('title', 'Reservations - The Lighthouse Cafe')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        /* ---------- Ambiance gallery swiper ---------- */
        .gallery-swiper .swiper-slide {
            height: auto;
            opacity: 0.55;
            transform: scale(0.9);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .gallery-swiper .swiper-slide-active,
        .gallery-swiper .swiper-slide-next,
        .gallery-swiper .swiper-slide-prev {
            opacity: 1;
            transform: scale(1);
        }
        .gallery-swiper .swiper-pagination-bullet {
            background: #cbd5e1; /* slate-300 */
            opacity: 1;
        }
        .gallery-swiper .swiper-pagination-bullet-active {
            background: #f59e0b; /* amber-500 */
        }
        .gallery-swiper .swiper-button-next,
        .gallery-swiper .swiper-button-prev {
            color: #f59e0b;
            background: rgba(15, 23, 42, 0.55);
            width: 42px;
            height: 42px;
            border-radius: 9999px;
            backdrop-filter: blur(4px);
        }
        .gallery-swiper .swiper-button-next::after,
        .gallery-swiper .swiper-button-prev::after {
            font-size: 16px;
        }

        /* ---------- Form styling ---------- */
        .field-icon-input {
            padding-left: 2.75rem;
        }
        .field-wrapper {
            position: relative;
        }
        .field-wrapper svg.field-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.15rem;
            height: 1.15rem;
            color: #94a3b8; /* slate-400 */
            pointer-events: none;
            transition: color 0.2s ease;
        }
        .field-wrapper input:focus ~ svg.field-icon,
        .field-wrapper select:focus ~ svg.field-icon {
            color: #f59e0b; /* amber-500 */
        }
        .themed-input,
        .themed-select,
        .themed-textarea {
            width: 100%;
            border: 1.5px solid #e2e8f0; /* slate-200 */
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .themed-input:focus,
        .themed-select:focus,
        .themed-textarea:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
        }
        .themed-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.9rem center;
            background-size: 1.1rem;
            padding-right: 2.75rem;
        }

        /* Time slot quick-pick chips */
        .time-chip {
            transition: transform 0.15s ease, background-color 0.15s ease, color 0.15s ease;
        }
        .time-chip:hover { transform: translateY(-2px); }
        .time-chip.is-selected {
            background: #0f172a; /* slate-900 */
            color: #fbbf24; /* amber-400 */
            border-color: #0f172a;
        }

        .reservation-card {
            border-top: 4px solid #f59e0b;
        }

        .info-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-6px);
        }

        @media (prefers-reduced-motion: reduce) {
            .gallery-swiper .swiper-slide,
            .time-chip,
            .info-card {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Hero -->
    <div class="relative h-80 md:h-96 bg-cover bg-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1530554764233-e79e16c91d08?w=1920&h=600&fit=crop');">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/50"></div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
                <p data-aos="fade-up" data-aos-duration="700"
                    class="text-amber-400 font-semibold tracking-widest uppercase text-sm mb-3">
                    The Lighthouse Cafe
                </p>
                <h1 data-aos="fade-up" data-aos-delay="100" data-aos-duration="700"
                    class="text-5xl md:text-6xl font-serif font-bold mb-4">
                    Reserve Your Table
                </h1>
                <p data-aos="fade-up" data-aos-delay="200" data-aos-duration="700" class="text-xl text-slate-200">
                    An unforgettable dining experience awaits
                </p>
            </div>
        </div>
    </div>

    <!-- Ambiance Gallery -->
    <section class="py-16 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-10" data-aos="fade-up">
            <p class="text-amber-400 font-semibold tracking-widest uppercase text-sm mb-2">Set The Mood</p>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white">A Glimpse Inside</h2>
        </div>

        <div class="swiper gallery-swiper max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="zoom-in" data-aos-delay="100">
            <div class="swiper-wrapper pb-2">
                @foreach ([
                    ['url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900&h=650&fit=crop', 'caption' => 'Warm, intimate seating'],
                    ['url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&h=650&fit=crop', 'caption' => 'Crafted cocktails & coffee'],
                    ['url' => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=900&h=650&fit=crop', 'caption' => 'Fresh, seasonal plating'],
                    ['url' => 'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=900&h=650&fit=crop', 'caption' => 'Golden-hour ambiance'],
                ] as $slide)
                    <div class="swiper-slide">
                        <div class="rounded-xl overflow-hidden shadow-2xl relative h-72 sm:h-80">
                            <img src="{{ $slide['url'] }}" alt="{{ $slide['caption'] }}" class="w-full h-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/85 to-transparent p-4">
                                <p class="text-white font-serif font-semibold">{{ $slide['caption'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-6"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Reservation Form -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reservation-card bg-white rounded-2xl shadow-2xl p-8 md:p-12" data-aos="fade-up">
                <div class="text-center mb-12">
                    <p class="text-amber-500 font-semibold tracking-widest uppercase text-sm mb-2">Book Your Experience</p>
                    <h2 class="text-4xl font-serif font-bold text-slate-900 mb-4">Reserve a Table</h2>
                    <p class="text-slate-600">Fill out the form below and we'll confirm your reservation within 24 hours</p>
                </div>

                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div data-aos="fade-up" data-aos-delay="50">
                            <label class="block text-slate-700 font-semibold mb-2">Full Name *</label>
                            <div class="field-wrapper">
                                <input type="text" name="name" required
                                    class="themed-input field-icon-input"
                                    placeholder="Sujal Lamichhane">
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg> --}}
                            </div>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div data-aos="fade-up" data-aos-delay="100">
                            <label class="block text-slate-700 font-semibold mb-2">Email Address *</label>
                            <div class="field-wrapper">
                                <input type="email" name="email" required
                                    class="themed-input field-icon-input"
                                    placeholder="sujal@example.com">
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg> --}}
                            </div>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div data-aos="fade-up" data-aos-delay="50">
                            <label class="block text-slate-700 font-semibold mb-2">Phone Number *</label>
                            <div class="field-wrapper">
                                <input type="tel" name="phone" required
                                    class="themed-input field-icon-input"
                                    placeholder="(555) 123-4567">
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg> --}}
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div data-aos="fade-up" data-aos-delay="100">
                            <label class="block text-slate-700 font-semibold mb-2">Number of Guests *</label>
                            <div class="field-wrapper">
                                <select name="guests" required class="themed-select field-icon-input">
                                    <option value="">Select guests</option>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                    @endfor
                                </select>
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                                </svg> --}}
                            </div>
                            @error('guests')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div data-aos="fade-up" data-aos-delay="50">
                            <label class="block text-slate-700 font-semibold mb-2">Reservation Date *</label>
                            <div class="field-wrapper">
                                <input type="date" name="date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="themed-input field-icon-input">
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg> --}}
                            </div>
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div data-aos="fade-up" data-aos-delay="100" x-data="{ time: '' }">
                            <label class="block text-slate-700 font-semibold mb-2">Preferred Time *</label>
                            <div class="field-wrapper">
                                <select name="time" required x-model="time" class="themed-select field-icon-input">
                                    <option value="">Select time</option>
                                    <option value="06:00">6:00 AM</option>
                                    <option value="06:30">6:30 AM</option>
                                    <option value="07:00">7:00 AM</option>
                                    <option value="07:30">7:30 AM</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="08:30">8:30 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="09:30">9:30 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="19:30">12:30 PM</option>
                                    <option value="20:00">1:00 PM</option>
                                    <option value="20:30">1:30 PM</option>
                                    <option value="21:00">2:00 PM</option>
                                </select>
                                {{-- <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg> --}}
                            </div>
                            <!-- Quick-pick chips just set the same underlying <select> above -->
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach (['06:00' => '6:00 AM', '08:00' => '8:00 AM', '10:00' => '10:00 AM', '12:00' => '12:00 PM'] as $val => $label)
                                    <button type="button" @click="time = '{{ $val }}'"
                                        :class="time === '{{ $val }}' ? 'is-selected' : 'bg-slate-100 text-slate-600 border-slate-200'"
                                        class="time-chip text-xs font-semibold px-3 py-1.5 rounded-full border">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div data-aos="fade-up">
                        <label class="block text-slate-700 font-semibold mb-2">Special Requests (Optional)</label>
                        <textarea name="special_requests" rows="4" class="themed-textarea"
                            placeholder="Dietary restrictions, special occasions, seating preferences, etc."></textarea>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4" data-aos="fade-up">
                        <p class="text-sm text-slate-700">
                            <strong>Please note:</strong> Reservations are subject to availability. We will confirm your
                            booking via email within 24 hours. For same-day reservations, please call us at (781) 391-0009.
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 text-lg py-4 rounded-lg font-bold transition transform hover:scale-[1.01] shadow-lg">
                        Submit Reservation Request
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Info Cards -->
    <section class="py-16 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <p class="text-amber-400 font-semibold tracking-widest uppercase text-sm mb-2">Find Us</p>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white">Everything You Need to Know</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="info-card text-center p-8 bg-slate-800 rounded-xl shadow-lg border border-slate-700"
                    data-aos="fade-up" data-aos-delay="0">
                    <div class="w-16 h-16 bg-amber-500/15 border border-amber-500/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-white mb-2">Operating Hours</h3>
                    <p class="text-slate-400">Mon-Thu: 6am - 2pm<br>Fri-Sat: 6am - 2pm<br>Sun: 6am - 2pm</p>
                </div>

                <div class="info-card text-center p-8 bg-slate-800 rounded-xl shadow-lg border border-slate-700"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-amber-500/15 border border-amber-500/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-white mb-2">Location</h3>
                    <p class="text-slate-400">20 High ST<br>Medford, MA 02155</p>
                </div>

                <div class="info-card text-center p-8 bg-slate-800 rounded-xl shadow-lg border border-slate-700"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-amber-500/15 border border-amber-500/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-white mb-2">Contact</h3>
                    <p class="text-slate-400">(781) 391-0009<br>lighthousecafe26@gmail.com</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 700,
                easing: 'ease-out-cubic',
                once: true,
                offset: 60,
            });

            const galleryEl = document.querySelector('.gallery-swiper');
            if (galleryEl) {
                new Swiper('.gallery-swiper', {
                    loop: true,
                    centeredSlides: true,
                    slidesPerView: 1.15,
                    spaceBetween: 20,
                    breakpoints: {
                        640: { slidesPerView: 1.6 },
                        1024: { slidesPerView: 2.4 },
                    },
                    autoplay: {
                        delay: 4200,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.gallery-swiper .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.gallery-swiper .swiper-button-next',
                        prevEl: '.gallery-swiper .swiper-button-prev',
                    },
                });
            }
        });
    </script>
@endpush
