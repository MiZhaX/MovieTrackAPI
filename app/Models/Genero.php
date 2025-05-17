<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'nombre'
    ];

    /**
     * Get the producciones associated with the Produccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function producciones()
    {
        return $this->hasMany(Produccion::class);
    }
}
