<?php

namespace App\Http\Controllers\API;

use App\Models\ElementActivite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElementActiviteController extends Controller
{
    public function index()
    {
        $elementsActivite = ElementActivite::all();
        return response()->json($elementsActivite);
    }

    public function store(Request $request)
    {
        $request->validate([
            'activite_id' => 'required|integer',
            'titre' => 'required|string',
            'description' => 'required|string',
        ]);

        $elementActivite = ElementActivite::create([
            'activite_id' => $request->activite_id,
            'titre' => $request->titre,
            'description' => $request->description,
        ]);

        return response()->json(['element_activite' => $elementActivite], 201);
    }

    public function show($id)
    {
        $elementActivite = ElementActivite::find($id);
        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }
        return response()->json($elementActivite);
    }

    public function update(Request $request, $id)
    {
        $elementActivite = ElementActivite::find($id);
        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }

        $request->validate([
            'activite_id' => 'required|integer',
            'titre' => 'required|string',
            'description' => 'required|string',
        ]);

        $elementActivite->update([
            'activite_id' => $request->activite_id,
            'titre' => $request->titre,
            'description' => $request->description,
        ]);

        return response()->json(['element_activite' => $elementActivite, 'message' => 'L\'élément de l\'activité a été mis à jour avec succès']);
    }

    public function destroy($id)
    {
        $elementActivite = ElementActivite::find($id);
        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }

        $elementActivite->delete();

        return response()->json(['message' => 'L\'élément de l\'activité a été supprimé avec succès']);
    }
}
