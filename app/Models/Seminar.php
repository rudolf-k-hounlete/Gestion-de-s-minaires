<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $fillable = [
        'theme',
        'summary',         // ajouté
        'preferred_date',  // ajouté
        'scheduled_date',
        'status',
        'presenter_id',
        'presentation_path',
        // etc.
    ];

    protected $casts = [
        'scheduled_date'   => 'date',
        'preferred_date'   => 'date',  // cast pour date
        // si vous avez d’autres dates, par exemple :
        // 'presentation_uploaded_at' => 'datetime',
    ];

    public function presenter()
    {
        return $this->belongsTo(User::class, 'presenter_id');
    }
}
