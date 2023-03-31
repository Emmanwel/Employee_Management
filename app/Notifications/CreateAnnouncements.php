<?php

namespace App\Notifications;

use App\Models\Announcements;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateAnnouncements extends Notification
{
    use Queueable;

    private Announcements $announcements;

    /**
     * Create a new notification instance.
     */
    public function __construct(Announcements $announcements)
    {
        //
        $this->announcements = $announcements;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->announcements->title)
            ->line($this->announcements->description)
            ->action('Click Here to Login', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
