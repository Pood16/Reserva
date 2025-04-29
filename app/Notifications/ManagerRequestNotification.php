<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ManagerRequest;

class ManagerRequestNotification extends Notification
{
    use Queueable;

    protected $managerRequest;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($managerRequest, string $status)
    {
        $this->managerRequest = $managerRequest;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('QuickTable Manager Request Update')
            ->greeting('Hello ' . $this->managerRequest->FirstName . '!');

        if ($this->status === 'approved') {
            $message->line('Good news! Your request to become a restaurant manager has been approved.')
                ->line('You can now log in to your account using the credentials provided to you via email.')
                ->line('After logging in, you can start managing your restaurants and accepting reservations.')
                ->action('Log In Now', url('/login'));
        } elseif ($this->status === 'rejected') {
            $message->line('We regret to inform you that your request to become a restaurant manager has been rejected.')
                ->line('This could be due to various reasons, including incomplete information or not meeting our current requirements.')
                ->line('You may submit a new request after 30 days if you wish to be reconsidered.')
                ->action('Contact Support', url('/contact'));
        }

        return $message->line('Thank you for using QuickTable!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'manager_request_id' => $this->managerRequest->id,
            'status' => $this->status,
            'message' => $this->status === 'approved'
                ? 'Your request to become a restaurant manager has been approved.'
                : 'Your request to become a restaurant manager has been rejected.'
        ];
    }
}
