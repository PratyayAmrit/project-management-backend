<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register User Api
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Registered Successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Login User Api
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => "Invalid Login Credentials"
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => "User LoggedIn successfully",
            'user' => $user,
            'token' => $token,
        ], 200);

    }

    // Logout User Api
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => "User Logged Out successfully"
        ]);

    }
}
