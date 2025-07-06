<div>
    <!-- Jumbotron Component -->

    {{-- <div x-data="{ showJumbotron: true }">
        <x-jumbotron
            x-show="showJumbotron"
            :name=" auth()->user()->name "
            :message="'Here you can manage your tasks efficiently.'"
            @close-jumbotron.window="showJumbotron = false"
        />
    </div> --}}

    <!-- Tasks List -->
    <div
        class="bg-white shadow rounded-lg p-6 flex flex-col gap-4 overflow-y-auto"
        style="max-height: calc(100vh - 200px);"
         x-data="{
        tasks: [],
        groupedTasks: {},
        originalGroupedTasks: {}, // Store original data for 'no sort'
        showAllTasks: false,
        prioritySortOrder: 'none', // 'none', 'low', 'high'
        statusSortOrder: 'none',
        fetchTasks() {
            fetch('/api/tasks')
                .then((response) => response.json())
                .then((data) => {
                    if (typeof data === 'object' && !Array.isArray(data)) {
                        // Deep copy to preserve original order
                        this.originalGroupedTasks = JSON.parse(JSON.stringify(data));
                        this.groupedTasks = JSON.parse(JSON.stringify(data));
                    } else {
                        this.originalGroupedTasks = {};
                        this.groupedTasks = {};
                    }
                })
                .catch((error) => console.error('Error fetching tasks:', error));
        },
        filteredGroupedTasks() {
    const priorityIndexes = { high: 3, medium: 2, low: 1 };
    const statusIndexesTodoDone = { 'to-do': 1, 'in progress': 2, 'done': 3 };
    const statusIndexesDoneTodo = { 'to-do': 3, 'in progress': 2, 'done': 1 };
    const source = this.originalGroupedTasks;
    const clone = {};

    for (const [dateKey, tasks] of Object.entries(source)) {
        let sortedTasks = tasks.slice();

        // Apply priority sort if needed
        if (this.prioritySortOrder !== 'none') {
            sortedTasks = sortedTasks.sort((a, b) => {
                if (this.prioritySortOrder === 'high') {
                    return priorityIndexes[b.priority] - priorityIndexes[a.priority];
                } else {
                    return priorityIndexes[a.priority] - priorityIndexes[b.priority];
                }
            });
        }

        // Apply status sort if needed
        if (this.statusSortOrder === 'todo-done') {
            sortedTasks = sortedTasks.sort((a, b) => {
                return statusIndexesTodoDone[a.status] - statusIndexesTodoDone[b.status];
            });
        } else if (this.statusSortOrder === 'done-todo') {
            sortedTasks = sortedTasks.sort((a, b) => {
                return statusIndexesDoneTodo[a.status] - statusIndexesDoneTodo[b.status];
            });
        }

        clone[dateKey] = sortedTasks;
    }

    if (this.showAllTasks) {
        return clone;
    }
    return Object.fromEntries(Object.entries(clone).slice(0, 5));
},
        toggleTaskView() {
            this.showAllTasks = !this.showAllTasks;
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

        <!-- SORT CONTROLS -->
<div class="flex gap-2 mb-3 items-center">
    <span class="text-sm font-medium text-gray-600">Sorting:</span>

    <!-- PRIORITY SORT -->
    <button @click="prioritySortOrder = prioritySortOrder === 'none' ? 'low-high' : prioritySortOrder === 'low-high' ? 'high-low' : 'none'" :class="prioritySortOrder === 'none' ? 'border-gray-600 text-gray-700 font-bold' : prioritySortOrder === 'low-high' ? 'border-gray-500 text-gray-600 font-bold' : 'border-gray-600 text-gray-700 font-bold'" class="px-1.5 py-0.5 rounded-md shadow border hover:bg-gray-100 transition text-xs min-w-[120px] whitespace-nowrap">
        Priority: <span x-text="prioritySortOrder === 'none' ? 'None' : prioritySortOrder === 'low-high' ? 'Low → High' : 'High → Low'"></span>
    </button>

    <!-- STATUS SORT -->
    <button @click="statusSortOrder = statusSortOrder === 'none' ? 'todo-done' : statusSortOrder === 'todo-done' ? 'done-todo' : 'none'" :class="statusSortOrder === 'none' ? 'border-gray-600 text-gray-700 font-bold' : statusSortOrder === 'todo-done' ? 'border-gray-500 text-gray-600 font-bold' : 'border-gray-600 text-gray-700 font-bold'" class="px-1.5 py-0.5 rounded-md shadow border hover:bg-gray-100 transition text-xs min-w-[120px] whitespace-nowrap">
        Status: <span x-text="statusSortOrder === 'none' ? 'None' : statusSortOrder === 'todo-done' ? 'To-Do → Done' : 'Done → To-Do'"></span>
    </button>
</div>

        <div>
            <template x-for="(tasks, groupKey) in filteredGroupedTasks()" :key="groupKey">

                <x-accordion x-data="{ open: taskGroupKeyModifier(groupKey) === 'Today'}">
                    <x-slot name="header">
                        <div>
                            <span class="text-lg font-medium text-gray-600 mr-1">Tasks for:</span>
                            <span class="text-lg font-medium text-orange-600" x-text="taskGroupKeyModifier(groupKey)"></span>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <template x-for="task in tasks" :key="task.id">
                            <!-- Task Item Component -->
                            <div x-data="{
                                sendTaskToWindow: function() {
                                    const plainTask = JSON.parse(JSON.stringify(task));
                                    window.currentTask = plainTask;
                                    {{-- console.log('Task item:', window.currentTask); --}}
                                }
                                }" x-init="sendTaskToWindow()">
                                <x-task-item/>
                            </div>
                        </template>
                    </x-slot>
                </x-accordion>
            </template>
        </div>

        <!-- Load More / Show Less Button Component -->
        <div class="text-center mt-4">
            <button
                @click="toggleTaskView"
                x-show="!showAllTasks"
                class="text-orange-500 border border-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100 transition"
            >
                Load More Tasks
            </button>
            <button
                @click="toggleTaskView"
                x-show="showAllTasks"
                class="text-orange-500 border border-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100 transition"
            >
                Show Less Tasks
            </button>
        </div>
    </div>

    <!-- New Task Modal Component -->
    <x-task-new-modal/>
</div>
