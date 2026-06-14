@php
    $isEdit = isset($item);

    // fallback aman
    $nextOrder = $nextOrder ?? 1;
@endphp

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-container { width:100%!important; }
        .select2-container .select2-selection--single{
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 36px;
        }
    </style>
@endpush

<div class="row g-3">

    {{-- SEARCHABLE SELECT ROOM --}}
    <div class="col-md-8">
        <label class="form-label fw-bold">Pilih Kamar</label>

        <select name="room_id" class="form-select js-room-select">
            <option value="">(Pilih kamar dari database)</option>

            @foreach ($rooms as $r)
                @php
                    $capacity = (int)($r->capacity ?? 2);
                    $occupied = (int)($r->occupied ?? 0);
                    $slot     = max(0, $capacity - $occupied);
                    $gedung   = str_replace('Gedung ', '', (string)$r->gedung);
                @endphp

                <option value="{{ $r->id }}"
                    @selected(old('room_id', $item->room_id ?? null) == $r->id)>
                    {{ $r->kode_kamar }}
                    — Gedung {{ $gedung }}
                    — Lantai {{ $r->lantai }}
                    — Rp {{ number_format((int)$r->harga, 0, ',', '.') }}
                    — Slot {{ $slot }}
                    — Status {{ $r->status }}
                </option>
            @endforeach
        </select>

        <div class="form-text">
            Tips: ketik <b>A101</b> / <b>Gedung A</b> / <b>Lantai 2</b> biar cepat.
        </div>
    </div>

    {{-- SORT ORDER --}}
    <div class="col-md-2">
        <label class="form-label fw-bold">Nomor Urut</label>
        <input
            type="number"
            name="sort_order"
            class="form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $item->sort_order ?? $nextOrder) }}"
            min="1"
            step="1"
            required
        >
        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Wajib unik & minimal 1.</div>
    </div>

    {{-- ACTIVE --}}
    <div class="col-md-2">
        <label class="form-label fw-bold">Status</label>
        <div class="form-check mt-2">
            <input
                class="form-check-input"
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $item->is_active ?? true))
            >
            <label class="form-check-label">Aktifkan</label>
        </div>
    </div>

    {{-- BADGE --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">Badge (opsional)</label>
        <input
            type="text"
            name="badge"
            class="form-control @error('badge') is-invalid @enderror"
            value="{{ old('badge', $item->badge ?? 'Rekomendasi') }}"
            placeholder="Rekomendasi"
        >
        @error('badge')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

@push('scripts-bottom')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.js-room-select').select2({
                placeholder: "Ketik A101 / Gedung A / Lantai 2 ...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
