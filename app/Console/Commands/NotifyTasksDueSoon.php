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

        // $tasks = Tasks::whereDate('due_date', $tomorrow)
        //     ->where('notified_due_soon', false)
        //     ->with('user')
        //     ->get();

        $tasks = Tasks::where('notified_due_soon', false)
            ->whereDate('due_date', $tomorrow)
            ->get();

        foreach ($tasks as $task) {
            $user = User::find($task->user_id);
            if ($user) {
                // $task->user->notify(new \App\Notifications\TaskDueSoon($task));
                // $task->notified_due_soon = true;
                // $task->save();
                // Log::info("Notified user {$task->user->email} about task {$task->id}");
                $user->notify(new \App\Notifications\TaskDueSoon($task));
            }
        }

        // $user = \App\Models\User::first();
        // $user->notify(new \App\Notifications\TaskDueSoon());

        $this->info('Notifications sent.');
    }
}
