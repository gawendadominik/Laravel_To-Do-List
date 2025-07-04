<span
    {{ $attributes->merge(['class' => 'px-2 py-1 rounded-full flex items-center justify-center']) }}
    :class="{
        'bg-gray-200 text-gray-800': $type === 'status' && $value === 'to-do',
        'bg-yellow-200 text-yellow-800': $type === 'status' && $value === 'in progress',
        'bg-green-200 text-green-800': $type === 'status' && $value === 'done',
        'bg-blue-200 text-blue-800': $type === 'priority' && $value === 'low',
        'bg-yellow-400 text-yellow-800': $type === 'priority' && $value === 'medium',
        'bg-red-400 text-red-800': $type === 'priority' && $value === 'high'
    }"
    x-text="$value.charAt(0).toUpperCase() + $value.slice(1)"
></span>
