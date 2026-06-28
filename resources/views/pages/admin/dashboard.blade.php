@extends('layouts.app')
@section('title', 'Dashboard Pengelola')
@section('page_title', 'Dashboard Pengelola')

@section('content')
    <div class="space-y-6">

        <div>
            <h2 class="text-2xl font-black text-slate-900">
                Dashboard Pengelola - SIRKA Rusunawa UNDIP
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Monitoring hunian dan pemasukan Rusunawa
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">Total Kamar</p>
                <h3 class="text-3xl font-black text-slate-900 mt-2">{{ $totalRooms }}</h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">Kamar Tersedia</p>
                <h3 class="text-3xl font-black text-emerald-600 mt-2">{{ $availableRooms }}</h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">Kamar Terisi</p>
                <h3 class="text-3xl font-black text-orange-600 mt-2">{{ $occupiedRooms }}</h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">Kamar Penuh</p>
                <h3 class="text-3xl font-black text-red-600 mt-2">{{ $fullRooms }}</h3>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-stretch">

            <div class="xl:col-span-2 space-y-6">

                {{-- STATISTIK GEDUNG --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-lg font-black text-slate-900">Statistik Gedung</h3>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left font-black text-slate-600">Gedung</th>
                                    <th class="px-6 py-4 text-center font-black text-slate-600">Total</th>
                                    <th class="px-6 py-4 text-center font-black text-emerald-600">Tersedia</th>
                                    <th class="px-6 py-4 text-center font-black text-orange-600">Terisi</th>
                                    <th class="px-6 py-4 text-center font-black text-red-600">Penuh</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                                @forelse($statsByBuilding as $stat)
                                    <tr class="hover:bg-slate-50">

                                        <td class="px-6 py-4 font-bold">
                                            {{ $stat['nama_gedung'] }}
                                        </td>

                                        <td class="px-6 py-4 text-center font-semibold">
                                            {{ $stat['total'] }}
                                        </td>

                                        <td class="px-6 py-4 text-center font-bold text-emerald-600">
                                            {{ $stat['tersedia'] }}
                                        </td>

                                        <td class="px-6 py-4 text-center font-bold text-emerald-600">
                                            {{ $stat['terisi'] }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-emerald-600">
                                            {{ $stat['full'] }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                            Belum ada data.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                </div>

                {{-- PEMASUKAN --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-lg font-black text-slate-900">Pemasukan Gedung</h3>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left font-black text-slate-600">
                                        Gedung
                                    </th>

                                    <th class="px-6 py-4 text-right font-black text-slate-600">
                                        Pemasukan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @php $totalIncome=0; @endphp

                                @forelse($incomeByBuilding as $row)
                                    @php $totalIncome += $row->income; @endphp

                                    <tr class="hover:bg-slate-50">

                                        <td class="px-6 py-4 font-bold">
                                            {{ $row->nama_gedung }}
                                        </td>

                                        <td class="px-6 py-4 text-right font-bold">
                                            Rp {{ number_format($row->income, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center text-slate-500">
                                            Belum ada data pemasukan.
                                        </td>
                                    </tr>
                                @endforelse

                                <tr class="bg-slate-50">
                                    <td class="px-6 py-4 font-black">Total</td>
                                    <td class="px-6 py-4 text-right font-black text-indigo-700">
                                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            {{-- CHART --}}
            <div class="xl:col-span-1">

                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6 ">

                    <div class="pb-5 border-b border-slate-100">
                        <h3 class="text-lg font-black">Grafik Hunian</h3>
                        <p class="text-sm text-slate-500 mt-1">Statistik kamar per gedung</p>
                    </div>

                    <div id="column-chart" class="mt-6 flex-1"></div>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('scripts-bottom')
    <script src="{{ asset('assets-admin/vendors/apexcharts/apexcharts.js') }}"></script>

    @php
        $labelsGedung = [];
        $seriesTersedia = [];
        $seriesTerisi = [];
        $seriesPenuh = [];

        foreach ($statsByBuilding as $stat) {
            $labelsGedung[] = $stat['nama_gedung'];
            $seriesTersedia[] = $stat['tersedia'];
            $seriesTerisi[] = $stat['terisi'];
            $seriesPenuh[] = $stat['full'];
        }
    @endphp

    <script>
        const labelsGedung = @json($labelsGedung);
        const dataTersedia = @json($seriesTersedia);
        const dataTerisi = @json($seriesTerisi);
        const dataPenuh = @json($seriesPenuh);

        const options = {
            series: [{
                    name: 'Tersedia',
                    data: dataTersedia
                },
                {
                    name: 'Terisi',
                    data: dataTerisi
                },
                {
                    name: 'Penuh',
                    data: dataPenuh
                }
            ],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#10b981', '#f97316', '#ef4444'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '55%'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: labelsGedung
            },
            yaxis: {
                min: 0
            },
            tooltip: {
                y: {
                    formatter: v => v + ' kamar'
                }
            }
        };

        new ApexCharts(document.querySelector("#column-chart"), options).render();
    </script>
@endpush
