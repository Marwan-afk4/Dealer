<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone'=> 'required|unique:users',
            'password' => 'required|min:6',
            'qualification' => 'nullable',
            'experience_year' => 'nullable|integer',
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
            'qualification' => $request->qualification,
            'experience_year' => $request->experience_year,
            'role' => 'user'
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
            'password' => 'required|min:6',
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

}
