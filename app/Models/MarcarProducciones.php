<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcarProducciones extends Model
{
    use HasFactory;
    protected $table = 'marcar_producciones';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id',
        'produccion_id',
        'marca',
        'favorita'
    ];

    /**
     * Get the usuario that owns the Actor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the produccion that owns the Actor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }

}
