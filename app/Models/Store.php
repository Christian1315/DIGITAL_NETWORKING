<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "owner",
        "active"
    ];

    public function owner() : BelongsTo {
        return $this->belongsTo(User::class,"owner");
    }

    public function agent() : BelongsTo {
        return $this->belongsTo(Agent::class);
    }

    public function agency() : BelongsTo {
        return $this->belongsTo(Agency::class);
    }

    public function pos() : BelongsTo {
        return $this->belongsTo(Pos::class);
    }


}
