<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Support\Facades\Hash;


class EtudiantController extends Controller
{
    public function addStudent(Request $request)
    {
        try {
            // Validez les données d'entrée (par exemple, vérifiez les doublons, validez le format de l'e-mail, etc.)
            $validatedData = $request->validate([
                'nom' => 'required|string',
                'prenoms' => 'required|string',
                'filiere' => 'required|in:IA,GL,SI,IM,SEIOT',
                'email' => 'required|email|unique:etudiants',
                'semestre_actuel' => 'required|integer|min:1|max:6',
                'matricule' => 'required|integer|unique:etudiants',
            ]);

            // Ajoutez l'étudiant à la base de données (Laravel Eloquent ORM)
            Etudiant::create($validatedData);

            return response()->json(['message' => 'Étudiant ajouté avec succès'], 201);
        } catch (\Exception $e) {
            // Gérez les exceptions (par exemple, erreurs de base de données)

            return response()->json(['error' => 'Erreur lors de l\'ajout de l\'étudiant', 'details' => $e->getMessage()], 500);
        }
    }

    public function getStudent($matricule)
    {
        try {
            // Récupérez l'étudiant de la base de données en fonction du matricule (Laravel Eloquent ORM)
            $student = Etudiant::where('matricule', $matricule)->firstOrFail();

            return response()->json($student, 200);
        } catch (\Exception $e) {
            // Gérez les exceptions (par exemple, étudiant non trouvé)
            return response()->json(['error' => 'Étudiant non trouvé', 'details' => $e->getMessage()], 404);
        }
    }

    public function addStudentRegistration(Request $request)
    {
        try {
            $data = $request->validate([
                'matricule' => 'required|integer|exists:etudiants,matricule',
                'email' => 'required|string|exists:etudiants,email',
                'password' => 'required|string',
            ]);

            // Hachez le mot de passe
            $data['password'] = bcrypt($data['password']);

            // Vérifiez si l'étudiant est déjà inscrit
            if (Inscription::where('matricule', $data['matricule'])->exists()) {
                return response()->json(['error' => 'L\'étudiant est déjà inscrit'], 400);
            }

            // Ajoutez l'inscription à la table Inscription
            Inscription::create($data);

            return response()->json(['message' => 'Inscription réussie'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Gérez les erreurs de validation
            return response()->json(['error' => 'Erreur lors de la validation', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de l\'inscription', 'details' => $e->getMessage()], 500);
        }
    }

    public function studentLogin(Request $request)
    {
        try {
            $data = $request->validate([
                'matricule' => 'required|integer',
                'password' => 'required',
            ]);

            // Vérifiez si l'étudiant existe dans la table Inscription
            $inscription = Inscription::where('matricule', $data['matricule'])->first();
            if (!$inscription || !Hash::check($data['password'], $inscription->password)) {
                return response()->json(['error' => 'Identifiants invalides'], 401);
            }

            return response()->json(['message' => 'Connexion réussie'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la connexion', 'details' => $e->getMessage()], 500);
        }
    }
}
