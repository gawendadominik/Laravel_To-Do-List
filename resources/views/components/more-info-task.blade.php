<div x-data="{
    isEditing: false,
    taskData: {},
    fetchTaskData() {
        fetch(`/api/tasks/${this.taskId}`)
            .then(response => response.json())
            .then(data => {
                this.taskData = data;
            })
            .catch(error => console.error('Error fetching task data:', error));
    },
    toggleEditMode() {
        this.isEditing = !this.isEditing;
    },
    deleteTask() {
        fetch(`/api/tasks/${this.taskId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
            }
        })
        .then(response => {
            if (response.ok) {
                window.dispatchEvent(new CustomEvent('fetch-tasks'));
            } else {
                console.error('Failed to delete task');
            }
        })
        .catch(error => console.error('Error deleting task:', error));
    }
}" x-init="fetchTaskData()" :task-id="$props.taskId">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold" x-text="taskData.title"></h3>
        <button @click="toggleEditMode" class="text-blue-500 hover:underline">Edit</button>
    </div>
    <div x-show="isEditing">
        <form @submit.prevent="submitEditForm">
            <input type="text" x-model="taskData.title" class="border rounded p-2 w-full" />
            <textarea x-model="taskData.description" class="border rounded p-2 w-full mt-2"></textarea>
            <input type="date" x-model="taskData.due_date" class="border rounded p-2 w-full mt-2" />
            <select x-model="taskData.priority" class="border rounded p-2 w-full mt-2">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <div class="flex justify-end mt-2">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
                <button type="button" @click="deleteTask" class="bg-red-500 text-white px-4 py-2 rounded ml-2">Delete</button>
            </div>
        </form>
    </div>
    <div x-show="!isEditing">
        <p x-text="taskData.description" class="mt-2"></p>
        <p x-text="taskData.due_date" class="mt-2"></p>
        <p x-text="taskData.priority" class="mt-2"></p>
    </div>
</div>
