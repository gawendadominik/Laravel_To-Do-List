<div
    x-data="{
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
    }"
    class="flex justify-between mb-1 hover:bg-gray-50 transition-colors rounded-lg p-3"
    :class="{ 'opacity-50': task.status === 'done' }"
>
    <div class="flex items-center gap-7">
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" class="hidden" @change="updateTaskStatus(task)">
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
