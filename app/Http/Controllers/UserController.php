<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        dump($request);


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
         try {
            $credentials = $request->validate([
                'email' => 'required|string|email|exists:users,email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response([
                'message' => 'Invalid Email or Password'
            ], 404);
        }
        
    // Attempt to authenticate the user
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Authentication passed
        return redirect()->intended('/dashboard'); // Redirect to a dashboard or any other desired route upon successful login
    } else {
        // Authentication failed
        return redirect()->route('login')->with('error', 'Invalid credentials. Please try again.');
    }
}
    // public function login(Request $request){

    //     try {
    //         $credentials = $request->validate([
    //             'email' => 'required|string|email|exists:users,email',
    //             'password' => 'required|string',
    //         ]);
    //     } catch (ValidationException $e) {
    //         return response([
    //             'message' => 'Invalid Email or Password'
    //         ], 404);
    //     }


    //     if (!Auth::attempt($credentials)) {
    //         return response([
    //             'message' => 'Invalid Password of Email'
    //         ], 404);
    //     }
    //     $user = Auth::user();
    //     $token = $user->createToken('auth-token')->plainTextToken;
    //     $user->load('shoppingCart');



    //     return response()->json([ 
    //         'message'=> 'Authorized',
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'username' => $user->username,
    //         'first_name' => $user->firstname,
    //         'last_name' => $user->lastname,
    //         'email' => $user->email,
    //         'user_id' => $user->id,
    //         ]);     
    //     }
   
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