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
        return $this->belongsTo(Agency::class,'owner');
    }

    public function admin():BelongsTo
    {
        return $this->belongsTo(User::class,'owner');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function stores() : HasMany {
        return $this->hasMany(Store::class,"owner");
    }

}
