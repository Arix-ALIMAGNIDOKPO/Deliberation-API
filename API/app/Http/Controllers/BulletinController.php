<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BulletinController extends Controller
{
    public function getBulletin(Request $request)
    {
        $matricule = $request->input('matricule');
        $password = $request->input('password');

        $user = DB::table('inscriptions')->where('matricule', $matricule)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Informations d\'identification non valides'], 401);
        }

        $etudiant = DB::table('etudiants')->where('matricule', $user->matricule)->first();

        if (!$etudiant) {
            return response()->json(['error' => 'Etudiant non trouvé'], 404);
        }

        $ues = DB::table('u_e_s')->where('semestre', $etudiant->semestre_actuel)->get();

        if ($ues->isEmpty()) {
            return response()->json(['error' => 'Aucune UE trouvée pour ce semestre'], 404);
        }

        $bulletin = [];
        foreach ($ues as $ue) {
            $note = DB::table('notes')
                ->where('matricule', $user->matricule)
                ->where('code_UE', $ue->code_UE)
                ->orderByDesc('created_at')
                ->first();

            $bulletin[] = [
                'code_UE' => $ue->code_UE,
                'note' => $note ? $note->note : 0,
                'statut' => $note ? $note->statut : 0,
            ];
        }

        return response()->json([
            'semestre' => $etudiant->semestre_actuel,
            'bulletin' => $bulletin,
        ]);
    }
}
