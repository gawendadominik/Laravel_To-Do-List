@props(['title'])
<div>
    <div class="flex items-center justify-between bg-gradient-to-r from-orange-400 to-orange-600 px-6 py-4 rounded-t-lg shadow">
        <h2 class="text-xl font-bold text-white">{{ $title }}</h2>
        {{ $button ?? '' }}
    </div>
</div>
