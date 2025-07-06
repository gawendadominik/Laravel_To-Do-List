<div x-data="{}" class="flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Your tasks</h2>
    <a
        x-on:click="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'new-task-modal' }))"
        class="inline-flex bg-orange-500 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition items-center gap-2 cursor-pointer"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Task
    </a>
</div>
