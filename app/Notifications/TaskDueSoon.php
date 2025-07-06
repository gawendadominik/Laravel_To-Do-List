<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskDueSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    // public function __construct() {}
    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Due Soon: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The following task is due soon:')
            ->line('**Title:** ' . $this->task->title)
            ->line('**Due Date:** ' . $this->task->due_date)
            // ->action('View Task', url('/tasks/' . $this->task->id));
            ->line('Please ensure to complete it on time.');
    }
}
