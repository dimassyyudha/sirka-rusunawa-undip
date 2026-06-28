@php
    $isEdit = isset($item);
    $nextOrder = $nextOrder ?? 1;
@endphp

<div class="grid md:grid-cols-2 gap-5">

    <div class="md:col-span-2">

        <label class="mb-2.5 block text-sm font-medium text-slate-700">
            Kamar
        </label>

        <select id="room_id" name="room_id" required class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <option value="">
                -- Pilih Kamar --
            </option>

            @foreach ($rooms as $room)
                @php
                    $capacity = (int) ($room->capacity ?? 2);
                    $occupied = (int) ($room->occupied ?? 0);
                    $slot = max(0, $capacity - $occupied);

                    $gedung = str_replace('Gedung ', '', (string) $room->gedung);
                @endphp

                <option value="{{ $room->room_id }}" @selected(old('room_id', $item->room_id ?? null) == $room->room_id)>

                    {{ $room->kode_kamar }}
                    -
                    Gedung {{ $gedung }}
                    -
                    Lantai {{ $room->lantai }}
                    -
                    Slot {{ $slot }}

                </option>
            @endforeach

        </select>

        @error('room_id')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div>

        <label class="mb-2.5 block text-sm font-medium text-slate-700">
            Nomor Urut
        </label>

        <input type="number" name="sort_order" min="1" required
            value="{{ old('sort_order', $item->sort_order ?? $nextOrder) }}"
            class="w-full rounded-2xl border border-slate-300 px-4 py-3">

        @error('sort_order')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div>

        <label class="mb-2.5 block text-sm font-medium text-slate-700">
            Badge
        </label>

        <input type="text" name="badge" value="{{ old('badge', $item->badge ?? 'Rekomendasi') }}"
            class="w-full rounded-2xl border border-slate-300 px-4 py-3" placeholder="Rekomendasi">

        @error('badge')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div class="md:col-span-2">

        <label class="flex items-center gap-3">

            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))
                class="h-5 w-5 rounded border-slate-300">

            <span class="font-semibold text-slate-700">
                Tampilkan rekomendasi ini di halaman beranda
            </span>

        </label>

    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            new TomSelect('#room_id', {
                create: false,
                allowEmptyOption: true,
                placeholder: 'Cari kode kamar, gedung, atau lantai...',
                maxOptions: null,
            });

        });
    </script>
@endpush
