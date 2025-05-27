<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduccionLista extends Model
{
    use HasFactory;

    protected $table = 'produccion_listas';
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'lista_personalizada_id',
        'produccion_id'
    ];

    /**
     * Get the listaPersonalizada that owns the ProduccionLista
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listaPersonalizada()
    {
        return $this->belongsTo(ListaPersonalizada::class);
    }

    /**
     * Get the produccion that owns the ProduccionLista
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
