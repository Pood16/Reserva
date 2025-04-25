<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with(['restaurant', 'table'])
            ->orderBy('booking_date', 'desc')
            ->get();

        // Group reservations by status
        $groupedReservations = [
            'upcoming' => $reservations->filter(function($reservation) {
                return in_array($reservation->status, ['confirmed', 'pending']) &&
                       $reservation->booking_date > Carbon::now();
            }),
            'past' => $reservations->filter(function($reservation) {
                return $reservation->status === 'completed' ||
                       $reservation->booking_date < Carbon::now();
            }),
            'cancelled' => $reservations->filter(function($reservation) {
                return $reservation->status === 'cancelled';
            })
        ];

        return view('client.reservations.index', compact('groupedReservations'));
    }

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $reservation = Reservation::with(['restaurant', 'table'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('client.reservations.show', compact('reservation'));
    }

    /**
     * Cancel a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);

        // Only allow cancellation if the reservation is still pending or confirmed
        if ($reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel a completed reservation.');
        }

        // Update status to cancelled
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('client.reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Show reservation history
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $completedReservations = Reservation::where('user_id', Auth::id())
            ->where(function($query) {
                $query->where('status', 'completed')
                    ->orWhere('booking_date', '<', Carbon::now());
            })
            ->with(['restaurant', 'table'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('client.reservations.history', compact('completedReservations'));
    }
}
