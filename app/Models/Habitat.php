<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitat extends Model
{
    protected $fillable = ['name'];

    public function pokemons(): HasMany
    {
        return $this->hasMany(Pokemon::class);
    }
}
