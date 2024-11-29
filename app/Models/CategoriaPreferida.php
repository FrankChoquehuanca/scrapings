<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPreferida extends Model
{
    use HasFactory;
    protected $fillable = ['categoria', 'clicks'];
}
