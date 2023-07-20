<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Master extends Model
{
    use HasFactory;
    protected $fillable = [
        "number",
        "raison_sociale",
        "ifu",
        "ifu_file",
        "rccm",
        "rccm_file",
        "country",
        "commune",
        "phone",
        "email",
        "domaine_activite",
        "type_piece",
        "numero_piece",
        "description",
        "user_id",
        "parent",
    ];

    #ONE TO ONE RELATIONSHIP/INVERSE(UN MASTER NE S'ENREGISTRE QU'AU NOM D'UN SEUL USER)
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #ONE TO MANY RELATIONSHIP(UN MASTER PEUT CREER PLUSIEURS AGENTS)
    public function agents():HasMany
    {
        return $this->hasMany(Agent::class);
    }

    #ONE TO ONE RELATIONSHIP/INVERSE(UN MASTER NE S'ENREGISTRE QU'AU NOM D'UN SEUL USER)
    public function piece():BelongsTo
    {
        return $this->belongsTo(Piece::class,'type_piece');
    }
}
