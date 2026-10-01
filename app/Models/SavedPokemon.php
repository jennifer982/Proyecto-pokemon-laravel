<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedPokemon extends Model
{
    protected $table = 'saved_pokemons';

    protected $fillable = [
        'pokeapi_id',
        'nombre',
        'imagen',
        'imagen_shiny',
        'altura',
        'peso',
        'experiencia',
        'tipos',
        'habilidades',
        'stats',
        'movimientos',
    ];

    protected $casts = [
        'altura' => 'float',
        'peso' => 'float',
        'tipos' => 'array',
        'habilidades' => 'array',
        'stats' => 'array',
        'movimientos' => 'array',
    ];
}
