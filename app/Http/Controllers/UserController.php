<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function index(){

    }

    public function store(Request $request){

    }

    public function show(string $id){

    }

    public function update(Request $request, string $id){

    }


    public function destroy(string $id){

    }

    function loginPage(){
        return view('pages.auth.login-page');
    }

    public function signUp(Request $request){
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
            return $this->response(true,'Sign Up Successful',$user,201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return $this->response(false,$e->getMessage(),[],500);

        } catch (\Exception $e) {
            // Handle all other exceptions
            return $this->response(false,$e->getMessage(),[],500);
        }

    }

    // Login API
    public function login(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8',
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
            if($user->profile_photo_path) {
                $user->profile_photo_path = $baseUrl . '/storage/' . $user->profile_photo_path;
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

}
