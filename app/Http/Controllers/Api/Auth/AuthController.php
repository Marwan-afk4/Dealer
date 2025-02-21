<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone'=> 'required|unique:users',
            'age' => 'nullable|integer',
            'password' => 'required|min:6',
            'qualification' => 'nullable',
            'experience_year' => 'nullable|integer',
            'governce' => 'nullable'
        ]);
        if($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 401);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'qualification' => $request->qualification??null,
            'experience_year' => $request->experience_year??null,
            'governce' => $request->governce??null,
            'role' => 'user',
            'age' => $request->age
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone' => 'nullable|exists:users',
            'email' => 'nullable|exists:users',
            'password' => 'required|min:8',
        ]);
        if($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 401);
        }

        $user=User::where('email', $request->email)
        ->orWhere('phone', $request->phone)
        ->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User successfully logged in',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request) {
            $user=$request->user();
            $user->currentAccessToken()->delete();
            return response()->json(['message'=>'logged out successfully']);
        }




    public function googleAuthenticationCallback(Request $request) {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $idToken = $request->input('id_token');

        // Initialize Google Client
        $client = new Google_Client(['client_id' => config('services.google.client_id')]);


        try {

            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                return response()->json(['error' => 'Invalid Google token'], 401);
            }

            // Extract user info from payload
            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];


            $user = User::where('google_id', $googleId)->orWhere('email', $email)->first();

            if (!$user) {

                $user = User::create([
                    'first_name' => $name,
                    'last_name' => null,
                    'email' => $email,
                    'google_id' => $googleId,
                    'password' => null,
                    'role' => 'user',
                ]);
            }

            // Generate authentication token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User successfully authenticated',
                'user' => $user,
                'token' => $token,
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Google authentication failed', 'details' => $e->getMessage()], 500);
        }
        // try{

        //     $user = Socialite::driver('google')->user();

        //     $AuthUser = User::where('google_id',$user->id)->first();
        //     if($AuthUser){
        //         $token = $AuthUser->createToken('auth_token')->plainTextToken;
        //         return response()->json([
        //             'message' => 'User successfully logged in',
        //             'user' => $AuthUser,
        //             'token' => $token,
        //         ]);
        //     }
        //     else{
        //         $user = User::create([
        //             'first_name' => $user->name,
        //             'last_name' => null,
        //             'email' => $user->email,
        //             'phone' => null,
        //             'password' => null,
        //             'qualification' => null,
        //             'experience_year' => null,
        //             'governce' => null,
        //             'role' => 'user',
        //             'age' => null,
        //             'google_id' => $user->id,
        //         ]);
        //         $token = $user->createToken('auth_token')->plainTextToken;
        //         return response()->json([
        //             'message' => 'User successfully logged in',
        //             'user' => $user,
        //             'token' => $token,
        //         ]);
        //     }
        // } catch(Exception $e){
        //     dd($e);
        // }

}

}
