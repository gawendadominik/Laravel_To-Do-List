<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasklify | Take Control of Your Day</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">
    @auth
        <script>window.location.href = "{{ url('/tasks') }}";</script>
    @endauth

    <div class="w-full flex flex-col items-center py-20">
        <!-- Logo and Header -->
        <div class="flex flex-col items-center mb-10">
            <h1 class="relative text-6xl md:text-7xl font-black tracking-tight text-transparent bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 bg-clip-text drop-shadow-lg select-none animate-gradient-x">
                Tasklify
                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-2/3 h-3 blur-xl opacity-60 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-700 pointer-events-none"></span>
            </h1>
        </div>
        <style>
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease-in-out infinite;
        }
        </style>
        <div class="relative text-center mb-8 max-w-xl">
            <p class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2 opacity-90">
                Take control of your day!
            </p>
            <p class="text-lg md:text-xl text-gray-600 font-medium opacity-85">
                Effortlessly organize, prioritize, and conquer your tasks.<br>
                Boost your productivity with Taskify – your smart, simple to-do app.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-md justify-center">
            <a href="{{ route('login') }}"
                class="flex-1 px-8 py-3 rounded-lg bg-orange-500 text-white font-semibold border-2 border-orange-500 transition hover:bg-orange-600 text-base text-center shadow-md hover:scale-105 duration-150">
                Log in
            </a>
            <a href="{{ route('register') }}"
                class="flex-1 px-8 py-3 rounded-lg bg-transparent text-orange-500 font-semibold border-2 border-orange-500 transition hover:text-orange-600 hover:border-orange-600 text-base text-center shadow-md hover:scale-105 duration-150">
                Sign up
            </a>
        </div>
    </div>
</body>
</html>
