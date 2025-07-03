<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Tasklify | Register</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   @vite('resources/css/app.css')
   <script defer src="//unpkg.com/alpinejs"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
   <div class="w-full max-w-5xl bg-white rounded-lg shadow-lg overflow-hidden">
       <div class="grid grid-cols-1 md:grid-cols-2">
           <!-- Left Section -->
           <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-8 flex flex-col justify-center items-center shadow-lg">
               <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-sm flex flex-col items-center">
                   <x-application-logo class="w-20 h-20 mb-4" />
                   <h3 class="text-xl font-bold text-center mb-4 text-gray-800">Why Tasklify?</h3>
                   <div class="space-y-3 w-full">
                       <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                           <span class="text-orange-500 font-bold text-lg mr-2">1.</span>
                           <span class="text-gray-700">Organize your tasks</span>
                       </div>
                       <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                           <span class="text-orange-500 font-bold text-lg mr-2">2.</span>
                           <span class="text-gray-700">Set priorities</span>
                       </div>
                       <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                           <span class="text-orange-500 font-bold text-lg mr-2">3.</span>
                           <span class="text-gray-700">Track progress</span>
                       </div>
                       <div class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                           <span class="text-orange-500 font-bold text-lg mr-2">4.</span>
                           <span class="text-gray-700">Achieve your goals</span>
                       </div>
                   </div>
               </div>
           </div>


           <!-- Right Section -->
           <div class="p-8">
               <h2 class="text-2xl font-semibold text-gray-700 mb-6">Create your account</h2>
               <form method="POST" action="{{ route('register') }}">
                   @csrf
                   <div class="grid grid-cols-1 gap-4">
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


                   <div class="flex items-center justify-between mt-6">
                       <a href="{{ route('login') }}" class="text-sm text-orange-500 hover:text-orange-600">Already registered?</a>
                       <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-md shadow-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500">Register</button>
                   </div>
               </form>
           </div>
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
</body>
</html>
