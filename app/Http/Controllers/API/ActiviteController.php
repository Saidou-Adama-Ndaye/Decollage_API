<?php

namespace App\Http\Controllers\API;

use App\Models\Activite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiviteController extends Controller
{
    public function index()
    {
        $activites = Activite::with('elementsActivites')->get();

        $response = [
            'success' => true,
            'activites' => $activites
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $activite = Activite::with('elementsActivites')->find($id);

        if (!$activite) {
            return response()->json(['message' => 'Cette activité n\'existe pas!'], 404);
        }

        $response = [
            'success' => true,
            'activite' => $activite
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
        ]);

        $activite = Activite::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        $response = [
            'success' => true,
            'activite' => $activite,
            'message' => 'L\'activité a été créée avec succès!'
        ];

        return response()->json($response, 201);
    }

    public function update(Request $request, $id)
    {
        $activite = Activite::find($id);

        if (!$activite) {
            return response()->json(['message' => 'Cette activité n\'existe pas!'], 404);
        }

        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
        ]);

        $activite->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        $response = [
            'success' => true,
            'activite' => $activite,
            'message' => 'L\'activité a été mise à jour avec succès!'
        ];

        return response()->json($response);
    }

    public function destroy($id)
    {
        $activite = Activite::find($id);

        if (!$activite) {
            return response()->json(['message' => 'Cette activité n\'existe pas!'], 404);
        }

        $activite->delete();

        $response = [
            'success' => true,
            'message' => 'L\'activité a été supprimée avec succès!'
        ];

        return response()->json($response);
    }
}
