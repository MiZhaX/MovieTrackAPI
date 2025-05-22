<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;
    protected $table = 'directores';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'persona_id',
        'produccion_id',
    ];

    /**
     * Get the persona that owns the Director
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Get the produccion that owns the Director
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
