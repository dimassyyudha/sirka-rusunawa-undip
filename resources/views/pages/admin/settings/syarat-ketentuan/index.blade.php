@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 px-4 py-6">
        <div class="mx-auto max-w-7xl space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        Syarat & Ketentuan & Conditions
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Kelola aturan dan ketentuan penghuni Rusunawa Universitas Diponegoro.
                    </p>

                </div>

                <x-button.button-menu href="{{ route('admin.settings.syarat-ketentuan.edit') }}" variant="primary"
                    size="md">

                    Edit Syarat Ketentuan

                </x-button.button-menu>

            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-xl font-semibold text-slate-900">
                        {{ $data['title'] ?? 'syaratKetentuan & Conditions' }}
                    </h2>

                </div>
                <div class="space-y-8 p-6">

                    @foreach ($sections as $section)
                        <div class="mb-10 border-b border-slate-200 pb-10 last:border-b-0">

                            <h3 class="mb-2 text-xl font-bold text-slate-900">

                                Ketentuan {{ $section['number'] }}. {{ $section['title'] }}

                            </h3>

                            {{-- <p class="mb-4 text-lg font-medium text-slate-700">

                                {{ $section['title'] }}

                            </p> --}}

                            <ol class="space-y-2">
                                @foreach ($section['items'] as $index => $item)
                                    <li class="flex gap-2">
                                        <span class="font-semibold">
                                            {{ chr(97 + $index) }}.
                                        </span>

                                        <span>
                                            {{ $item }}
                                        </span>
                                    </li>
                                @endforeach
                            </ol>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>


    </div>
@endsection
