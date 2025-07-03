<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasklify | Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 overflow-hidden">
    <div class="w-full flex flex-col items-center py-20">
        <!-- Logo and Header -->
        <div class="flex flex-col items-center mb-6">
            <div class="text-center mb-10">
                <x-application-logo class="w-20 h-20 mb-4" />
                <h2 class="text-xl font-medium text-gray-700 mt-4">Forgot your password?</h2>
            </div>
        </div>
        <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autofocus autocomplete="username">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Moved instructional note below the form for less visibility but still keeping it informative -->
            <div class="mt-4 text-sm text-gray-600 text-center">
                {{ __('Enter your email address and we will send you a password reset link.') }}
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                    Send
                </button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-700">Remember your password? <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600">Log in</a></p>
        </div>
    </div>
</body>
</html>
