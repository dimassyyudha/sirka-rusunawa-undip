@props([
    'sort' => request('sort', 'recommended'),
])

<form method="GET" action="{{ route('cari-kamar.index') }}">

    @foreach (request()->except('sort', 'page') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <div class="space-y-2">

        {{-- RECOMMENDED --}}
        <label
            class="flex cursor-pointer items-center justify-between rounded-xl border px-3 py-2.5 transition
            {{ $sort === 'recommended' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-500' }}">

            <span class="text-sm font-semibold">
                Recommended
            </span>

            <input type="radio" name="sort" value="recommended" {{ $sort === 'recommended' ? 'checked' : '' }}
                onchange="this.form.submit()">
        </label>

        {{-- HARGA RENDAH --}}
        <label
            class="flex cursor-pointer items-center justify-between rounded-xl border px-3 py-2.5 transition
            {{ $sort === 'price_low' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-500' }}">

            <span class="text-sm font-semibold">
                Harga Terendah
            </span>

            <input type="radio" name="sort" value="price_low" {{ $sort === 'price_low' ? 'checked' : '' }}
                onchange="this.form.submit()">
        </label>

        {{-- HARGA TERTINGGI --}}
        <label
            class="flex cursor-pointer items-center justify-between rounded-xl border px-3 py-2.5 transition
            {{ $sort === 'price_high' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-500' }}">

            <span class="text-sm font-semibold">
                Harga Tertinggi
            </span>

            <input type="radio" name="sort" value="price_high" {{ $sort === 'price_high' ? 'checked' : '' }}
                onchange="this.form.submit()">
        </label>

        {{-- SLOT TERBANYAK --}}
        <label
            class="flex cursor-pointer items-center justify-between rounded-xl border px-3 py-2.5 transition
            {{ $sort === 'slots_high' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-500' }}">

            <span class="text-sm font-semibold">
                Slot Terbanyak
            </span>

            <input type="radio" name="sort" value="slots_high" {{ $sort === 'slots_high' ? 'checked' : '' }}
                onchange="this.form.submit()">
        </label>

    </div>

</form>
