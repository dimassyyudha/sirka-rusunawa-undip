{{-- resources/views/components/ui/badge.blade.php --}}

@props([
    'type' => 'gray',
    'label' => '',
])

@php
    $classes =
        [
            'putra' => 'border-blue-200 bg-blue-50 text-blue-700',

            'putri' => 'border-pink-200 bg-pink-50 text-pink-700',

            'brand' => 'border-indigo-200 bg-indigo-50 text-indigo-700',

            'alternative' => 'border-slate-200 bg-white text-slate-700',

            'gray' => 'border-slate-200 bg-slate-100 text-slate-700',

            'danger' => 'border-red-200 bg-red-50 text-red-700',

            'success' => 'border-emerald-200 bg-emerald-50 text-emerald-700',

            'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
        ][$type] ?? 'border-slate-200 bg-slate-100 text-slate-700';
@endphp

<span
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center justify-center rounded-full border px-3 py-1 text-xs font-bold whitespace-nowrap ' .
            $classes,
    ]) }}>
    {{ $label }}
</span>
