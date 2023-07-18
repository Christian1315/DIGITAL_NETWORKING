<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    #MANY TO MANY RELATIONSHIP(UN CONTACT PEUT APPARTENIR A PLUISIEURS CONTACT)
    public function contacts(): BelongsToMany
    {
        return $this->BelongsToMany(Contact::class, 'contacts_groupes', 'groupe_id', 'contact_id');
    }
}
