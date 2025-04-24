<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservations = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('manager.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->findOrFail($id);

        return view('manager.reservations.show', compact('reservation'));
    }

    public function approve($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending reservations can be approved.');
        }

        $reservation->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Reservation has been approved.');
    }

    public function decline($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        if ($reservation->status === 'cancelled' || $reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot decline a reservation that is already cancelled or completed.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Reservation has been declined.');
    }

    public function complete($id)
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');
        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        if ($reservation->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Only confirmed reservations can be marked as completed.');
        }

        $reservation->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Reservation has been marked as completed.');
    }
}
