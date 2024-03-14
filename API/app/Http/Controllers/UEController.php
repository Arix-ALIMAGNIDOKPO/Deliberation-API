<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UE;

class UEController extends Controller
{
    public function add_ue(Request $request)
    {
        try {
            // Validez les données d'entrée (par exemple, vérifiez les doublons, validez le format de l'e-mail, etc.)
            $validatedData = $request->validate([
                'intitulé' => 'required|string',
                'code_UE' => 'required|string|unique:u_e_s',
                'semestre' => 'required|integer|min:1|max:6',
                'credit' => 'required|integer',
            ]);

            // Ajoutez l'étudiant à la base de données (Laravel Eloquent ORM)
            UE::create($validatedData);

            return response()->json(['message' => 'UE ajouté avec succès'], 201);
        } catch (\Exception $e) {
            // Gérez les exceptions (par exemple, erreurs de base de données)

            return response()->json(['error' => 'Erreur lors de l\'ajout de l\'UE', 'details' => $e->getMessage()], 500);
        }
    }
}
