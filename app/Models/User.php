<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    function rang():BelongsTo{
        return $this->belongsTo(Rang::class,'rang_id');
    }

    #ONE TO MANY/INVERSE RELATIONSHIP (UN USER PEUT APPARTENIR A PLUISIEURS PROFILS)
    function profil():BelongsTo{
        return $this->belongsTo(Profil::class,'profil_id');
    }

    #MANY TO MANY RELATIONSHIP(UN USER PEUT AVOIR PLUISIEURS DROITS)
    function rights():BelongsToMany{
        return $this->belongsToMany(Right::class,'rights_users','user_id','right_id');
    }
}
