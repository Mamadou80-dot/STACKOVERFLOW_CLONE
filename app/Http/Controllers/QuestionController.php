<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
public function index()
    {
        $questions = Question::with('answers')->get();
        return response()->json($questions);
    }

    public function answers($id)
    {
        // Récupérer la question par son ID
        $question = Question::findOrFail($id);

        // Récupérer les réponses associées à cette question
        $answers = $question->answers;

        return response()->json($answers);
    }
 public function show($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        return response()->json($question);
    }
public function store(Request $request)
{
$validator = Validator::make($request->all(), [
'title' => 'required|string|max:255',
'body' => 'required|string'
]);

if ($validator->fails()) {
return response()->json(['errors' => $validator->errors()], 400);
}

$question = new Question;
$question->title = $request->title;
$question->body = $request->body;
$question->user_id = Auth::id(); // Assurez-vous que l'utilisateur est authentifié
$question->save();

return response()->json(['message' => 'Question créée avec succès', 'question' => $question], 201);
}
}
