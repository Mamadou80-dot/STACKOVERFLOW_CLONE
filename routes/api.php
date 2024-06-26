<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SearchController;

// Routes d'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/questions/{id}/answers', [AnswerController::class, 'getAnswers']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUserRole']);




    ;
// Routes pour les utilisateurs
Route::middleware('auth:sanctum')->group(function () {
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::post('/user/{id}/promote', [UserController::class, 'promoteToSupervisor']);
Route::post('/questions', [QuestionController::class, 'store']);
Route::put('/questions/{id}', [QuestionController::class, 'update']);
Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
    Route::post('/answers', [AnswerController::class, 'store'])->middleware('auth:sanctum');
Route::put('/answers/{id}', [AnswerController::class, 'update']);
Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);
    Route::post('/supervisor/validate/{answerId}', [SupervisorController::class, 'validateAnswer'])->middleware('role:supervisor');
Route::get('/supervisor/validated-answers', [SupervisorController::class, 'listValidatedAnswers']);
Route::post('/users/promote/{userId}', [UserController::class, 'promoteToSupervisor'])->middleware('role:admin');
Route::post('/topics', [TopicController::class, 'store']);
Route::put('/topics/{id}', [TopicController::class, 'update']);
Route::delete('/topics/{id}', [TopicController::class, 'destroy']);
});

// Routes publiques
Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/topics', [TopicController::class, 'index']);
Route::get('/search/questions', [SearchController::class, 'searchQuestions']);
Route::get('/search/answers', [SearchController::class, 'searchAnswers']);
