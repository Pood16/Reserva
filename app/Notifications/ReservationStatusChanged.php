<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ReservationStatusChanged extends Notification implements ShouldQueue
{

    use Queueable;

    protected $reservation;
    protected $status;
    protected $reason;

    public function __construct($reservation, $status, $reason = null)
    {
        $this->reservation = $reservation;
        $this->status = $status;
        $this->reason = $reason;
    }


    public function via(object $notifiable): array
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("Reservation Status Update - {$this->reservation->restaurant->name}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your reservation at {$this->reservation->restaurant->name} has been {$this->status}.")
            ->line(new HtmlString('<strong>Reservation Details:</strong>'))
            ->line("Restaurant: {$this->reservation->restaurant->name}")
            ->line("Date: {$this->reservation->booking_date->format('l, F j, Y')}")
            ->line("Time: {$this->reservation->booking_date->format('g:i A')} - {$this->reservation->end_time->format('g:i A')}")
            ->line("Number of Guests: {$this->reservation->guests_number}")
            ->line("Table: {$this->reservation->table->name}");


        switch ($this->status) {
            case 'confirmed':
                $message->line("We're excited to welcome you!")
                    ->line("Please arrive on time. If you need to make any changes to your reservation, please contact us at least 2 hours before your booking time.")
                    ->line(new HtmlString("<strong>Restaurant Address:</strong> {$this->reservation->restaurant->address}, {$this->reservation->restaurant->city}"))
                    ->action('View Reservation', url("/reservations/{$this->reservation->id}"));
                break;

            case 'declined':
                $message->line("We regret to inform you that your reservation could not be accommodated.")
                    ->line(new HtmlString("<strong>Reason for Decline:</strong>"))
                    ->line($this->reason)
                    ->line("We apologize for any inconvenience caused.")
                    ->action('Make New Reservation', url("/restaurants/{$this->reservation->restaurant_id}"));
                break;

            case 'completed':
                $message->line("Thank you for dining with us!")
                    ->line("We hope you enjoyed your experience at {$this->reservation->restaurant->name}.")
                    ->line("We would love to hear your feedback and hope to serve you again soon.")
                    ->action('Make New Reservation', url("/restaurants/{$this->reservation->restaurant_id}"));
                break;

            case 'cancelled':
                $message->line("Your reservation has been cancelled as requested.")
                    ->line("You can make a new reservation at any time through our website.")
                    ->action('Make New Reservation', url("/restaurants/{$this->reservation->restaurant_id}"));
                break;
        }

        return $message;
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'reservation_id' => $this->reservation->id,
            'status' => $this->status,
            'restaurant' => [
                'id' => $this->reservation->restaurant->id,
                'name' => $this->reservation->restaurant->name,
                'address' => $this->reservation->restaurant->address,
                'city' => $this->reservation->restaurant->city,
            ],
            'booking_date' => $this->reservation->booking_date->format('l, F j, Y'),
            'booking_time' => $this->reservation->booking_date->format('g:i A'),
            'end_time' => $this->reservation->end_time->format('g:i A'),
            'guests_number' => $this->reservation->guests_number,
            'reason' => $this->reason,
            'message' => $this->getStatusMessage(),
            'created_at' => now()->toISOString(),
        ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'status' => $this->status,
            'restaurant_id' => $this->reservation->restaurant->id,
            'restaurant_name' => $this->reservation->restaurant->name,
            'booking_date' => $this->reservation->booking_date->format('l, F j, Y'),
            'booking_time' => $this->reservation->booking_date->format('g:i A'),
            'end_time' => $this->reservation->end_time->format('g:i A'),
            'guests_number' => $this->reservation->guests_number,
            'reason' => $this->reason,
            'message' => $this->getStatusMessage(),
        ];
    }

    protected function getStatusMessage(): string
    {
        switch ($this->status) {
            case 'confirmed':
                return "Your reservation at {$this->reservation->restaurant->name} has been confirmed! We look forward to serving you.";

            case 'declined':
                return "Your reservation at {$this->reservation->restaurant->name} could not be accommodated.";

            case 'completed':
                return "Thank you for dining at {$this->reservation->restaurant->name}! We hope you enjoyed your experience.";

            case 'cancelled':
                return "Your reservation at {$this->reservation->restaurant->name} has been cancelled.";

            default:
                return "Your reservation status at {$this->reservation->restaurant->name} has been updated to {$this->status}.";
        }
    }
}
