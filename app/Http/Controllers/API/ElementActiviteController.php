<?php

namespace App\Http\Controllers\API;

use App\Models\ElementActivite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ElementActiviteController extends Controller
{
    public function index()
    {
        $elementsActivite = ElementActivite::all();

        $response = [
            'success' => true,
            'elements_activite' => $elementsActivite
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $elementActivite = ElementActivite::find($id);

        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }

        $response = [
            'success' => true,
            'element_activite' => $elementActivite
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activite_id' => 'required|integer',
            'titre' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'status_message' => 'Erreur de Validation',
                'errors' => $validator->errors(),
            ], 400);
        }

        $elementActivite = ElementActivite::create($request->all());

        $response = [
            'success' => true,
            'element_activite' => $elementActivite,
            'message' => 'L\'élément de l\'activité a été créé avec succès!'
        ];

        return response()->json($response, 201);
    }

    public function update(Request $request, $id)
    {
        $elementActivite = ElementActivite::find($id);

        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }

        $validator = Validator::make($request->all(), [
            'activite_id' => 'required|integer',
            'titre' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'status_message' => 'Erreur de Validation',
                'errors' => $validator->errors(),
            ], 400);
        }

        $elementActivite->update($request->all());

        $response = [
            'success' => true,
            'element_activite' => $elementActivite,
            'message' => 'L\'élément de l\'activité a été mis à jour avec succès!'
        ];

        return response()->json($response);
    }

    public function destroy($id)
    {
        $elementActivite = ElementActivite::find($id);

        if (!$elementActivite) {
            return response()->json(['message' => 'L\'élément de l\'activité n\'existe pas'], 404);
        }

        $elementActivite->delete();

        $response = [
            'success' => true,
            'message' => 'L\'élément de l\'activité a été supprimé avec succès!'
        ];

        return response()->json($response);
    }
}
