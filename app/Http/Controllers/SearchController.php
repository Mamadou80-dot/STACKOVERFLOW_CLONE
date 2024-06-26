<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchQuestions(Request $request)
    {
        $keyword = $request->query('keyword');
        $questions = Question::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('body', 'LIKE', "%{$keyword}%")
            ->with(['user', 'answers'])
            ->get();
        return response()->json($questions);
    }

    public function searchAnswers(Request $request)
    {
        $keyword = $request->query('keyword');
        $answers = Answer::where('content', 'LIKE', "%{$keyword}%")
            ->with('user')
            ->get();
        return response()->json($answers);
    }
}

