<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BanUnbanManager extends Notification
{
    use Queueable;

    protected $action;



    public function __construct($action)
    {
        $this->action = $action;
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


    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Hello ' . $notifiable->name);

        if ($this->action === 'ban') {
            $mailMessage->line('Your restaurant manager account has been suspended.')
                ->line('Your restaurants have been deactivated temporarily.')
                ->line('If you believe this is a mistake, please contact our support team.');
        } else {
            $mailMessage->line('Your restaurant manager account has been reinstated.')
                ->line('Your restaurants have been reactivated and are now visible to customers.')
                ->line('Thank you for your cooperation.');
        }


        return $mailMessage->salutation('Regards, QuickTable Team');
    }


    public function toArray(object $notifiable): array
    {
        return [
            'action' => $this->action,
            'message' => $this->action === 'ban'
                ? 'Your manager account has been suspended'
                : 'Your manager account has been reinstated',
            'timestamp' => now()->toIso8601String()
        ];
    }


    protected function getSubject(): string
    {
        return $this->action === 'ban'
            ? 'Your Restaurant Manager Account Has Been Suspended'
            : 'Your Restaurant Manager Account Has Been Reinstated';
    }
}
