<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations for the manager's restaurants.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all restaurants owned by the current manager
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        // Get all reservations for these restaurants
        $reservations = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('manager.reservations.index', compact('reservations'));
    }

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Get all restaurants owned by the current manager
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        // Find the reservation and make sure it belongs to one of the manager's restaurants
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        return view('manager.reservations.show', compact('reservation'));
    }

    /**
     * Approve a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        // Get all restaurants owned by the current manager
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        // Find the reservation and make sure it belongs to one of the manager's restaurants
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        // Only allow approval if the reservation is pending
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending reservations can be approved.');
        }

        // Update the status to confirmed
        $reservation->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Reservation has been approved.');
    }

    /**
     * Decline a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline($id)
    {
        // Get all restaurants owned by the current manager
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        // Find the reservation and make sure it belongs to one of the manager's restaurants
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        // Only allow declining if the reservation is not already cancelled or completed
        if ($reservation->status === 'cancelled' || $reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot decline a reservation that is already cancelled or completed.');
        }

        // Update the status to cancelled
        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Reservation has been declined.');
    }

    /**
     * Mark a reservation as completed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete($id)
    {
        // Get all restaurants owned by the current manager
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        // Find the reservation and make sure it belongs to one of the manager's restaurants
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        // Only allow completing if the reservation is confirmed
        if ($reservation->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Only confirmed reservations can be marked as completed.');
        }

        // Update the status to completed
        $reservation->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Reservation has been marked as completed.');
    }
}
