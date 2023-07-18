<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'phone',
        'detail'
    ];

    #MANY TO MANY RELATIONSHIP(UN GROUPE PEUT AVOIR PLUISIEURS CONTACT)
    function groupes():BelongsToMany{
        return $this->BelongsToMany(Groupe::class,'contacts_groupes','contact_id','groupe_id');
    }
}
