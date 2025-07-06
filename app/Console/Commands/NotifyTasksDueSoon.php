<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifyTasksDueSoon extends Command
{
    protected $signature = 'tasks:notify-due-soon';
    protected $description = 'Notify users about tasks due tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->startOfDay();

        // $tasks = Tasks::where('notified_due_soon', false)
        //     ->whereDate('due_date', $tomorrow)
        //     ->get();

        // foreach ($tasks->toArray() as $task) {
        //     $user = User::find($task['user_id']);
        //     if ($user) {
        //         $user->notify(new \App\Notifications\TaskDueSoon());
        //     }
        // }

        $tasks = Tasks::where('notified_due_soon', false)
            ->whereDate('due_date', $tomorrow)
            ->where('is_deleted', false) // Ensure we only notify for non-deleted tasks
            ->get()->groupBy('user_id');

        foreach ($tasks as $userId => $userTasks) {
            $user = User::find($userId);
            if ($user) {
                // Pass the array of tasks to the notification
                $user->notify(new \App\Notifications\TaskDueSoon($userTasks, $dueDate = $tomorrow));
                $userTasks->each(function ($task) {
                    Tasks::where('id', $task->id)->update(['notified_due_soon' => 1]);
                });
            }
        }

        $this->info('Notifications sent.');
    }
}
