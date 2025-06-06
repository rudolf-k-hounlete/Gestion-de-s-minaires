<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Champs modifiables
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Champs cachés
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation : un utilisateur (présentateur) peut avoir plusieurs séminaires.
     */
    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'presenter_id');
    }
}
