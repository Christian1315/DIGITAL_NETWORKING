<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Right extends Model
{
    use HasFactory;
    protected $fillable = [
        "label",
        "profil_id",
        "rang_id",
        "action_id"
    ];

    #MANY TO MANY RELATIONSHIP(UN RIGHT PEUT APPARTENIR A PLUSIEURS RANGS)
    function rangs():BelongsToMany{
        return $this->belongsToMany(Rang::class,'rangs_rights',"right_id","rang_id");
    }

    #MANY TO MANY RELATIONSHIP(UN DROIT PEUT APPARTENIR A PLUISIEURS USERS)
    function actions():BelongsToMany{
        return $this->belongsToMany(User::class,'rights_users','right_id','user_id');
    }

    #MANY TO MANY RELATIONSHIP(UN DROIT PEUT APPARTENIR A PLUISIEURS PROFILS)
    function profils():BelongsToMany{
        return $this->belongsToMany(Profil::class,'profils_rights','right_id','profil_id');
    }
}
