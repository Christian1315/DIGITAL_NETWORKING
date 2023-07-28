<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pos extends Model
{
    use HasFactory;

    protected $fillable = [
        "username",
        "country",
        "phone"
    ];


    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class,'owner');
    }


    public function stores() : HasMany {
        return $this->hasMany(Store::class,"owner");
    }

    public function agents() : HasMany {
        return $this->hasMany(Agent::class,);
    }

    public function agencies() : BelongsTo {
        return $this->belongsTo(Agency::class,"agency_id");
    }

}
