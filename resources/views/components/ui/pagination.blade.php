@props(['paginator', 'perPageOptions' => [10, 25, 50, 100]])

@php
    $currentPage = $paginator->currentPage();
    $lastPage = max(1, $paginator->lastPage());

    $pages = [];

    if ($lastPage <= 7) {
        $pages = range(1, $lastPage);
    } else {
        $pages[] = 1;

        if ($currentPage > 4) {
            $pages[] = '...';
        }

        $start = max(2, $currentPage - 1);
        $end = min($lastPage - 1, $currentPage + 1);

        if ($currentPage <= 4) {
            $start = 2;
            $end = 5;
        }

        if ($currentPage >= $lastPage - 3) {
            $start = $lastPage - 4;
            $end = $lastPage - 1;
        }

        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        if ($currentPage < $lastPage - 3) {
            $pages[] = '...';
        }

        $pages[] = $lastPage;
    }

    $query = request()->except(['page', 'per_page']);
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

    <nav class="w-full overflow-x-auto ">
        <ul class="flex items-center gap-1 text-sm min-w-max">

            <li>
                @if ($paginator->onFirstPage())
                    <span
                        class="flex items-center justify-center h-10 px-4 rounded-xl bg-slate-100 text-slate-400 font-bold cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="flex items-center justify-center h-10 px-4 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold transition">
                        Previous
                    </a>
                @endif
            </li>

            @foreach ($pages as $page)
                @if ($page === '...')
                    <li>
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl text-slate-400 font-black">
                            ...
                        </span>
                    </li>
                @elseif ($page == $currentPage)
                    <li>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-violet-600 text-white font-black shadow">
                            {{ $page }}
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold transition">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="flex items-center justify-center h-10 px-4 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold transition">
                        Next
                    </a>
                @else
                    <span
                        class="flex items-center justify-center h-10 px-4 rounded-xl bg-slate-100 text-slate-400 font-bold cursor-not-allowed">
                        Next
                    </span>
                @endif
            </li>

        </ul>
    </nav>

    <form method="GET" class="w-40 shrink-0">
        @foreach ($query as $key => $value)
            @if (is_scalar($value))
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <select name="per_page" onchange="this.form.submit()"
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-700 shadow-sm focus:outline-none focus:ring-4 focus:ring-violet-200">

            @foreach ($perPageOptions as $option)
                <option value="{{ $option }}" @selected(request('per_page', $paginator->perPage()) == $option)>
                    {{ $option }} per page
                </option>
            @endforeach

        </select>
    </form>

</div>
