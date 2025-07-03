@props(['type' => 'info', 'message'])

@php
    $styles = [
        'success' => 'bg-green-50 border-l-4 border-green-500 text-green-900',
        'error' => 'bg-red-50 border-l-4 border-red-500 text-red-900',
        'warning' => 'bg-yellow-50 border-l-4 border-yellow-500 text-yellow-900',
        'info' => 'bg-blue-50 border-l-4 border-blue-500 text-blue-900',
    ];

    // Set icon size classes (much bigger for warning and info)
    $iconSize = in_array($type, ['warning', 'info']) ? 'w-11 h-11' : 'w-5 h-5';

    $icons = [
        'success' => '<svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
        'error' => '<svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
        'warning' => '<svg class="ICON_SIZE text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" /></svg>',
        'info' => '<svg class="ICON_SIZE text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" /></svg>',
    ];

    // Replace ICON_SIZE with the correct size for warning and info
    foreach (['warning', 'info'] as $t) {
        $icons[$t] = str_replace('ICON_SIZE', $iconSize, $icons[$t]);
    }

    // Ensure the type is valid, fallback to 'info' if not
    if (!array_key_exists($type, $styles)) {
        $type = 'info';
    }
    // Use smaller padding for warning and info
    $padding = in_array($type, ['warning', 'info']) ? 'p-2' : 'p-4';
@endphp

<div class="overflow-hidden shadow-md rounded-lg">
    <div class="flex items-center {{ $padding }} {{ $styles[$type] ?? $styles['info'] }}">
        {!! $icons[$type] ?? $icons['info'] !!}
        {{ $message }}
    </div>
</div>
