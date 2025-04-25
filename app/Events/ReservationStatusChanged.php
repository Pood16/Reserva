<?php

namespace App\Events;

use App\Models\Reservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation;
    public $status;
    public $reason;


    public function __construct($reservation, $status, $reason = null)
    {
        $this->reservation = $reservation;
        $this->status = $status;
        $this->reason = $reason;
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->reservation->user_id),
        ];
    }


    public function broadcastAs(): string
    {
        return 'reservation.status.changed';
    }


    public function broadcastWith(): array
    {
        return [
            'id' => $this->reservation->id,
            'status' => $this->status,
            'restaurant' => $this->reservation->restaurant->name,
            'date' => $this->reservation->booking_date,
            'time' => $this->reservation->booking_time,
            'reason' => $this->reason,
            'message' => $this->getStatusMessage(),
        ];
    }

    private function getStatusMessage(): string
    {
        switch ($this->status) {
            case 'confirmed':
                return 'Your reservation has been confirmed!';
            case 'declined':
                return 'Your reservation has been declined' . ($this->reason ? ': ' . $this->reason : '');
            case 'cancelled':
                return 'Your reservation has been cancelled' . ($this->reason ? ': ' . $this->reason : '');
            case 'completed':
                return 'Your reservation has been marked as completed.';
            default:
                return 'Your reservation status has been updated to ' . $this->status;
        }
    }
}
