<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard'; // Default redirect path after login

    public function __construct()
    {
        $this->middleware('guest'); // Only allow guests to access this controller
    }

    public function showRegistrationForm()
    {
        return view('auth.register'); // Show registration form view
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure password is confirmed
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Default role for new users
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());

        // Log the user in after registration
        Auth::login($user);

        session()->flash('success', 'Registration successful! You are now logged in.');
        
        // Redirect to user dashboard after successful registration
        return redirect()->route('user.dashboard'); 
    }

    public function userSignUp(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:4'
        ]);

        // Create a new user instance
        $user = new User();
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->password = Hash::make($request['password']); // Hash the password
        $user->role = 'user'; // Set default role as user
        $user->save();

        // Log in the user after registration
        Auth::login($user); 

        // Redirect to user dashboard after successful registration
        return redirect()->route('user.dashboard'); 
    }
}