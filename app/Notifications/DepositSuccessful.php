<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepositSuccessful extends Notification
{
    use Queueable;

    protected $amount;

    /**
     * Create a new notification instance.
     */
    public function __construct($amount)
    {
        //
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/dashboard');
        return (new MailMessage)
            ->greeting('Hello,')
            ->line('Your deposit of ' . $this->amount . ' was successful.')
            ->action('View dashboard', url('/dashboard'))
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
            'data' => ' Your deposit of ' . $this->amount . ' was successful'
        ];
    }
}