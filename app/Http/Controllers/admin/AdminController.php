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

        // Get data for charts
        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        $reservationsByStatus = Reservation::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Monthly registrations for the last 6 months
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $monthlyRegistrations = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format for Chart.js
        $monthLabels = [];
        $registrationData = [];

        foreach ($monthlyRegistrations as $data) {
            $monthLabels[] = Carbon::createFromDate($data->year, $data->month, 1)->format('M Y');
            $registrationData[] = $data->count;
        }

        $latestUsers = User::latest()->take(5)->get();
        $latestRestaurants = Restaurant::latest()->take(5)->get();
        $latestReservations = Reservation::with(['restaurant', 'user'])
            ->latest()
            ->take(5)
            ->get();
        $latestManagerRequests = ManagerRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'userCount',
            'restaurantCount',
            'reservationCount',
            'managerRequestCount',
            'latestUsers',
            'latestRestaurants',
            'latestReservations',
            'latestManagerRequests',
            'usersByRole',
            'reservationsByStatus',
            'monthLabels',
            'registrationData'
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
