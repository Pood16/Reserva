<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\OpeningDay;
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

    /**
     * Store a newly created reservation in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|date_format:Y-m-d',
            'booking_time' => 'required|date_format:H:i',
            'guests_number' => 'required|integer|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'special_requests' => 'nullable|string',
        ]);

        // Get the restaurant
        $restaurant = Restaurant::with('openingDays')->findOrFail($request->restaurant_id);

        // Get the selected table
        $table = Table::where('id', $request->table_id)
            ->where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->where('is_available', true)
            ->firstOrFail();

        // Verify the table has sufficient capacity
        if ($table->capacity < $request->guests_number) {
            return redirect()->back()->with('error', 'The selected table does not have enough capacity for your party size.');
        }

        // Combine booking date and time
        $bookingDateTime = Carbon::parse($request->booking_date . ' ' . $request->booking_time);

        // Check if the date is not in the past
        if ($bookingDateTime->isPast()) {
            return redirect()->back()->with('error', 'Cannot make reservations for past dates and times.');
        }

        // Check if the restaurant is open on the selected day
        $dayOfWeek = $bookingDateTime->format('l'); // Returns day name (e.g., "Monday")
        $isOpenOnDay = $restaurant->openingDays->contains('day_of_week', $dayOfWeek);

        if (!$isOpenOnDay) {
            return redirect()->back()->with('error', 'The restaurant is closed on ' . $dayOfWeek . 's.');
        }

        // Check if the booking time is within restaurant operating hours
        $openingTime = $restaurant->opening_time ? Carbon::parse($bookingDateTime->format('Y-m-d') . ' ' . $restaurant->opening_time->format('H:i')) : null;
        $closingTime = $restaurant->closing_time ? Carbon::parse($bookingDateTime->format('Y-m-d') . ' ' . $restaurant->closing_time->format('H:i')) : null;

        if ($openingTime && $closingTime) {
            if ($bookingDateTime < $openingTime || $bookingDateTime > $closingTime) {
                return redirect()->back()->with('error', 'The reservation time must be during the restaurant\'s opening hours.');
            }
        }

        // Set end time to 2 hours after booking time
        $endTime = (clone $bookingDateTime)->addHours(2);

        // Check if table is already booked for the requested time
        $overlappingReservations = Reservation::where('table_id', $table->id)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($bookingDateTime, $endTime) {
                $query->where(function($q) use ($bookingDateTime, $endTime) {
                    // Booking starts during another reservation
                    $q->where('booking_date', '<=', $bookingDateTime)
                      ->where('end_time', '>', $bookingDateTime);
                })->orWhere(function($q) use ($bookingDateTime, $endTime) {
                    // Booking ends during another reservation
                    $q->where('booking_date', '<', $endTime)
                      ->where('booking_date', '>=', $bookingDateTime);
                });
            })
            ->count();

        if ($overlappingReservations > 0) {
            return redirect()->back()->with('error', 'This table is already booked during the selected time. Please choose another table or time.');
        }

        // Create the reservation
        $reservation = new Reservation();
        $reservation->restaurant_id = $restaurant->id;
        $reservation->table_id = $table->id;
        $reservation->user_id = Auth::id();
        $reservation->booking_date = $bookingDateTime;
        $reservation->end_time = $endTime;
        $reservation->guests_number = $request->guests_number;
        $reservation->special_requests = $request->special_requests;
        $reservation->status = 'pending';
        $reservation->save();

        // Update table availability
        $table->update(['is_available' => false]);

        // Success! Redirect to the reservation details page
        return redirect()->route('client.reservations.show', $reservation->id)
            ->with('success', 'Your reservation has been submitted and is pending confirmation.');
    }
}
