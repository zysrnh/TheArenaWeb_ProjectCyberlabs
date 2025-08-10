<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        // Find user
        $user = User::where('email', $validated['email'])->first();

        // If user not found or password mismatch
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
                'data'    => null,
            ], 401);
        }

        // Check roles
        $allowedRoles = ['super_admin', 'web_admin', 'admin_editor'];
        if (!$user->hasAnyRole($allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized — user does not have permission to login.',
                'data'    => null,
            ], 403);
        }

        // Create Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
            'data'    => null,
        ], 200);
    }
}
