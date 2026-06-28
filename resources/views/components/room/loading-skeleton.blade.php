@props([
    'rooms',
])

@if ($rooms->hasMorePages())
    <div id="rooms-loading" class="hidden mt-4 space-y-4">
        @for ($i = 0; $i < 3; $i++)
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden animate-pulse">
                <div class="flex flex-col sm:flex-row">
                    <div class="w-full sm:w-[220px] shrink-0">
                        <div class="h-[150px] w-full bg-slate-200"></div>
                    </div>

                    <div class="flex-1 p-4">
                        <div class="h-5 w-40 bg-slate-200 rounded mb-3"></div>
                        <div class="h-4 w-72 bg-slate-200 rounded mb-2"></div>
                        <div class="h-4 w-56 bg-slate-200 rounded mb-4"></div>

                        <div class="flex gap-2">
                            <div class="h-7 w-24 bg-slate-200 rounded-full"></div>
                            <div class="h-7 w-28 bg-slate-200 rounded-full"></div>
                        </div>
                    </div>

                    <div class="w-full sm:w-[220px] p-4 sm:border-l border-slate-100">
                        <div class="h-4 w-24 bg-slate-200 rounded mb-3"></div>
                        <div class="h-6 w-36 bg-slate-200 rounded mb-8"></div>
                        <div class="h-11 w-full bg-slate-200 rounded-xl"></div>
                    </div>
                </div>
            </div>
        @endfor

        <div class="flex items-center justify-center gap-3 py-4 text-sm font-bold text-slate-500">
            <span class="inline-block h-5 w-5 rounded-full border-2 border-slate-300 border-t-blue-600 animate-spin"></span>
            <span>Memuat kamar lainnya...</span>
        </div>
    </div>

    <div
        id="infinite-scroll-trigger"
        data-next-page="{{ $rooms->currentPage() + 1 }}"
        data-last-page="{{ $rooms->lastPage() }}"
        class="h-1">
    </div>
@else
    @if ($rooms->count() > 0)
        <div class="py-8 text-center text-sm font-bold text-slate-400">
            Semua kamar sudah ditampilkan.
        </div>
    @endif
@endif

