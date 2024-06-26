<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
use HasFactory;

protected $fillable = [
'question_id',
'body',
'content',
'user_id',
'is_validated',
];

public function user()
{
return $this->belongsTo(User::class);
}

public function question()
{
return $this->belongsTo(Question::class);
}

// Méthode pour vérifier et mettre à jour le rôle de l'utilisateur
public function updateUserRoleIfNeeded()
{
$user = $this->user;

// Compte les réponses validées de l'utilisateur
$validatedCount = $user->answers()->where('is_validated', true)->count();

// Vérifie si l'utilisateur est éligible pour devenir superviseur
if ($validatedCount >= 10 && $user->role !== 'supervisor') {
$user->role = 'supervisor';
$user->save();
}
}
}
