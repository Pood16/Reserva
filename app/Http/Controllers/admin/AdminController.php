<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Reservation;
use App\Models\ManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\ManagerRequestNotification;
use App\Notifications\BanUnbanManager;

class AdminController extends Controller
{

    public function dashboard()
    {
        $userCount = User::count();
        $restaurantCount = Restaurant::count();
        $reservationCount = Reservation::count();
        $managerRequestCount = ManagerRequest::count();


        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        $reservationsByStatus = Reservation::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();


        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $statusLabels = array_map('ucfirst', $statuses);

        $statusCounts = [];
        $statusColors = [
            'pending' => '#FCD34D',
            'confirmed' => '#60A5FA',
            'completed' => '#34D399',
            'cancelled' => '#F87171',
            'declined' => '#9CA3AF'
        ];

        $statusBgColors = [];
        $statusBorderColors = [];

        foreach ($statuses as $status) {
            $count = $reservationsByStatus->where('status', $status)->first();
            $statusCounts[] = $count ? $count->count : 0;
            $statusBgColors[] = $statusColors[$status] . 'AA';
            $statusBorderColors[] = $statusColors[$status];
        }

        // Get recent reservations
        $recentReservations = Reservation::with(['restaurant', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $latestUsers = User::latest()->take(5)->get();
        $latestRestaurants = Restaurant::latest()->take(5)->get();
        $latestManagerRequests = ManagerRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'userCount',
            'restaurantCount',
            'reservationCount',
            'managerRequestCount',
            'latestUsers',
            'latestRestaurants',
            'recentReservations',
            'latestManagerRequests',
            'usersByRole',
            'statusLabels',
            'statusCounts',
            'statusBgColors',
            'statusBorderColors'
        ));
    }

    // Manager Request Methods
    public function managerRequestsIndex()
    {
        $managerRequests = ManagerRequest::get();
        return view('admin.manager-requests.index', compact('managerRequests'));
    }

    // Approve request
    public function managerRequestsApprove($id)
    {
        $request = ManagerRequest::findOrFail($id);
        $user = User::where('email', $request->Email)->first();

        if ($user) {
            $user->role = 'manager';
            $user->save();
        }
        $request->status = 'approved';
        $request->save();

        $user->notify(new ManagerRequestNotification($request, 'approved'));

        return redirect()->route('admin.manager-requests.index')
            ->with('success', 'Manager request approved. User has been granted manager privileges and notified.');
    }


    // Reject request
    public function managerRequestsReject($id)
    {
        $request = ManagerRequest::findOrFail($id);
        $user = User::where('email', $request->Email)->first();

        $request->status = 'rejected';
        $request->save();

        $user->notify(new ManagerRequestNotification($request, 'rejected'));

        return redirect()->route('admin.manager-requests.index')
            ->with('success', 'Manager request rejected. The applicant has been notified.');
    }


    public function managerRequestsDestroy($id)
    {
        $request = ManagerRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('admin.manager-requests.index')
            ->with('success', 'Manager request deleted permanently.');
    }


    public function restaurantManagersIndex()
    {
        // active managers
        $activeManagers = User::where('role', 'manager')
            ->withCount('restaurants')
            ->get();

        // banned managers
        $bannedManagers = User::where('role', 'client')
            ->where('is_banned', true)
            ->withCount('restaurants')
            ->get();

        $managers = $activeManagers->concat($bannedManagers);

        return view('admin.restaurant-managers.index', compact('managers'));
    }

    public function restaurantManagersBan($id)
    {
        $manager = User::findOrFail($id);

        if ($manager->role !== 'manager') {
            return redirect()->route('admin.restaurant-managers.index')
                ->with('error', 'User is not a restaurant manager.');
        }

        $manager->role = 'client';
        $manager->is_banned = true;
        $manager->save();

        // Deactivate associated restaurants
        $restaurants = Restaurant::where('user_id', $manager->id)->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->is_active = false;
            $restaurant->save();
        }

        // notify the manager
        $manager->notify(new BanUnbanManager('ban'));

        return redirect()->route('admin.restaurant-managers.index')
            ->with('success', 'Manager has been banned successfully. All their restaurants have been deactivated.');
    }

    public function restaurantManagersUnban($id)
    {
        $user = User::findOrFail($id);

        if (!$user->is_banned) {
            return redirect()->route('admin.restaurant-managers.index')
                ->with('error', 'User is not banned.');
        }


        $user->role = 'manager';
        $user->is_banned = false;
        $user->save();


        $restaurants = Restaurant::where('user_id', $user->id)->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->is_active = true;
            $restaurant->save();
        }

        // notify the manager
        $user->notify(new BanUnbanManager('unban'));

        return redirect()->route('admin.restaurant-managers.index')
            ->with('success', 'Manager has been unbanned successfully. All their restaurants have been reactivated.');
    }

}
