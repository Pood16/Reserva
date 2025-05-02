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

        // Get recent reservations with relations
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
        $managerRequests = ManagerRequest::latest()->get();
        return view('admin.manager-requests.index', compact('managerRequests'));
    }

    public function managerRequestsApprove($id)
    {
        $request = ManagerRequest::findOrFail($id);
        $user = User::where('email', $request->Email)->first();

        if ($user) {
            $user->role = 'manager';
            $user->save();
        } else {
            // Create new user if they don't exist
            $user = User::create([
                'name' => $request->Name,
                'email' => $request->Email,
                'password' => Hash::make('password 123'),
                'role' => 'manager',
            ]);
        }

        $request->status = 'approved';
        $request->save();

        // Notify the user
        $user->notify(new ManagerRequestNotification($request, 'approved'));

        return redirect()->route('admin.manager-requests.index')
            ->with('success', 'Manager request approved. User has been granted manager privileges and notified.');
    }

    public function managerRequestsReject($id)
    {
        $request = ManagerRequest::findOrFail($id);


        $user = User::where('email', $request->Email)->first();


        $request->status = 'rejected';
        $request->save();

        // Send email notification to the request email
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

    // Restaurant Managers Specific Methods
    public function restaurantManagersIndex()
    {
        $managers = User::where('role', 'manager')
            ->withCount('restaurants')
            ->get();

        return view('admin.restaurant-managers.index', compact('managers'));
    }

    public function restaurantManagersBan($id)
    {
        $manager = User::findOrFail($id);

        if ($manager->role !== 'manager') {
            return redirect()->route('admin.restaurant-managers.index')
                ->with('error', 'User is not a restaurant manager.');
        }

        // Change role to client
        $manager->role = 'client';
        $manager->is_banned = true;
        $manager->save();

        // Deactivate all associated restaurants
        $restaurants = Restaurant::where('user_id', $manager->id)->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->is_active = false;
            $restaurant->save();
        }

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

        // Restore manager role
        $user->role = 'manager';
        $user->is_banned = false;
        $user->save();

        // Reactivate all associated restaurants
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->is_active = true;
            $restaurant->save();
        }

        return redirect()->route('admin.restaurant-managers.index')
            ->with('success', 'Manager has been unbanned successfully. All their restaurants have been reactivated.');
    }

    // User Management Methods
    public function userIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }


    public function userCreate()
    {
        return view('admin.users.create');
    }


    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,client',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }


    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,client',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting oneself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Handle associated data or use cascade delete in migration
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }


    public function restaurantIndex()
    {
        $restaurants = Restaurant::with('user')->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function restaurantEdit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $managers = User::where('role', 'manager')->get();

        return view('admin.restaurants.edit', compact('restaurant', 'managers'));
    }


    public function restaurantUpdate(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'opening_days' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Handle cover image if uploaded
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('restaurants', 'public');
            $validated['cover_image'] = $path;
        }

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant updated successfully.');
    }


    public function restaurantDestroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Handle or check related data before deletion
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant deleted successfully.');
    }


    public function settings()
    {
        // Get settings from configuration or database
        $settings = [
            'site_name' => config('app.name'),
            'contact_email' => config('mail.from.address', 'contact@example.com'),

        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
        ]);



        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
}
