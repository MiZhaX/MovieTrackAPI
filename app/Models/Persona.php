<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'personas';
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'biografia',
        'imagen',
    ];

    /**
     * Get all of the actores for the Persona
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actores()
    {
        return $this->hasMany(Actor::class);
    }

    /**
     * Get all of the directores for the Persona
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directores()
    {
        return $this->hasMany(Director::class);
    }
}
