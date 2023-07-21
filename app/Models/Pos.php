<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pos extends Model
{
    use HasFactory;

    protected $fillable = [
        "username",
        "country",
        "phone"
    ];

    public function master():BelongsTo
    {
        return $this->belongsTo(Master::class,'master_id');
    }


    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
