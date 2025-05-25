<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'producciones';
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

    /**
     * Get all of the actores for the Produccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actores()
    {
        return $this->hasMany(Actor::class); 
    }

    /**
     * Get all of the directores for the Produccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directores()
    {
        return $this->hasMany(Director::class); 
    }

    /**
     * Get all of the resenas for the Produccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class); 
    }
}
