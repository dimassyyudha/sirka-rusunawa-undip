@props([
    'sort' => 'recommended',
])

<form id="sortForm" method="GET" action="{{ route('cari-kamar.index') }}">


    @foreach (request()->except('sort', 'page') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <div class="space-y-3">

        <label
            class="flex cursor-pointer items-center justify-between rounded-2xl border p-4 hover:border-blue-500
        {{ $sort === 'recommended' ? 'border-blue-600 bg-blue-50' : 'border-slate-200' }}">

            <span class="font-black">
                Recommended
            </span>

            <input type="radio" name="sort" value="recommended"
                onchange="document.getElementById('sortForm').submit()" {{ $sort === 'recommended' ? 'checked' : '' }}>

        </label>

        <label
            class="flex cursor-pointer items-center justify-between rounded-2xl border p-4 hover:border-blue-500
        {{ $sort === 'price_low' ? 'border-blue-600 bg-blue-50' : 'border-slate-200' }}">

            <span class="font-black">
                Harga Terendah
            </span>

            <input type="radio" name="sort" value="price_low"
                onchange="document.getElementById('sortForm').submit()" {{ $sort === 'price_low' ? 'checked' : '' }}>

        </label>

        <label
            class="flex cursor-pointer items-center justify-between rounded-2xl border p-4 hover:border-blue-500
        {{ $sort === 'price_high' ? 'border-blue-600 bg-blue-50' : 'border-slate-200' }}">

            <span class="font-black">
                Harga Tertinggi
            </span>

            <input type="radio" name="sort" value="price_high"
                onchange="document.getElementById('sortForm').submit()" {{ $sort === 'price_high' ? 'checked' : '' }}>

        </label>

        <label
            class="flex cursor-pointer items-center justify-between rounded-2xl border p-4 hover:border-blue-500
        {{ $sort === 'slots_high' ? 'border-blue-600 bg-blue-50' : 'border-slate-200' }}">

            <span class="font-black">
                Slot Terbanyak
            </span>

            <input type="radio" name="sort" value="slots_high"
                onchange="document.getElementById('sortForm').submit()" {{ $sort === 'slots_high' ? 'checked' : '' }}>

        </label>

    </div>


</form>
