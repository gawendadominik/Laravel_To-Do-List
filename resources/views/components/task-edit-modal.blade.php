{{-- @props([
    'task' => null,
])

<div x-data="{
    task: @js($task),
    toggleEditMode() {
        this.editMode = !this.editMode;
    },
    editMode: false,
    taskId: null,
    init() {
    console.log('Initializing task edit modal'); // Log initialization
        window.addEventListener('open-details-modal', (event) => {
            this.taskId = event.detail.task.id;
        });
        console.log('Task ID updated:', this.taskId); // Log the updated taskId
    },
}" x-init="init()" >
    <div>
    <x-modal name="edit-task-modal" :show="false">
        <!-- Modal Header -->
        <x-modal-header title="Task Details" x-data="{ addModalNameToWindow() { window.currentModalName = 'edit-task-modal'; } }" x-init="addModalNameToWindow()" />

        <!-- Modal Content -->
        {{-- <form
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
            </div>
        </form>
    </x-modal>
</div>

</div> --}}


<div x-data="{
    task: {
        title: '',
        description: '',
        due_date: '',
        priority: 'low',
        user_id: '',
        status: 'to-do',
    },
    fetchTask() {
        fetch(`/api/tasks/${this.taskId}`)
            .then(response => response.json())
            .then(data => {
                this.task = data;
            })
            .catch(error => console.error('Error fetching task:', error));
    },
    toggleEditMode() {
        this.editMode = !this.editMode;
    },
    editMode: false,
    taskId: null,
    init() {
        console.log('Initializing task edit modal'); // Log initialization
        window.addEventListener('open-details-modal', (event) => {
            this.taskId = event.detail.task.id;
        });
        console.log('Task ID updated:', this.taskId); // Log the updated taskId
    },
}" x-init="init()">
    <x-modal name="edit-task-modal" :show="false">
        <!-- Modal Header -->
        <x-modal-header title="Edit Task" x-data="{ addModalNameToWindow() { window.currentModalName = 'edit-task-modal'; } }" x-init="addModalNameToWindow()">
            <x-slot name="button">
                <button
                    @click="window.location.reload()"
                    class="text-black hover:text-gray-700 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </x-slot>
        </x-modal-header>
        <!-- Modal Content -->
        {{ $formContent }}
    </x-modal>
</div>

