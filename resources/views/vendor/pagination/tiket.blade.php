@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4">
        <p class="text-sm text-slate-600">
            Showing
            <span class="font-bold">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-bold">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-bold">{{ $paginator->total() }}</span>
            results
        </p>

        <div class="inline-flex overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-slate-300 cursor-not-allowed">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-2 text-slate-700 hover:bg-slate-50">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                {{-- "..." --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-slate-400">{{ $element }}</span>
                @endif

                {{-- Page Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 bg-slate-900 text-white font-extrabold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-4 py-2 text-slate-700 hover:bg-slate-50 font-bold">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-2 text-slate-700 hover:bg-slate-50">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-2 text-slate-300 cursor-not-allowed">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
