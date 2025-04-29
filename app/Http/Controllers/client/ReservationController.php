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



    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with(['restaurant', 'table'])
            ->orderBy('booking_date', 'desc')
            ->get();

        // Group reservations by status
        $groupedReservations = [
            'upcoming' => $reservations->filter(function($reservation) {
                return in_array($reservation->status, ['confirmed', 'pending']) && $reservation->booking_date > Carbon::now();
            }),
            'past' => $reservations->filter(function($reservation) {
                return $reservation->status === 'completed' || $reservation->booking_date < Carbon::now();
            }),
            'cancelled' => $reservations->filter(function($reservation) {
                return $reservation->status === 'cancelled';
            })
        ];

        return view('client.reservations.index', compact('groupedReservations'));
    }


    // specific reservation details
    public function show($id)
    {
        $reservation = Reservation::with(['restaurant', 'table'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('client.reservations.show', compact('reservation'));
    }

    // Cancel a resrvation
    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        if ($reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel a completed reservation.');
        }
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('client.reservations.index')->with('success', 'Reservation cancelled successfully.');
    }
    // reservations history
    public function history()
    {
        $completedReservations = Reservation::where('user_id', Auth::id())
                ->where(function($query) {
                $query->where('status', 'completed')->orWhere('booking_date', '<', Carbon::now());
            })
            ->with(['restaurant', 'table'])
            ->orderBy('booking_date', 'desc')
            ->get();
        return view('client.reservations.history', compact('completedReservations'));
    }

    // Show reservation creation form
    public function create(Request $request)
    {
        $restaurantId = $request->query('restaurant');
        $restaurant = null;
        $openingDays = [];
        $tables = [];
        if ($restaurantId) {
            $restaurant = Restaurant::with(['openingDays', 'tables' => function($q) {
                $q->where('is_active', true)->where('is_available', true);
            }])->findOrFail($restaurantId);
            $openingDays = $restaurant->openingDays->pluck('day_of_week')->toArray();
            $tables = $restaurant->tables;
        }
        return view('client.reservations.create', compact('restaurant', 'openingDays', 'tables'));
    }
}
