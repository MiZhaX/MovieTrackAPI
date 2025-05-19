<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;
    protected $table = 'directores';
    protected $primaryKey = ['persona_id', 'produccion_id']; 
    protected $keyType = 'int';

    protected $fillable = [
        'persona_id',
        'produccion_id',
    ];
}
