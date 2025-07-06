<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class taskDueSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public $tasks;

    public function __construct() {}
    // public function __construct($usertasks)
    // {
    //     $this->tasks = $usertasks;
    //     // dd($usertasks);
    // }

    public function via($notifiable)
    {
        return ['mail'];
    }

    // public function toMail($notifiable)
    // {
    //     $mailMessage = (new MailMessage)
    //         ->subject('Tasks Due Soon')
    //         ->greeting('Hello ' . $notifiable->name . ',')
    //         ->line('The following tasks are due soon:');

    //     foreach ($this->tasks as $task) {
    //         $mailMessage->line('**Title:** ' . $task['title'])
    //             ->line('**Due Date:** ' . $task['due_date']);
    //     }

    //     $mailMessage->line('Please ensure to complete them on time.');

    //     return $mailMessage;
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tasks Due Soon')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have tasks due soon. Please check your task list.')
            ->line('Ensure to complete them on time.');
    }
}
