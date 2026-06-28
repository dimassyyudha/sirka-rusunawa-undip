@extends('layouts.app')

@section('title', 'Beri Testimoni')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">

            {{-- Header --}}
            <div>

                <h1 class="text-3xl font-black text-slate-900">
                    Berikan Testimoni
                </h1>

                <p class="mt-2 text-slate-500">
                    Pendapat Anda membantu meningkatkan kualitas layanan Rusunawa dan menjadi referensi bagi mahasiswa lain.
                </p>

            </div>

            {{-- Info Kamar --}}
            <div class="mt-8 rounded-2xl bg-slate-50 border border-slate-200 p-6">

                <p class="text-sm text-slate-500">
                    Kamar
                </p>

                <h2 class="mt-1 text-3xl font-black text-slate-900">
                    {{ $occupant->room->kode_kamar }}
                </h2>

                <p class="mt-2 text-slate-500">
                    Gedung {{ $occupant->room->floor->building->code }}
                    •
                    Lantai {{ $occupant->room->floor->floor_number }}
                </p>

            </div>

            <form action="{{ route('mahasiswa.testimoni.store') }}" method="POST" class="mt-8">

                @csrf

                <input type="hidden" name="room_id" value="{{ $occupant->room_id }}">

                <input type="hidden" name="rating" id="rating" value="0">

                {{-- Rating --}}
                <div>

                    <label class="block text-xl font-black text-slate-900">

                        Berikan Penilaian

                    </label>

                    <div id="rating-stars" class="mt-5 flex items-center gap-3">

                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn">

                                <svg class="star w-14 h-14 text-slate-300 transition duration-200 hover:scale-110"
                                    fill="currentColor" viewBox="0 0 24 24">

                                    <path
                                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />

                                </svg>

                            </button>
                        @endfor

                    </div>

                    <p id="rating-text" class="mt-4 text-lg font-semibold text-slate-600">

                        Pilih Penilaian

                    </p>

                </div>

                {{-- Komentar --}}
                <div class="mt-10">

                    <label class="block text-xl font-black text-slate-900 mb-4">

                        Ceritakan Pengalaman Anda

                    </label>

                    <textarea id="comment" name="comment" rows="7" maxlength="500"
                        placeholder="Bagikan pengalaman Anda mengenai fasilitas, kebersihan, keamanan, kenyamanan, dan lingkungan kamar."
                        class="w-full rounded-2xl border border-slate-300 p-5 focus:border-orange-500 focus:ring-orange-500"></textarea>

                    <div class="mt-2 text-right">

                        <span id="char-count" class="text-sm text-slate-400">

                            0 / 500 karakter

                        </span>

                    </div>

                </div>

                {{-- Info --}}
                <div class="mt-8 rounded-2xl border border-amber-200 bg-amber-50 p-5">

                    <p class="text-sm text-amber-700">

                        Testimoni yang Anda kirim akan ditampilkan pada halaman detail kamar dan dapat dibaca oleh calon
                        penghuni lainnya.

                    </p>

                </div>

                {{-- Button --}}
                <button type="submit"
                    class="mt-8 w-full rounded-2xl bg-orange-500 py-4 text-lg font-bold text-white transition hover:bg-orange-600">

                    Kirim Testimoni

                </button>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');

            const labels = {
                1: 'Sangat Buruk',
                2: 'Kurang Memuaskan',
                3: 'Cukup Baik',
                4: 'Baik',
                5: 'Sangat Baik'
            };

            stars.forEach((button, index) => {

                button.addEventListener('mouseenter', () => {
                    highlight(index + 1);
                });

                button.addEventListener('click', () => {

                    const rating = index + 1;

                    ratingInput.value = rating;

                    ratingText.textContent = labels[rating];

                    highlight(rating);

                });

            });

            document
                .getElementById('rating-stars')
                .addEventListener('mouseleave', () => {

                    highlight(ratingInput.value);

                });

            function highlight(rating) {

                stars.forEach((btn, i) => {

                    const star = btn.querySelector('.star');

                    if (i < rating) {

                        star.classList.remove('text-slate-300');
                        star.classList.add('text-yellow-400');

                    } else {

                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-slate-300');

                    }

                });

            }

            const comment = document.getElementById('comment');
            const counter = document.getElementById('char-count');

            comment.addEventListener('input', () => {

                counter.textContent =
                    comment.value.length + ' / 500 karakter';

            });

        });
    </script>

@endsection
