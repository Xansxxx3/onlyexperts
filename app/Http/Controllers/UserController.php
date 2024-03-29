<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the user's input
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'subscriptionType' => 'nullable|string|max:255',
            'accttype' => 'nullable|string|max:255',
        ]);

        // Create a new user record
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->subscriptionType = 1;
        $user->accttype = 1;
        $user->save();

        // Redirect the user after successful registration
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the user's input
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if the identifier is an email or username
        $field = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt to log the user in using email or username
        if (Auth::attempt([$field => $credentials['identifier'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard'); // Redirect to the intended page after login
        }

        // If login attempt fails, redirect back with error message
        return back()->withErrors([
            'identifier' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}