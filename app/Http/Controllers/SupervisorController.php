<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:supervisor');
    }


    // Méthode pour valider une réponse
    public function validateAnswer($answerId)
    {
        try {
            // Trouver la réponse par ID
            $answer = Answer::findOrFail($answerId);

            // Valider la réponse
            $answer->is_validated = true;
            $answer->save();

            $answer->updateUserRoleIfNeeded();

            return response()->json(['message' => 'Réponse validée avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Réponse non trouvée ou erreur lors de la validation.', 'error' => $e->getMessage()], 404);
        }
    }

    public function listValidatedAnswers()
    {
        $validatedAnswers = Answer::where('is_validated', true)->get();
        return response()->json($validatedAnswers);
    }



}
