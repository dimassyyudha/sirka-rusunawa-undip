@if (session('success') || session('error') || session('warning') || $errors->any())

    @php
        if ($errors->any()) {
            $type = 'error';
        } elseif (session('success')) {
            $type = 'success';
        } elseif (session('warning')) {
            $type = 'warning';
        } else {
            $type = 'error';
        }

        $title = match ($type) {
            'success' => 'Berhasil',
            'warning' => 'Perhatian',
            default => 'Periksa Kembali',
        };

        $message = $errors->any() ? null : session('success') ?? (session('warning') ?? session('error'));
    @endphp

    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-3"
        class="fixed top-5 left-1/2 z-[9999] w-[92vw] max-w-2xl -translate-x-1/2" style="display:none">

        <div
            class="overflow-hidden rounded-2xl bg-white shadow-[0_20px_50px_-12px_rgba(15,23,42,.18)] ring-1
            {{ $type === 'success' ? 'ring-emerald-200' : '' }}
            {{ $type === 'warning' ? 'ring-amber-200' : '' }}
            {{ $type === 'error' ? 'ring-red-200' : '' }}">

            <div class="flex items-start gap-4 p-5">

                {{-- ICON --}}
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full
                    {{ $type === 'success' ? 'bg-emerald-100 text-emerald-600' : '' }}
                    {{ $type === 'warning' ? 'bg-amber-100 text-amber-600' : '' }}
                    {{ $type === 'error' ? 'bg-red-100 text-red-600' : '' }}">

                    @if ($type === 'success')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />

                        </svg>
                    @elseif ($type === 'warning')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m0 3.75h.008v.008H12v-.008z" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25l9.75 16.5H2.25L12 2.25z" />

                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m0 3.75h.008v.008H12v-.008z" />

                            <circle cx="12" cy="12" r="9" />

                        </svg>
                    @endif

                </div>

                {{-- CONTENT --}}
                <div class="min-w-0 flex-1">

                    <h3 class="font-bold text-slate-900">
                        {{ $title }}
                    </h3>

                    @if ($errors->any())

                        <div class="mt-2 space-y-1 text-sm text-slate-600">

                            @foreach ($errors->all() as $error)
                                <div>
                                    {{ $error }}
                                </div>
                            @endforeach

                        </div>
                    @else
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">
                            {{ $message }}
                        </p>

                    @endif

                </div>

                {{-- CLOSE --}}
                <button @click="show=false"
                    class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-5 w-5">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

            {{-- PROGRESS BAR --}}
            <div class="h-1 bg-slate-100">

                <div
                    class="h-full animate-[shrink_7s_linear_forwards]
                    {{ $type === 'success' ? 'bg-emerald-500' : '' }}
                    {{ $type === 'warning' ? 'bg-amber-500' : '' }}
                    {{ $type === 'error' ? 'bg-red-500' : '' }}">
                </div>

            </div>

        </div>

    </div>

    <style>
        @keyframes shrink {
            from {
                width: 100%
            }

            to {
                width: 0%
            }
        }
    </style>

@endif
