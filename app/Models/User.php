<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'phone',
        'firstname',
        'lastname',
        'country',
        'complement',
        'api_key',
        'acount_status',
        'gender',
        'profile_picture',
        'parent_id',
        'rang_id',
        'profil_id',
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
        'password' => 'hashed',
    ];


    #ONE TO ONE/REVERSE RELATIONSHIP(UN UTILISATEUR NE PEUT QU'AVOIR UN SEUL RANG)
    function rang(): BelongsTo
    {
        return $this->belongsTo(Rang::class, 'rang_id');
    }

    #ONE TO MANY/INVERSE RELATIONSHIP (UN USER PEUT APPARTENIR A PLUISIEURS PROFILS)
    function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }

    function master(): HasOne
    {
        return $this->hasOne(Master::class);
    }

    function masters(): HasMany
    {
        return $this->hasMany(Master::class, "owner");
    }

    function agents(): HasMany
    {
        return $this->hasMany(Agent::class, "owner");
    }

    function agencies(): HasMany
    {
        return $this->hasMany(Agency::class, "owner");
    }

    function drts(): HasMany
    {
        return $this->hasMany(Right::class, "user_id");
    }

    function stores(): HasMany
    {
        return $this->hasMany(Store::class, "owner");
    }

    function poss(): HasMany
    {
        return $this->hasMany(Pos::class, "owner");
    }

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function sessions(): HasMany
    {
        return $this->hasMany(UserSession::class, "user");
    }

    function sold(): HasOne
    {
        return $this->hasOne(Sold::class, "owner");
    }
}
