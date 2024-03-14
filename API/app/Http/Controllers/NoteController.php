<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function noter(Request $request)
    {

        $validatedData = $request->validate([
            'matricule' => 'required|integer|exists:etudiants,matricule',
            'code_UE' => 'required|string|exists:u_e_s,code_UE',
            'note' => 'required|integer|between:0,20',
        ]);

        try {
            $note = Note::create($validatedData);
            $note->statut = $note->note >= 12 ? 1 : 0;
            $note->save();
            return response()->json($note, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la notation', 'details' => $e->getMessage()], 500);
        }
    }

    public function get($matricule, $code_UE)
    {
        try {
            $note = Note::where('matricule', $matricule)->where('code_UE', $code_UE)->firstOrFail();
            return response()->json($note);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Note non trouvée'], 404);
        }
    }
}
