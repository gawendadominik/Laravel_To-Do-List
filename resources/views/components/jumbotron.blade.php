@props(['name' => 'Guest', 'message' => 'Manage your tasks efficiently and stay organized. Create, update, and track your tasks with ease.'])

<div>
    <div x-show="showJumbotron" class="bg-orange-100 p-6 rounded-lg shadow mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-orange-800">
                    Welcome back, {{ $name }}
                </h1>
                <p class="text-orange-700 mt-2">
                    {{ $message }}
                </p>
            </div>
            <button @click="showJumbotron = false" class="text-orange-800 hover:text-orange-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
