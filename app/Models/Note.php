<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    protected $fillable = [
        'title',
        'description',
        'user', // Relacionado directamente con el id del usuario
        'tags',
        'due_date',
        'image_path',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user'); // Usamos 'user' como la clave foránea
    }
}
