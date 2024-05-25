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
        return response()->json($activites);
    }

    public function show($id)
    {
        $activite = Activite::with('elementsActivites')->find($id);

        if (!$activite) {
            return response()->json(['message' => 'Cette activité n\'existe pas!'], 404);
        }

        return response()->json($activite);
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

        return response()->json(['activite' => $activite], 201);
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

        return response()->json(['activite' => $activite, 'message' => 'L\'activité a été mise à jour avec succès!']);
    }

    public function destroy($id)
    {
        $activite = Activite::find($id);

        if (!$activite) {
            return response()->json(['message' => 'Cette activité n\'existe pas!'], 404);
        }

        $activite->delete();

        return response()->json(['message' => 'L\'activité a été supprimée avec succès!']);
    }
}
