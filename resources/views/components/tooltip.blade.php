@props(['message']);

<div x-data="{ showTooltip: false, timer: null }" class="relative">
    <span
        @mouseenter="timer = setTimeout(() => { showTooltip = true }, 3000)"
        @mouseleave="clearTimeout(timer); showTooltip = false"
        class="w-5 h-5 flex items-center justify-center border-2 border-orange-500 rounded-full cursor-pointer"
    >
        {{ $slot }}
    </span>
    <div
        x-show="showTooltip"
        x-transition
        class="absolute left-0 translate-x-0 mt-2 max-w-lg h-auto px-4 py-2 text-sm text-white bg-gray-800 rounded shadow-lg"
    >
        {{ $message }}
    </div>
</div>

