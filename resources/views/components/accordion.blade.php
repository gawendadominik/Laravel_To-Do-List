<div {{ $attributes->merge(['x-data' => '{ open: false }']) }}>
    <button
        @click="open = !open"
        class="w-full flex justify-between items-center px-2 py-2 font-semibold focus:outline-none bg-transparent text-gray-800"
    >
        {{ $header ?? 'Default Header' }}
        <svg
            :class="{'transform rotate-180': open}"
            class="h-5 w-5 transition-transform"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </button>
    <div
        x-show="open"
        x-transition
        class="mt-2 p-2 px-4 text-orange-800"
    >
        {{ $content ?? 'Default Content' }}
    </div>
    <hr class="border-gray-200 mb-4">
</div>
