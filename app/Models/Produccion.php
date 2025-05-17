<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion';
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'titulo',
        'tipo',
        'genero_id',
        'sinopsis',
        'duracion',
        'fecha_estreno',
        'poster',
        'puntuacion_critica',
        'puntuacion_usuarios'
    ];

    /**
     * Get the genero that owns the Produccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genero()
    {
        return $this->belongsTo(Genero::class); 
    }
}
