<div
    x-data="{
        updateTaskStatus(taskId) {
            const statuses = ['to-do', 'in progress', 'done'];
            const taskElement = document.querySelector(`[data-task-id='${taskId}']`);
            const currentStatus = taskElement.dataset.status;
            const currentIndex = statuses.indexOf(currentStatus);
            const nextIndex = (currentIndex + 1) % statuses.length;
            const nextStatus = statuses[nextIndex];

            fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ status: nextStatus })
            })
            .then((response) => response.json())
            .then((data) => {
                console.log('Task updated:', data);
                taskElement.dataset.status = nextStatus;
                taskElement.querySelector('.status-badge').textContent = nextStatus.charAt(0).toUpperCase() + nextStatus.slice(1);
                taskElement.classList.toggle('opacity-50', nextStatus === 'done');
            })
            .catch((error) => console.error('Error updating task:', error));
        },
    }"
    class="flex justify-between mb-1 hover:bg-gray-50 transition-colors rounded-lg p-3 {{ $task['status'] === 'done' ? 'opacity-50' : '' }}"
    data-task-id="{{ $task['id'] }}"
    data-status="{{ $task['status'] }}"
>
    <div class="flex items-center gap-7">
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" class="hidden" @change="updateTaskStatus('{{ $task['id'] }}')">
            <div class="relative">
                <span class="w-5 h-5 flex items-center justify-center border-2 border-orange-500 rounded-full cursor-pointer">
                    @if ($task['status'] === 'to-do')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V6m-7 7l7-7 7 7" />
                        </svg>
                    @elseif ($task['status'] === 'in progress')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif ($task['status'] === 'done')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </span>
            </div>
        </label>
        <div class="ml-4">
            <a href="/tasks/{{ $task['id'] }}" class="text-base text-gray-800 hover:underline {{ $task['status'] === 'done' ? 'line-through' : '' }}">
                {{ $task['title'] }}
            </a>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <span class="px-3 py-1 text-sm font-medium rounded-full flex items-center gap-2">
            <span class="px-2 py-1 rounded-full flex items-center justify-center status-badge {{ $task['status'] === 'to-do' ? 'bg-gray-200 text-gray-800' : ($task['status'] === 'in progress' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800') }}">
                {{ ucfirst($task['status']) }}
            </span>
        </span>
        <span class="px-3 py-1 text-sm font-medium rounded-full flex items-center gap-2">
            <span class="px-2 py-1 rounded-full flex items-center justify-center {{ $task['priority'] === 'low' ? 'bg-blue-200 text-blue-800' : ($task['priority'] === 'medium' ? 'bg-yellow-400 text-yellow-800' : 'bg-red-400 text-red-800') }}">
                {{ ucfirst($task['priority']) }}
            </span>
        </span>
    </div>
</div>
