<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the resenas for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class); 
    }

    /**
     * Get all of the marcarProduccion for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marcarProduccion()
    {
        return $this->hasMany(MarcarProducciones::class); 
    }

    /**
     * Get all of the listasPersonalizadas for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listasPersonalizadas()
    {
        return $this->hasMany(ListaPersonalizada::class); 
    }
}
