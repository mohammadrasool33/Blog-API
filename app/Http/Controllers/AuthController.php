<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request){
        $request->validated();
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();

        // Create a new personal access token for the user
        $token = $user->createToken('to user->'.$user->name)->plainTextToken;

        // Return the token in a successful response
        return response()->json(['token' => $token], 200);
    }
    public function register(UserRegisterRequest $request){
        $validated=$request->validated();
        $user=User::create($validated);
        $token = $user->createToken('to user->'.$user->name)->plainTextToken;
        return response()->json(['token' => $token], 200);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
