<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public $users;


    public function index(){

    }

    public function store(Request $request)
    {

    }

    public function show(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }


    public function destroy(string $id)
    {

    }

    function showLoginForm()
    {
        return view('pages.auth.login-page');
    }

    public function signUp(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:1|confirmed',
                'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'role' => 'nullable'
            ]);

            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo_path')) {
                $profilePhotoPath = $request->file('profile_photo_path')->store('profile_photos', 'public');
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = "user";
            $user->profile_photo_path = $profilePhotoPath;
            $user->save();


            // Generate a Sanctum token
            $token = $user->createToken('api')->plainTextToken;
            $user->token = $token;

            $user->profile_photo_url = null;
            $user->makeHidden(['profile_photo_url']);
            $baseUrl = env('APP_URL', 'http://localhost:8000');

            // Generate the full URL for the profile picture
            $user->profile_photo_path = $baseUrl . '/storage/' . $user->profile_photo_path;
            // Return success response with the user and token
            return $this->response(true, 'Sign Up Successful', $user, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return $this->response(false, $e->getMessage(), [], 500);

        } catch (\Exception $e) {
            // Handle all other exceptions
            return $this->response(false, $e->getMessage(), [], 500);
        }

    }

    // Login API
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:1',
            ]);

            // Attempt to find the user by email
            $user = User::where('email', $request->email)->first();

            // Check if the user exists
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->response(false, 'Email or password is invalid', [], 401);
            }

            // Generate a Sanctum token
            $token = $user->createToken('api')->plainTextToken;
            $user->token = $token;

            $user->profile_photo_url = null;
            $user->makeHidden(['profile_photo_url']);

            $baseUrl = env('APP_URL', 'http://localhost:8000');

            // Generate the full URL for the profile picture
            if ($user->profile_photo_path) {
                $user->profile_photo_path = $baseUrl. $user->profile_photo_path;
            } else {
                $user->profile_photo_path = "";
            }


            // Return success response with the user and token
            return $this->response(true, 'User logged in successfully', $user, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return $this->response(false, 'Validation error', $e->errors(), 422);

        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return $this->response(false, 'An error occurred during login', $e->getMessage(), 500);
        }
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            return redirect()->route('dashboard');
        }
        else {
            // Authentication failed; check which credential is incorrect
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            if ($user && !Auth::validate(['email' => $user->email, 'password' => $credentials['password']])) {
                // Password is incorrect
                throw ValidationException::withMessages([
                    'password' => trans('auth.password_incorrect'),
                ])->redirectTo(route('login'));
            }
            elseif ($user) {
                // Email is incorrect
                throw ValidationException::withMessages([
                    'email' => trans('auth.email_incorrect'),
                ])->redirectTo(route('login'));
            }
            else {
                // Both email and password are incorrect
                throw ValidationException::withMessages([
                    'failed' => trans('auth.failed'),
                ])->redirectTo(route('login'));
            }
        }
    }

    public function userList(){

        $users = User::where('role','admin')->get();
        return view('pages.admin.user-page',[ 'users' => $users]);
    }




}
