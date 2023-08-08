<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "comments",
        "supply",
        "product",
        "quantity",
    ];
}
