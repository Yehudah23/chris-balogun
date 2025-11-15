<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        
        $user = User::where('is_admin', true)->first();

       
        if (!$user) {
            return response()->json([
                'status' => 201,
                'msg' => 'No admin user found'
            ], 200);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 201,
                'msg' => 'Invalid password'
            ], 200);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'token' => $token,
            'access_token' => $token,
            'api_token' => $token
        ];

        return response()->json([
            'status' => 202,
            'msg' => 'Login successful',
            'user' => $userData
        ], 200);
    }

    /**
     * Logout user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Get authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json([
            'status' => 200,
            'user' => $request->user()
        ], 200);
    }
}
