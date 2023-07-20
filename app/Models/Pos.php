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


    // #ONE TO ONE RELATIONSHIP/INVERSE(UN MASTER NE S'ENREGISTRE QU'AU NOM D'UN SEUL USER)
    // public function user():BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

}
