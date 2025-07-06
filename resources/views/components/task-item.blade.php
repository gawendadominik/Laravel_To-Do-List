<script>
    document.addEventListener('alpine:init', () => {
    Alpine.store('currentTask', { task: window.currentTask });
});

</script>
<div
    x-data="{
        task: window.currentTask,
        editMode: false,
        taskId: null,
        updateTaskStatus(task) {
            const statuses = ['to-do', 'in progress', 'done'];
            const currentIndex = statuses.indexOf(task.status);
            const nextIndex = (currentIndex + 1) % statuses.length;
            task.status = statuses[nextIndex];

            fetch(`/api/tasks/${task.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ status: task.status })
            })
            .then((response) => response.json())
            .then((data) => {
                console.log('Task updated:', data);
                this.fetchTasks();
            })
            .catch((error) => console.error('Error updating task:', error));
        },
        init() {
            console.log('Initializing task edit modal');
            window.addEventListener('open-details-modal', (event) => {
                console.log('Event payload:', event.detail);
                if (event.detail && event.detail.task) {
                    this.taskId = event.detail.task.id;
                    console.log('Task ID updated:', this.taskId);
                } else {
                    console.error('Invalid event payload. Task object is missing.');
                }
            });
        },
    }"
    x-init="init()"
>
    <div
        class="flex justify-between mb-1 hover:bg-gray-50 transition-colors rounded-lg p-3"
        :class="{ 'opacity-50': task.status === 'done' }"
    >
        <div class="flex items-center gap-7">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    class="hidden"
                    @change="updateTaskStatus(task)"
                >
                <div class="relative">
                    <span class="w-5 h-5 flex items-center justify-center border-2 border-orange-500 rounded-full cursor-pointer">
                        <template x-if="task.status === 'to-do'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V6m-7 7l7-7 7 7" />
                            </svg>
                        </template>
                        <template x-if="task.status === 'in progress'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="task.status === 'done'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </template>
                    </span>
                </div>
            </label>
            <div class="ml-4">
                <a

                    x-on:click="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-task-modal' }))"
                    class="text-base text-gray-800 hover:underline cursor-pointer"
                    :class="{ 'line-through': task.status === 'done' }"
                >
                    <span x-text="task.title"></span>
                </a>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <!-- Task Status Badge -->
            <span class="px-3 py-1 text-sm font-medium rounded-full flex items-center gap-2">
                <span
                    class="px-2 py-1 rounded-full flex items-center justify-center"
                    :class="{
                        'bg-gray-200 text-gray-800': task.status === 'to-do',
                        'bg-yellow-200 text-yellow-800': task.status === 'in progress',
                        'bg-green-200 text-green-800': task.status === 'done'
                    }"
                    x-text="task.status.charAt(0).toUpperCase() + task.status.slice(1)"
                ></span>
            </span>
            <!-- Task Priority Badge -->
            <span class="px-3 py-1 text-sm font-medium rounded-full flex items-center gap-2">
                <span
                    class="px-2 py-1 rounded-full flex items-center justify-center"
                    :class="{
                        'bg-blue-200 text-blue-800': task.priority === 'low',
                        'bg-yellow-400 text-yellow-800': task.priority === 'medium',
                        'bg-red-400 text-red-800': task.priority === 'high'
                    }"
                    x-text="task.priority.charAt(0).toUpperCase() + task.priority.slice(1)"
                ></span>
            </span>
        </div>
    </div>


    {{-- TODO: I cant pass task to modal --}}
    <x-task-edit-modal>
        <x-slot name="formContent">
            <div
            x-data="{
                deleteTask() {
                    if (!this.taskId) {
                        console.error('Task ID is null or undefined. Cannot delete task.');
                        return;
                    }

                    console.log('Deleting task with ID:', this.taskId);

                    fetch(`/api/tasks/${this.taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                        }
                    })
                    .then((response) => {
                        if (!response.ok) {
                            console.error('Failed to delete task. Status:', response.status);
                            return response.text().then((error) => { throw new Error(error); });
                        }
                        return response.json();
                    })
                    .then((data) => {
                        console.log('Task deleted successfully:', data);
                        this.fetchTasks();
                    })
                    .catch((error) => console.error('Error deleting task:', error));

                    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-task-modal' }));
                },
                toggleEditMode() {
                this.editMode = !this.editMode;
                },
            }"
            >
                <form
                    method="POST"
                    class="space-y-6 bg-white p-6 rounded-b-lg shadow-md border border-gray-200"
                    @submit.prevent="submitForm"
                >
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                            <span x-show="!editMode" x-text="task.title" class="text-gray-800"></span>
                            <input
                                x-show="editMode"
                                type="text"
                                id="title"
                                name="title"
                                x-model="task.title"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm text-gray-800"
                                placeholder="Enter task title"
                                required
                            />
                        </div>
                        <div>
                            <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date:</label>
                            <span x-show="!editMode" x-text="task.due_date" class="text-gray-800"></span>
                            <input
                                x-show="editMode"
                                type="date"
                                id="dueDate"
                                name="dueDate"
                                x-model="task.due_date"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm text-gray-800"
                                required
                            />
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                        <span x-show="!editMode" x-text="task.description" class="text-gray-800"></span>
                        <textarea
                            x-show="editMode"
                            id="description"
                            name="description"
                            x-model="task.description"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm text-gray-800"
                            placeholder="Enter task description"
                        ></textarea>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority:</label>
                        <span x-show="!editMode" x-text="task.priority" class="text-gray-800"></span>
                        <select
                            x-show="editMode"
                            id="priority"
                            name="priority"
                            x-model="task.priority"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm text-gray-800"
                        >
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button
                            x-show="editMode"
                            @click.prevent="toggleEditMode()"
                            type="submit"
                            class="inline-flex bg-orange-500 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-600 transition font-semibold"
                        >
                            Save Changes
                        </button>
                        <button
                            x-show="!editMode"
                            @click.prevent="toggleEditMode()"
                            type="button"
                            class="inline-flex bg-orange-500 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-600 transition font-semibold"
                        >
                            Update Task
                        </button>
                        <button
                            @click.prevent="deleteTask()"
                            type="button"
                            class="inline-flex bg-red-500 text-white px-6 py-3 rounded-lg shadow hover:bg-red-600 transition font-semibold"
                        >
                            Delete Task
                        </button>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-task-edit-modal>
</div>
