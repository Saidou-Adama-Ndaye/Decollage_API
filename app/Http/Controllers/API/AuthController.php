<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function inscrire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:15',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'status_message' => 'Erreur de Validation',
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $user = User::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($request->password),
            ]);

            // Générer un jeton pour l'utilisateur nouvellement inscrit
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'status_message' => 'Utilisateur inscrit avec succès!',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status_message' => 'Inscription échoué!',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function connecter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'status_message' => 'Erreur de Validation',
                'errors' => $validator->errors(),
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté avec succès',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'status_code' => 401,
            'status_message' => 'Email ou mot de passe incorrect!',
            'errors' => ['email' => 'Email ou mot de passe incorrect!'],
        ], 401);
    }
}
