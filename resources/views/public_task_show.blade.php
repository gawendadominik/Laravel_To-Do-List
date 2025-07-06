<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Application Logo Component -->
        <div class="flex justify-center mb-6">
            <h1
                class="relative text-6xl md:text-7xl font-black tracking-tight text-transparent bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 bg-clip-text drop-shadow-lg animate-gradient-x cursor-pointer group-focus:outline-none group-focus:ring-2 group-focus:ring-orange-500"
                tabindex="0"
                aria-label="Go to homepage"
            >
                Tasklify
                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-2/3 h-3 blur-xl opacity-80 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-700 pointer-events-none animate-pulse"></span>
            </h1>
        </div>

        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg mx-auto">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @else
            <!-- Task Card -->
            <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">
                    Task Title: {{ $task->title }}
                </h1>
                <p class="text-gray-600 mb-4">
                    Description: {{ $task->description }}
                </p>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-500">
                        Due Date: <strong>{{ $task->due_date }}</strong>
                    </span>
                    @php
                        $priorityColors = [
                            'low' => 'bg-green-200 text-green-800',
                            'medium' => 'bg-yellow-200 text-yellow-800',
                            'high' => 'bg-red-200 text-red-800',
                        ];
                        $priorityClass = $priorityColors[$task->priority] ?? 'bg-gray-200 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $priorityClass }}">
                        Priority: {{ ucfirst($task->priority) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">
                        Status: <strong>{{ ucfirst($task->status) }}</strong>
                    </span>
                    <span class="text-sm text-gray-500">
                        Assigned To: <strong>{{ $task->user->name ?? 'Unassigned' }}</strong>
                    </span>
                </div>
            </div>
        @endif
    </div>
</body>
</html>