@props(['room'])

@php
    $occupied = $room->occupants()->where('status', 'active')->count();

    $capacity = (int) ($room->capacity ?? 2);

    // $slots = max(0, $capacity - $occupied);

    $occupied = (int) ($room->occupied ?? 0);

    $slots = (int) ($room->slots ?? 0);

    $isAvailable = ($room->status ?? 'tersedia') === 'tersedia' && $slots > 0;

    $harga = (int) ($room->harga ?? 0);

    $gedungLabel = $room->floor?->building?->name ?? ($room->gedung ?? '-');

    $lantai = $room->lantai ?? ($room->floor?->floor_number ?? '-');
    $gallery = [];

    $fasilitasList = [];

    if ($room->fasilitas) {
        $fasilitasList = preg_split('/\r\n|\r|\n|,/', $room->fasilitas);

        $fasilitasList = array_filter(array_map('trim', $fasilitasList));
    }

    if ($room->photos->count()) {
        foreach ($room->photos->sortBy('order')->sortByDesc('is_primary') as $photo) {
            $gallery[] = asset($photo->path);
        }
    } else {
        $gedung = strtoupper($room->floor?->building?->code ?? ($room->gedung ?? ''));

        $folderMap = [
            'A' => 'a',
            'B' => 'b',
            'C' => 'c',
            'D' => 'd',
            'E' => 'e',
            'F' => 'f',
        ];

        $folder = $folderMap[$gedung] ?? null;

        if ($folder) {
            for ($i = 1; $i <= 6; $i++) {
                $file = public_path("images/{$folder}/{$folder}{$i}.jpg");

                if (file_exists($file)) {
                    $gallery[] = asset("images/{$folder}/{$folder}{$i}.jpg");
                }
            }
        }
    }

    if (empty($gallery)) {
        $gallery[] = asset('assets-admin/images/hero-1.jpg');
    }
@endphp

<div
    class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-orange-300 hover:shadow-xl">

    {{-- FULL CARD CLICK --}}
    <a href="{{ route('cari-kamar.show', $room->room_id) }}" target="_blank" rel="noopener noreferrer"
        class="absolute inset-0 z-10" aria-label="Detail Kamar {{ $room->kode_kamar }}">
    </a>

    <div class="flex flex-col lg:flex-row">

        {{-- FOTO --}}
        <div class="relative w-full lg:w-[340px] shrink-0 overflow-hidden">

            {{-- FOTO UTAMA --}}
            <img src="{{ $gallery[0] }}" alt="{{ $room->kode_kamar }}" class="h-[240px] w-full object-cover">

            {{-- THUMBNAIL --}}
            @if (count($gallery) > 1)

                <div class="grid grid-cols-4 gap-1 mt-1">

                    {{-- Thumbnail 1 --}}
                    @if (isset($gallery[1]))
                        <img src="{{ $gallery[1] }}" class="h-[70px] w-full object-cover">
                    @endif

                    {{-- Thumbnail 2 --}}
                    @if (isset($gallery[2]))
                        <img src="{{ $gallery[2] }}" class="h-[70px] w-full object-cover">
                    @endif

                    {{-- Thumbnail 3 --}}
                    @if (isset($gallery[3]))
                        <img src="{{ $gallery[3] }}" class="h-[70px] w-full object-cover">
                    @endif

                    {{-- See All --}}
                    <div class="relative">

                        <img src="{{ $gallery[4] ?? $gallery[0] }}" class="h-[70px] w-full object-cover">

                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">

                            <span class="text-sm font-bold text-white">

                                See All

                            </span>

                        </div>

                    </div>

                </div>

            @endif

        </div>

        {{-- INFORMASI --}}
        <div class="flex-1 p-6 min-w-0">

            <div class="flex items-start justify-between gap-4">

                <div>

                    @if ($isAvailable)
                        <x-ui.badge type="success" label="{{ $slots }} Slot Tersedia" />
                    @else
                        <x-ui.badge type="danger" label="Kamar Penuh" />
                    @endif

                    <h3 class="mt-3 text-3xl font-black text-slate-900 transition group-hover:text-orange-500">

                        {{ $room->kode_kamar }}

                    </h3>

                    <p class="mt-1 text-slate-500">

                        {{ $gedungLabel }} • Lantai {{ $lantai }}

                    </p>

                </div>

            </div>

            <hr class="my-5">

            {{-- FASILITAS --}}

            <div class="grid grid-cols-3 gap-x-6 gap-y-2">

                @foreach ($fasilitasList as $fasilitas)
                    <div class="flex items-center gap-2 text-sm font-medium text-emerald-600">

                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none">

                            <path d="M5 12L10 17L19 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />

                        </svg>

                        <span>{{ $fasilitas }}</span>

                    </div>
                @endforeach

            </div>

            <hr class="my-5">

            {{-- INFO --}}
            <div class="flex flex-wrap gap-x-6 gap-y-3 text-sm">

                <div class="flex items-center gap-2 text-slate-700">
                    <svg id='User_Account_24' width='24' height='24' viewBox='0 0 24 24'
                        xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                        <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                        <g transform="matrix(0.91 0 0 0.91 12 12)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-12, -12)"
                                d="M 8 5 C 6.343145750507619 5 5 6.343145750507619 5 8 C 5 9.65685424949238 6.343145750507619 11 8 11 C 9.65685424949238 11 11 9.65685424949238 11 8 C 11 6.343145750507619 9.65685424949238 5 8 5 z M 16 5 C 14.34314575050762 5 13 6.343145750507619 13 8 C 13 9.65685424949238 14.34314575050762 11 16 11 C 17.65685424949238 11 19 9.65685424949238 19 8 C 19 6.343145750507619 17.65685424949238 5 16 5 z M 8 13 C 5 13 1 14.464 1 16.5 L 1 19 L 15 19 L 15 16.5 C 15 14.464 11 13 8 13 z M 16 13 C 15.683 13 15.353484 13.019781 15.021484 13.050781 C 16.203484 13.915781 17 15.059 17 16.5 L 17 19 L 23 19 L 23 16.5 C 23 14.464 19 13 16 13 z"
                                stroke-linecap="round" />
                        </g>
                    </svg>
                    <span>
                        Kapasitas {{ $capacity }} Orang
                    </span>

                </div>

                <div class="flex items-center gap-2 text-slate-700">

                    <svg id='Bedroom_24' width='24' height='24' viewBox='0 0 24 24'
                        xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                        <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                        <g transform="matrix(0.71 0 0 0.71 12 12)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-15, -15.01)"
                                d="M 15 3 C 12.410866 3 10.156284 3.8058168 8.9453125 5 L 6 5 C 4.343 5 3 6.343 3 8 L 3 13 L 5 13 L 5 11 C 5 10.448 5.448 10 6 10 L 13 10 C 13.552 10 14 10.448 14 11 L 14 13 L 16 13 L 16 11 C 16 10.448 16.448 10 17 10 L 24 10 C 24.552 10 25 10.448 25 11 L 25 13 L 27 13 L 27 8 C 27 6.343 25.657 5 24 5 L 21.054688 5 C 19.843716 3.8058168 17.589134 3 15 3 z M 1.984375 13.986328 C 1.43285880343316 13.99494907306296 0.9924472798733881 14.448468138368236 1 15 L 1 26 C 0.9948997104545151 26.360635916577568 1.1843752961693321 26.696081364571608 1.495872849714331 26.877887721486516 C 1.8073704032593298 27.059694078401428 2.192629596740671 27.059694078401428 2.5041271502856697 26.877887721486516 C 2.8156247038306685 26.696081364571608 3.005100289545485 26.360635916577568 3 26 L 3 25 L 27 25 L 27 26 C 26.994899710454515 26.360635916577568 27.184375296169332 26.696081364571608 27.49587284971433 26.877887721486516 C 27.80737040325933 27.059694078401428 28.19262959674067 27.059694078401428 28.50412715028567 26.877887721486516 C 28.815624703830668 26.696081364571608 29.005100289545485 26.360635916577568 29 26 L 29 15 C 29.0037014610102 14.729699667173675 28.897823324754008 14.469413346079792 28.706490332869745 14.278448278708167 C 28.515157340985482 14.087483211336544 28.25466770753046 13.982106271031087 27.984375 13.986328 C 27.935930404634988 13.987377970550261 27.887626171553162 13.991947339576246 27.839844 14 L 2.1542969 14 C 2.0981486119520016 13.990614863501376 2.041301519496221 13.98604091836508 1.9843749999999996 13.986328 z"
                                stroke-linecap="round" />
                        </g>
                    </svg>

                    <span>
                        Terisi {{ $occupied }} Orang
                    </span>

                </div>

                <div class="flex items-center gap-2 font-bold text-orange-600">

                    <svg id='Key_24' width='24' height='24' viewBox='0 0 24 24'
                        xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                        <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                        <g transform="matrix(0.83 0 0 0.83 12 12)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-12, -12)"
                                d="M 7 5 C 3.134 5 0 8.134 0 12 C 0 15.866 3.134 19 7 19 C 10.170669 19 12.846171 16.890989 13.707031 14 L 18 14 L 18 17 L 22 17 L 22 14 L 24 14 L 24 10 L 13.707031 10 C 12.846171 7.1090112 10.170669 5 7 5 z M 7 9 C 8.657 9 10 10.343 10 12 C 10 13.657 8.657 15 7 15 C 5.343 15 4 13.657 4 12 C 4 10.343 5.343 9 7 9 z"
                                stroke-linecap="round" />
                        </g>
                    </svg>
                    <span>
                        Sisa {{ $slots }} Slot
                    </span>

                </div>

            </div>

        </div>

        {{-- HARGA --}}
        @php
            $hargaBerdua = ceil($harga / 2);
            $hargaBertiga = $capacity >= 3 ? ceil($harga / 3) : null;
        @endphp

        <div
            class="
w-full
xl:w-[300px]
border-t
xl:border-t-0
xl:border-l
border-slate-200
bg-slate-50
p-5

flex
flex-col
sm:flex-row
xl:flex-col

justify-between
gap-5
">

            <div class="lg:text-right">

                <div class="text-xs uppercase tracking-wider text-slate-500">
                    Harga Kamar
                </div>

                <div class="mt-2 text-3xl font-black text-orange-600">
                    Rp {{ number_format($harga, 0, ',', '.') }}
                </div>

                <div class="text-sm text-slate-500">
                    / kamar / bulan
                </div>

                <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-3 text-left">

                    <div class="mb-2 text-xs font-bold text-blue-700">
                        Pembayaran
                    </div>

                    <div class="flex justify-between text-sm">
                        <span>1 penghuni</span>
                        <span class="font-semibold">
                            Rp {{ number_format($harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-1 flex justify-between text-sm">
                        <span>2 penghuni</span>
                        <span class="font-semibold">
                            Rp {{ number_format($hargaBerdua, 0, ',', '.') }}/org
                        </span>
                    </div>

                    @if ($capacity >= 3)
                        <div class="mt-1 flex justify-between text-sm">
                            <span>3 penghuni</span>
                            <span class="font-semibold">
                                Rp {{ number_format($hargaBertiga, 0, ',', '.') }}/org
                            </span>
                        </div>
                    @endif

                </div>

            </div>

            <a href="{{ route('cari-kamar.show', $room->room_id) }}" target="_blank" rel="noopener noreferrer"
                class="
relative z-20
w-full
sm:w-auto
xl:w-full
flex items-center justify-center
rounded-2xl
bg-[#070B55]
px-6 py-4
font-black text-white
transition
hover:bg-[#0a1070]
">
                {{ $isAvailable ? 'Pilih Kamar' : 'Lihat Detail' }}

            </a>

        </div>

    </div>

</div>
