<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $table = 'noticias';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'titulo',
        'enlace',
        'imagen',
        'autor',
        'category',
    ];

    // Los atributos que deberían ser convertidos a fechas.
    protected $dates = [];

    // Los atributos que deberían ser ocultos para los arrays.
    protected $hidden = [];

    // Los atributos que deberían estar presentes en los arrays.
    protected $casts = [];
}
