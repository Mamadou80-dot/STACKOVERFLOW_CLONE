<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
use HasApiTokens, HasFactory, Notifiable;

protected $fillable = [
'name', 'email', 'password', 'role'
];

protected $hidden = [
'password', 'remember_token',
];

public function questions()
{
return $this->hasMany(Question::class);
}

    public function getRoleAttribute()
    {
        return $this->attributes['role'];
    }

public function answers()
{
return $this->hasMany(Answer::class);
}

    public function validatedResponses()
    {
        return $this->hasMany(answer::class)->where('validated', true);
    }

    public function isEligibleForSupervisor()
    {
        return $this->validatedResponses()->count() >= 10;
    }

}

