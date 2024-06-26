<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
        $this->middleware('role:admin')->only(['promoteToSupervisor']);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function getUserRole(Request $request)
    {
        // Retourner le rôle de l'utilisateur actuellement authentifié
        return response()->json([
            'role' => $request->user()->role,
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function promoteToSupervisor($userId)
    {
        $user = User::findOrFail($userId);
        $validatedAnswersCount = Answer::where('user_id', $userId)->where('is_validated', true)->count();

        if ($validatedAnswersCount >= 10) {
            $user->role = 'supervisor';
            $user->save();
            return response()->json(['message' => 'User promoted to supervisor successfully.'], 200);
        }
        return response()->json(['message' => 'User does not meet the requirements to be a supervisor.'], 400);
    }
}

