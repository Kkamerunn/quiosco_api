<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestRegister;
use App\Http\Requests\RequestLogin;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RequestRegister $request)
    {
        // Validate data
        $data = $request->validated();

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        // Return a response
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function login(RequestLogin $request)
    {
        $data = $request->validated();

        // Check if the password is correct
        if (!Auth::attempt($data)) {
            return response([
                'errors' => ['The email or password is incorrect']
            ], 422);
        }

        // Authenticate the user
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
