<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function inscrire(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function connecter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'L\'adresse e-mail ou le mot de passe est incorrect. Veuillez réessayer.'], 401);
    }
}
