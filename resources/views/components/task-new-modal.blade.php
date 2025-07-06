<div>
    <x-modal name="new-task-modal" :show="false">
        <!-- Modal Header -->
        <x-modal-header title="Create New Task" x-data="{ addModalNameToWindow() { window.currentModalName = 'new-task-modal'; } }" x-init="addModalNameToWindow()">
            <x-slot name="button">
                <button
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'new-task-modal' }))"
                    class="text-black hover:text-gray-700 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </x-slot>
        </x-modal-header>

        <!-- Modal Content -->
        <form
            method="POST"
            class="space-y-6 bg-white p-6 rounded-b-lg shadow-md border border-gray-200"
            @submit.prevent="submitForm"
            x-data="{ title: '', description: '', dueDate: '', priority: 'low', submitForm() { const formData = { title: this.title, description: this.description, due_date: this.dueDate, priority: this.priority, user_id: 9, status: 'to-do', }; fetch('/api/tasks', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '' }, body: JSON.stringify(formData) }) .then(async response => { if (!response.ok) { const error = await response.text(); console.error('Error creating task:', error); console.error('Failed to create task. Status:', response.status); return; } return response.json(); }) .then(data => { console.log('Task created:', data); this.title = ''; this.description = ''; this.dueDate = ''; this.priority = 'low'; window.dispatchEvent(new CustomEvent('close-modal', { detail: 'new-task-modal' })); window.dispatchEvent(new CustomEvent('fetch-tasks')); }) .catch(error => console.error('Error creating task:', error)); } }"
        >
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        x-model="title"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                        placeholder="Enter task title"
                        required
                    />
                </div>

                <div>
                    <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input
                        type="date"
                        id="dueDate"
                        name="dueDate"
                        x-model="dueDate"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                        required
                    />
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea
                    id="description"
                    name="description"
                    x-model="description"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                    placeholder="Enter task description"
                ></textarea>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select
                    id="priority"
                    name="priority"
                    x-model="priority"
                    required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                >
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex bg-orange-500 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-600 transition font-semibold"
                >
                    Create Task
                </button>
            </div>
        </form>
    </x-modal>
</div>
