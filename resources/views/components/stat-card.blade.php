@props(['icon' => 'file-text', 'value', 'label', 'color' => 'gray'])

@php
    /* Classes écrites en toutes lettres (pas de concaténation dynamique)
       pour que le scanner Tailwind les détecte au build. */
    $styles = match ($color) {
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'],
    };
@endphp

<div class="bg-white rounded-lg p-4 shadow-sm flex items-center gap-3">
    <div class="w-10 h-10 rounded-lg {{ $styles['bg'] }} {{ $styles['text'] }} flex items-center justify-center shrink-0">
        <x-icon :name="$icon" />
    </div>
    <div>
        <p class="text-xl font-semibold text-gray-800 leading-none">{{ $value }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ $label }}</p>
    </div>
</div>
