<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasklify | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 overflow-hidden">
    <div class="w-full flex flex-col items-center py-20">
        <!-- Logo and Header -->
        <div class="flex flex-col items-center mb-6">
            <div class="text-center mb-10">
                <h1 class="relative text-6xl md:text-7xl font-black tracking-tight text-transparent bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 bg-clip-text drop-shadow-lg select-none animate-gradient-x">
                    Tasklify
                    <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-2/3 h-3 blur-xl opacity-80 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-700 pointer-events-none animate-pulse"></span>
                </h1>
                <h2 class="text-xl font-medium text-gray-700 mt-4">Log in to your account</h2>
            </div>
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
        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        </style>
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autofocus autocomplete="username">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autocomplete="current-password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-700">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-700 hover:text-gray-900 hover:underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                    Log in
                </button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-700">Don't have an account? <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600">Sign up</a></p>
        </div>
    </div>
</body>
</html>
