<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductCommand extends Model
{
    use HasFactory;
    protected $table = "commands_products";

    // function product(): HasOne
    // {
    //     return $this->hasOne(ProductCommand::class, "product");
    // }

    // function products():BelongsTo{
    //     return $this->belongsTo(Product::class,);
    // }
}
