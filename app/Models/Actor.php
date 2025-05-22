<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    protected $table = 'actores';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'persona_id',
        'produccion_id',
        'rol'
    ];

    /**
     * Get the persona that owns the Actor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class);
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
