<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPersonalizada extends Model
{
    use HasFactory;

    protected $table = 'listas_personalizadas';
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'usuario_id'
    ];

    /**
     * Get the usuario that owns the ListaPersonalizada
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the producciones for the ListaPersonalizada
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produccionesListas()
    {
        return $this->hasMany(ProduccionLista::class); 
    }
}
