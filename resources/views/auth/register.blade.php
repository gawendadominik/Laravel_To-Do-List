<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Tasklify | Register</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   @vite('resources/css/app.css')
   <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 overflow-hidden">
   <div x-data="{ height: window.innerHeight }" x-init="window.addEventListener('resize', () => height = window.innerHeight)" class="w-full flex flex-col items-center" :class="height < 720 ? 'py-2' : 'py-20'">
       <!-- Logo and Header -->
       <div class="flex flex-col items-center mb-6">
           <div class="text-center mb-10">
               <x-application-logo class="w-20 h-20 mb-4" />
               <h2 class="text-xl font-medium text-gray-700 mt-4">Create your account</h2>
           </div>
       </div>
       <form method="POST" action="{{ route('register') }}" class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
           @csrf
           <div class="space-y-4">
               <!-- Name -->
               <div>
                   <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                   <input id="name" type="text" name="name" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autofocus autocomplete="name">
                   @error('name')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>

               <!-- Email Address -->
               <div>
                   <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                   <input id="email" type="email" name="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autocomplete="username">
                   @error('email')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>

               <!-- Password -->
               <div>
                   <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                   <input id="password" type="password" name="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autocomplete="new-password">
                   @error('password')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>

               <!-- Confirm Password -->
               <div>
                   <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                   <input id="password_confirmation" type="password" name="password_confirmation" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required autocomplete="new-password">
                   @error('password_confirmation')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>
           </div>
           <div class="mt-6">
               <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                   Register
               </button>
           </div>
           <div class="mt-4 text-center">
               <p class="text-sm text-gray-700">Already registered? <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600">Log in</a></p>
           </div>
       </form>
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
</body>
</html>
