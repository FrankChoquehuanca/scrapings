<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadisticaScraping extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria',
        'veces_scrapeado',
    ];
}
