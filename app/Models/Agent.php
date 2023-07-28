<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        "number",
        "firstname",
        "lastname",
        "phone",
        "email",
        "sexe",
        "user_id",
        "type_id",
        "master_id",
        "pos_id"
    ];

    #ONE TO MANY RELATIONSHIP/INVERSE(UN MASTER PEUT CREER PLUSIEURS AGENTS)
    public function master():BelongsTo
    {
        return $this->belongsTo(Master::class,"master_id");
    }

    #LE USER CORRESPONDANT A CE AGENT
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function agency():BelongsTo
    {
        return $this->belongsTo(Agency::class,"agency_id");
    }

    public function pos():BelongsTo
    {
        return $this->belongsTo(Pos::class,);
    }

    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class,"owner");
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class,"agent_id");
    }
}
