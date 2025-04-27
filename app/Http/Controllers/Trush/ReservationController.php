<?php

namespace App\Http\Controllers;

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

        return view('reservations.index', compact('reservations'));
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

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Store a newly created reservation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|after:now',
            'booking_time' => 'required',
            'end_time' => 'required',
            'guests_number' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Combine date and time for booking_date
        $bookingDate = $validated['booking_date'] . ' ' . $validated['booking_time'];
        $bookingDateTime = Carbon::createFromFormat('Y-m-d H:i', $bookingDate);

        // Combine date and time for end_time
        $endTime = $validated['booking_date'] . ' ' . $validated['end_time'];
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime);

        // Prepare reservation data
        $reservationData = [
            'restaurant_id' => $validated['restaurant_id'],
            'table_id' => $validated['table_id'],
            'booking_date' => $bookingDateTime,
            'end_time' => $endDateTime,
            'guests_number' => $validated['guests_number'],
            'special_requests' => $validated['special_requests'] ?? null,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ];

        // Create the reservation
        $reservation = Reservation::create($reservationData);

        // Load related data for the modal
        $reservation->load(['restaurant', 'table', 'user']);

        // Format dates for display
        $formattedReservation = [
            'id' => $reservation->id,
            'restaurant_name' => $reservation->restaurant->name,
            'table_name' => $reservation->table->name,
            'table_location' => $reservation->table->location,
            'table_capacity' => $reservation->table->capacity,
            'booking_date' => $reservation->booking_date->format('l, F j, Y'),
            'booking_time' => $reservation->booking_date->format('g:i A'),
            'end_time' => $reservation->end_time->format('g:i A'),
            'guests_number' => $reservation->guests_number,
            'special_requests' => $reservation->special_requests,
            'status' => ucfirst($reservation->status),
            'reference_number' => strtoupper(substr(md5($reservation->id), 0, 8))
        ];

        return redirect()->route('restaurants.show', $validated['restaurant_id'])
            ->with('reservation_details', $formattedReservation)
            ->with('show_confirmation_modal', true);
    }

    /**
     * Update the specified reservation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);

        // Only allow updates if the reservation is still pending
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot update a reservation that has been confirmed or cancelled.');
        }

        $validated = $request->validate([
            'booking_date' => 'required|date|after:now',
            'booking_time' => 'required',
            'end_time' => 'required',
            'guests_number' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Combine date and time for booking_date
        $bookingDate = $validated['booking_date'] . ' ' . $validated['booking_time'];
        $bookingDateTime = Carbon::createFromFormat('Y-m-d H:i', $bookingDate);

        // Combine date and time for end_time
        $endTime = $validated['booking_date'] . ' ' . $validated['end_time'];
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime);

        // Update reservation data
        $reservation->update([
            'booking_date' => $bookingDateTime,
            'end_time' => $endDateTime,
            'guests_number' => $validated['guests_number'],
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified reservation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);

        // Only allow cancellation if the reservation is still pending or confirmed
        if ($reservation->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel a completed reservation.');
        }

        // Update status to cancelled instead of deleting
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Display a listing of reservations for restaurant owner.
     *
     * @return \Illuminate\View\View
     */
    public function ownerIndex()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        $reservations = Reservation::whereIn('restaurant_id', $restaurants)
            ->with(['restaurant', 'table', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('restaurant_owner.reservations.index', compact('reservations'));
    }

    /**
     * Update the status of a reservation (for restaurant owners).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $restaurants = Restaurant::where('user_id', Auth::id())->pluck('id');

        $reservation = Reservation::whereIn('restaurant_id', $restaurants)
            ->findOrFail($id);

        $reservation->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }
}
