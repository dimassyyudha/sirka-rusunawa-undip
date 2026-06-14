@props([
    'variant' => 'default',
    'type' => 'button',
    'href' => null,
    'size' => 'md',
])

@php

    $base =
        'inline-flex items-center justify-center font-semibold transition-all duration-200 focus:outline-none focus:ring-4 shadow-sm';
    $sizes = [
        'sm' => 'px-3 py-2 text-xs rounded-xl',

        'md' => 'px-4 py-2.5 text-sm rounded-xl',

        'lg' => 'px-5 py-3 text-base rounded-2xl',
    ];

    $variants = [
        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        'default' => 'text-slate-900 bg-white border border-slate-200 hover:bg-slate-100 focus:ring-slate-200',

        /*
        |--------------------------------------------------------------------------
        | PRIMARY
        |--------------------------------------------------------------------------
        */

        'primary' =>
            'text-white bg-violet-600 border border-transparent hover:bg-violet-700 focus:ring-violet-300 shadow-violet-500/20',

        /*
        |--------------------------------------------------------------------------
        | SECONDARY
        |--------------------------------------------------------------------------
        */

        'secondary' =>
            'text-white bg-slate-600 border border-transparent hover:bg-slate-700 focus:ring-slate-300 shadow-slate-500/20',

        /*
        |--------------------------------------------------------------------------
        | ACCENT
        |--------------------------------------------------------------------------
        */

        'accent' =>
            'text-white bg-blue-600 border border-transparent hover:bg-blue-700 focus:ring-blue-300 shadow-blue-500/20',

        /*
        |--------------------------------------------------------------------------
        | INFO
        |--------------------------------------------------------------------------
        */

        'info' =>
            'text-white bg-cyan-500 border border-transparent hover:bg-cyan-600 focus:ring-cyan-300 shadow-cyan-500/20',

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        'success' =>
            'text-white bg-emerald-500 border border-transparent hover:bg-emerald-600 focus:ring-emerald-300 shadow-emerald-500/20',

        /*
        |--------------------------------------------------------------------------
        | WARNING
        |--------------------------------------------------------------------------
        */

        'warning' =>
            'text-white bg-amber-500 border border-transparent hover:bg-amber-600 focus:ring-amber-300 shadow-amber-500/20',

        /*
        |--------------------------------------------------------------------------
        | DANGER
        |--------------------------------------------------------------------------
        */

        'danger' =>
            'text-white bg-red-500 border border-transparent hover:bg-red-600 focus:ring-red-300 shadow-red-500/20',

        /*
        |--------------------------------------------------------------------------
        | DARK
        |--------------------------------------------------------------------------
        */

        'dark' =>
            'text-white bg-slate-900 border border-transparent hover:bg-black focus:ring-slate-400 shadow-slate-700/20',

        /*
        |--------------------------------------------------------------------------
        | GHOST
        |--------------------------------------------------------------------------
        */

        'ghost' => 'text-slate-700 bg-transparent border border-transparent hover:bg-slate-100 focus:ring-slate-200',

        /*
        |--------------------------------------------------------------------------
        | OUTLINE
        |--------------------------------------------------------------------------
        */

        'outline' => 'text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 focus:ring-slate-200',
    ];

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>

        {{ $slot }}

    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>

        {{ $slot }}

    </button>
@endif
