{{-- REQUEST --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm">
    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">Permintaan Khusus</h2>
    </div>

    <div class="px-5 md:px-6 py-5">
        <textarea name="special_request" rows="4" placeholder="Contoh: ingin sekamar dengan teman tertentu."
            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">{{ old('special_request', $formData['special_request'] ?? '') }}</textarea>
    </div>
</div>
