<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;
    protected $table = 'resenas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id',
        'produccion_id',
        'puntuacion',
        'descripcion'
    ];

    /**
     * Get the usuario that owns the Resena
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the produccion that owns the Resena
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
