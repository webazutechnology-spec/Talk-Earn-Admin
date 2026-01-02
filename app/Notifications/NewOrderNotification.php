<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    // 1. Define properties to hold the dynamic data
    public $title;
    public $message;
    public $link;
    public $icon;

    /**
     * Create a new notification instance.
     * We pass the dynamic values here.
     */
    public function __construct($title, $message, $link, $icon)
    {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->icon = $icon;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // 2. Use the properties we set in the constructor
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'icon'    => $this->icon,
            'link'    => $this->link,
        ];
    }
}