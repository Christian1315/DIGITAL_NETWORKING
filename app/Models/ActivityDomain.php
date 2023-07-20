<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActivityDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        "libele",
    ];

}
