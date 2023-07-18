<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    protected $fillable = [
        "messageId",
        "from",
        "to",
        "message",
        "type",
        "route",
        "sms_count",
        "amount",
        "currency",
        "status"
    ];
}
