<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'content' => 'required|string',
        ]);

        try {
            $answer = Answer::create([
                'question_id' => $request->question_id,
                'content' => $request->content,
                'user_id' => Auth::id(),
            ]);

            return response()->json($answer->content, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue lors de la création de la réponse. Veuillez réessayer.'], 500);
        }
    }





    public function getAnswers($id)
    {
        try {
            $question = Question::findOrFail($id); // Vérifie que la question avec cet ID existe
            $answers = $question->answers; // Récupère les réponses liées à cette question

            return response()->json($answers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Réponses non trouvées'], 404);
        }
    }


    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return response()->json($answer);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',

        ]);

        $answer = Answer::findOrFail($id);
        $this->authorize('update', $answer);
        $answer->update($request->all());

        return response()->json($answer);
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $this->authorize('delete', $answer);
        $answer->delete();

        return response()->json(null, 204);
    }
}
