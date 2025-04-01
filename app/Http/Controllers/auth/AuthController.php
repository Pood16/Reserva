<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function handleRegister(Request $request)
    {
        // validate the inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);
        // register the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('login.show')->with('success', 'Registration successful! Please log in.');
    }
    public function handleLogin(Request $request)
    {
        // validate the inputs
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:4',
        ]);
        // authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['attempt' => 'Invalid credentials.']);
        }
        // check the user's role and redirect accordingly
        $user = Auth::user();
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('restaurant.dashboard'),
            'client' => redirect()->route('client.dashboard'),
            default => redirect()->route('welcome'),
        };
    }
    public function handleLogout(Request $request)
    {

        Auth::logout();


        $request->session()->invalidate();


        $request->session()->regenerateToken();

  
        return redirect()->route('login.show')->with('success', 'Logout successful!');
    }
}
