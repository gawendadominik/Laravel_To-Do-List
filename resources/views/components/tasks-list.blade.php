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
                            <div x-data="{
                                sendTaskToWindow: function() {
                                    const plainTask = JSON.parse(JSON.stringify(task));
                                    window.currentTask = plainTask;
                                    console.log('Task item:', window.currentTask);
                                }
                                }" x-init="sendTaskToWindow()">
                                <x-task-item/>
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
    <x-task-new-modal/>
</div>
