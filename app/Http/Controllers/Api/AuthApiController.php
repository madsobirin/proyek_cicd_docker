<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Login gagal'
        ], 401);
    }
    
//  /** @var \App\Models\Account $account */
    $account = Auth::user(); 

    $token = $account->createToken('flutter_token')->plainTextToken;

    return response()->json([
        'user' => $account,
        'token' => $token
    ]);
}

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email', // FIX
            'password' => 'required|min:6'
        ]);

        $account = Account::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // FIX
            'role' => 'user',
        ]);

        $token = $account->createToken('flutter_token')->plainTextToken;

        return response()->json([
            'user' => $account,
            'token' => $token
        ], 201);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}