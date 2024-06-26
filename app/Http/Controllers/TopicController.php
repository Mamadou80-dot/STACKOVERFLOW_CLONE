<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    public function index()
    {
        $topics = Topic::all();
        return response()->json($topics);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:topics,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $topic = Topic::create($request->all());
        return response()->json($topic, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:topics,name,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $topic = Topic::findOrFail($id);
        $topic->update($request->all());
        return response()->json($topic);
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return response()->json(['message' => 'Topic deleted successfully']);
    }
}
