<div x-data="{ showJumbotron: true }">
    <!-- Jumbotron -->
    <div x-show="showJumbotron" class="bg-orange-100 p-6 rounded-lg shadow mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-orange-800">
                    Welcome back, {{ auth()->user()->name }}
                </h1>
                <p class="text-orange-700 mt-2">
                    Manage your tasks efficiently and stay organized. Create, update, and track your tasks with ease.
                </p>
            </div>
            <button @click="showJumbotron = false" class="text-orange-800 hover:text-orange-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
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
            },
        }"
        x-init="fetchTasks()"
    >
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Your tasks</h2>
            <a
                href="/tasks/create"
                class="inline-flex bg-orange-500 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Task
            </a>
        </div>

        <!-- Grouped Tasks Section -->
        <div>
            <template x-for="(tasks, groupKey) in filteredGroupedTasks()" :key="groupKey">
                <div x-data="{ open: taskGroupKeyModifier(groupKey) === 'Today' }" class="mb-4">
                    <button
                        @click="open = !open"
                        class="w-full flex justify-between items-center px-2 py-2 font-semibold focus:outline-none bg-transparent text-gray-800"
                    >
                        <div>
                            <span class="text-lg font-medium text-gray-600 mr-1">Tasks for:</span>
                            <span class="text-lg font-medium text-orange-600" x-text="taskGroupKeyModifier(groupKey)"></span>
                        </div>
                        <svg :class="{'transform rotate-180': open}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-2 p-2 px-4 text-orange-800">
                        <template x-for="task in tasks" :key="task.id">
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
                                        <div x-data="{ showTooltip: false, timer: null }" class="relative">
                                            <span
                                                @mouseenter="timer = setTimeout(() => { showTooltip = true }, 3000)"
                                                @mouseleave="clearTimeout(timer); showTooltip = false"
                                                class="w-5 h-5 flex items-center justify-center border-2 border-orange-500 rounded-full cursor-pointer"
                                            >
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
                                            <div
                                                x-show="showTooltip"
                                                x-transition
                                                class="absolute left-0 translate-x-0 mt-2 max-w-lg h-auto px-4 py-2 text-sm text-white bg-gray-800 rounded shadow-lg"
                                            >
                                                Click to cycle through statuses: To-Do, In Progress, Done.
                                            </div>
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
                        </template>
                    </div>
                    <hr class="border-gray-200 mb-4">
                </div>
            </template>
        </div>

        <!-- Load More Button -->
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
</div>
