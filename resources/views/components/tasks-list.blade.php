<div>
    <!-- Jumbotron Component -->

    <div x-data="{ showJumbotron: true }">
        <x-jumbotron
            x-show="showJumbotron"
            :name=" auth()->user()->name "
            :message="'Here you can manage your tasks efficiently.'"
            @close-jumbotron.window="showJumbotron = false"
        />
    </div>

    <!-- Tasks List -->
    <div
        class="bg-white shadow rounded-lg p-6 flex flex-col gap-4"
        x-data="{
            tasks: [],
            groupedTasks: {},
            showAllTasks: false,
            fetchTasks() {
                fetch('/api/tasks')
                    .then((response) => response.json())
                    .then((data) => {
                        console.log('Fetched tasks:', data);
                        if (typeof data === 'object' && !Array.isArray(data)) {
                            this.groupedTasks = data;
                        } else {
                            console.error('Invalid API response format:', data);
                            this.groupedTasks = {};
                        }
                    })
                    .catch((error) => console.error('Error fetching tasks:', error));
            },
            filteredGroupedTasks() {
                if (this.showAllTasks) {
                    return this.groupedTasks;
                }
                const today = new Date();
                const sevenDaysLater = new Date(today);
                sevenDaysLater.setDate(today.getDate() + 7);
                return Object.fromEntries(
                    Object.entries(this.groupedTasks).filter(([groupKey]) => {
                        const taskDate = new Date(groupKey);
                        return taskDate <= sevenDaysLater;
                    })
                );
            },
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
            taskGroupKeyModifier(groupKey) {
                const today = new Date();
                const taskDate = new Date(groupKey);
                const startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay());
                const endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 6);
                const startOfNextWeek = new Date(endOfWeek);
                startOfNextWeek.setDate(endOfWeek.getDate() + 1);
                const endOfNextWeek = new Date(startOfNextWeek);
                endOfNextWeek.setDate(startOfNextWeek.getDate() + 6);
                if (today.toDateString() === taskDate.toDateString()) {
                    return 'Today';
                } else if (
                    taskDate > today &&
                    taskDate <= endOfWeek
                ) {
                    return 'this ' + taskDate.toLocaleDateString('en-US', { weekday: 'long' });
                } else if (
                    taskDate >= startOfNextWeek &&
                    taskDate <= endOfNextWeek
                ) {
                    return taskDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                } else {
                    return new Date(groupKey).toLocaleDateString('en-US', {
                        weekday: 'short',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                }
            }
        }"
        x-init="fetchTasks(); window.addEventListener('fetch-tasks', () => { fetchTasks(); });"
    >
        <x-task-list-header/>
        <!-- Grouped Tasks Section -->
        <div>
            <template x-for="(tasks, groupKey) in filteredGroupedTasks()" :key="groupKey">

                <x-accordion x-data="{ open: taskGroupKeyModifier(groupKey) === 'Today' }">
                    <x-slot name="header">
                        <div>
                            <span class="text-lg font-medium text-gray-600 mr-1">Tasks for:</span>
                            <span class="text-lg font-medium text-orange-600" x-text="taskGroupKeyModifier(groupKey)"></span>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <template x-for="task in tasks" :key="task.id">
                            <!-- Task Item Component -->
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
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-orange-500"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V6m-7 7l7-7 7 7" />
                                                    </svg>
                                                </template>
                                                <template x-if="task.status === 'in progress'">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-orange-500"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </template>
                                                <template x-if="task.status === 'done'">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-orange-500"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </template>
                                            </span>
                                        </div>
                                    </label>
                                    <div class="ml-4">
                                        <a
                                            :href="`/tasks/${task.id}`"
                                            class="text-base text-gray-800 hover:underline"
                                            :class="{ 'line-through': task.status === 'done' }"
                                        >
                                            <span x-text="task.title"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <!-- Task Status Badge Component -->
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

                                    <!-- Task Priority Badge Component -->
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
                        </template>
                    </x-slot>
                </x-accordion>
            </template>
        </div>

        <!-- Load More Button Component -->
        <div class="text-center mt-4">
            <button
                @click="showAllTasks = true"
                x-show="!showAllTasks"
                class="text-orange-500 border border-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100 transition"
            >
                Load More Tasks
            </button>
        </div>
    </div>

    <!-- New Task Modal Component -->
    <x-modal name="new-task-modal" :show="false">
        <!-- Modal Header -->
        <div class="flex items-center justify-between bg-gradient-to-r from-orange-400 to-orange-600 px-6 py-4 rounded-t-lg shadow">
            <h2 class="text-xl font-bold text-white">Create New Task</h2>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'new-task-modal' }))"
                class="text-white hover:text-gray-200 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

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

    <!-- Edit Task Modal Component -->
    <x-modal name="edit-task-modal" :show="false">
        <!-- Modal Header -->
        <div class="flex items-center justify-between bg-gradient-to-r from-blue-400 to-blue-600 px-6 py-4 rounded-t-lg shadow">
            <h2 class="text-xl font-bold text-white">Edit Task</h2>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-task-modal' }))"
                class="text-white hover:text-gray-200 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <form
            method="POST"
            class="space-y-6 bg-white p-6 rounded-b-lg shadow-md border border-gray-200"
            @submit.prevent="updateTask"
            x-data="{
                taskId: null,
                title: '',
                description: '',
                dueDate: '',
                priority: 'low',
                status: 'to-do',
                fetchTaskDetails(taskId) {
                    fetch(`/api/tasks/${taskId}`)
                        .then(response => response.json())
                        .then(data => {
                            this.taskId = data.id;
                            this.title = data.title;
                            this.description = data.description;
                            this.dueDate = data.due_date.split('T')[0];
                            this.priority = data.priority;
                            this.status = data.status;
                        })
                        .catch(error => console.error('Error fetching task details:', error));
                },
                updateTask() {
                    const formData = {
                        title: this.title,
                        description: this.description,
                        due_date: this.dueDate,
                        priority: this.priority,
                        status: this.status,
                    };

                    fetch(`/api/tasks/${this.taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Task updated:', data);
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-task-modal' }));
                        window.dispatchEvent(new CustomEvent('fetch-tasks'));
                    })
                    .catch(error => console.error('Error updating task:', error));
                }
            }"
        >
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        x-model="title"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
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
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
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
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
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
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition font-semibold"
                >
                    Update Task
                </button>
            </div>
        </form>
    </x-modal>

</div>
