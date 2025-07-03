<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasklify | Take Control of Your Day</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white overflow-hidden px-4 py-4 sm:px-6 sm:py-6">
    @auth
        <script>window.location.href = "{{ url('/tasks') }}";</script>
    @endauth

    <div class="w-full flex flex-col items-center py-20">
        <!-- Logo and Header -->
        <div class="flex flex-col items-center mb-10">
            <h1 class="relative text-6xl md:text-7xl font-black tracking-tight text-transparent bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 bg-clip-text drop-shadow-lg select-none">
                Tasklify
                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-2/3 h-3 blur-xl opacity-60 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-700 pointer-events-none"></span>
            </h1>
        </div>
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg mt-6 flex flex-col">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Take Control of Your Tasks</h2>
            <div x-data="{ height: 0 }" x-init="height = window.innerHeight; window.addEventListener('resize', () => height = window.innerHeight)">
                <div x-show="height >= 720" class="space-y-3 w-full">
                    <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm" id="item-1">
                        <span class="text-orange-500 font-bold text-lg mr-2">1.</span>
                        <span class="text-gray-700">Organize your tasks</span>
                    </div>
                    <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm" id="item-2">
                        <span class="text-orange-500 font-bold text-lg mr-2">2.</span>
                        <span class="text-gray-700">Set priorities</span>
                    </div>
                    <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm" id="item-3">
                        <span class="text-orange-500 font-bold text-lg mr-2">3.</span>
                        <span class="text-gray-700">Track progress</span>
                    </div>
                    <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm" id="item-4">
                        <span class="text-orange-500 font-bold text-lg mr-2">4.</span>
                        <span class="text-gray-700">Achieve your goals</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="flex-1 px-8 py-3 bg-orange-500 text-white rounded-lg shadow-lg hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-500 transition-transform transform hover:scale-105 text-lg font-semibold">Get Started</a>
                <a href="{{ route('login') }}" class="flex-1 px-8 py-3 bg-white text-orange-500 border-2 border-orange-500 rounded-lg shadow-lg hover:text-orange-600 hover:border-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-500 transition-transform transform hover:scale-105 text-lg font-semibold">Log in</a>
            </div>
        </div>
    </div>
</body>
</html>
