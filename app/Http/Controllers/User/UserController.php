<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\RegisterResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Register a new user and create wallet automatically
     */
    public function register(RegisterRequest $request)
    {
        // 1️⃣ Validate request
        $validated = $request->validated();

        // 2️⃣ Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // 3️⃣ Create wallet automatically
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'reference' => 'WALLET-' . Str::uuid(),
            'balance' => 0,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => RegisterResource::make($user),

        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        // 1️⃣ Validate request
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2️⃣ Attempt login
        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // 3️⃣ Get authenticated user
        $user = Auth::user();

        // 4️⃣ Generate token (Sanctum or JWT)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => RegisterResource::make($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
