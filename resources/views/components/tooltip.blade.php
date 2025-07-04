<div x-data="{ showTooltip: false }" class="relative">
    <span
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        class="cursor-pointer"
    >
        <!-- Slot for the element triggering the tooltip -->
        <slot name="trigger"></slot>
    </span>
    <div
        x-show="showTooltip"
        x-transition
        class="absolute left-1/2 transform -translate-x-1/2 mt-2 px-3 py-1 text-sm text-white bg-gray-800 rounded shadow-lg"
    >
        <!-- Slot for the tooltip content -->
        <slot name="content"></slot>
    </div>
</div>
