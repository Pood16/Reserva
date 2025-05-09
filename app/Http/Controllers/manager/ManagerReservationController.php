<?php

namespace App\Http\Controllers\Manager;

use App\Events\ReservationStatusChanged as ReservationStatusChangedEvent;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Notifications\ReservationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerReservationController extends Controller
{
    // list reservations
    public function index()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservations = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();
        return view('manager.reservations.index', compact('reservations'));
    }

    // reservation details
    public function show($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        return view('manager.reservations.show', compact('reservation'));
    }

    // approve reservation
    public function approve($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending reservations can be approved.');
        }

        $reservation->update(['status' => 'confirmed']);

        // notify the user
        $reservation->user->notify(new ReservationStatusChanged($reservation, 'confirmed'));

        return redirect()->back()->with('success', 'Reservation has been approved and customer has been notified.');
    }

    public function decline(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        if ($reservation->status === 'cancelled') {
            return redirect()->back()->with('error', 'Cannot decline a reservation that is already cancelled.');
        }

        if ($reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot decline a reservation that is already completed.');
        }

        $reservation->update([
            'status' => 'cancelled',
            'decline_reason' => $validated['reason']
        ]);

        // Send notification
        $reservation->user->notify(new ReservationStatusChanged(
            $reservation,
            'declined',
            $validated['reason']
        ));

        return redirect()->back()->with('success', 'Reservation has been declined and customer has been notified.');
    }

    public function complete($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        if ($reservation->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Only confirmed reservations can be marked as completed.');
        }

        $reservation->update(['status' => 'completed']);

        $reservation->table->update(['is_available' => true]);

        // Send notification
        $reservation->user->notify(new ReservationStatusChanged($reservation, 'completed'));

        return redirect()->back()->with('success', 'Reservation has been marked as completed and customer has been notified.');
    }
}
