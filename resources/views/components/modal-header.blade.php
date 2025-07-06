@props(['title'])
<div>
    <div class="flex items-center justify-between bg-white px-6 py-4 rounded-t-lg border-b border-gray-300 shadow-sm">
        <h2 class="text-xl font-bold text-gray-800">{{ $title }}</h2>
        {{ $button ?? '' }}
    </div>
</div>
