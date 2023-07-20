<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        "master_id"
    ];

    #ONE TO MANY RELATIONSHIP/INVERSE(UN MASTER PEUT CREER PLUSIEURS AGENTS)
    public function master():BelongsTo
    {
        return $this->belongsTo(Master::class,"agent_id");
    }
}
