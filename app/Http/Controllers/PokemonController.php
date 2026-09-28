<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller
{
    /**
     * GET /pokemons
     * GET /pokemons?q=char
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pokemon::query()->select('id', 'name');

        if ($request->filled('q')) {
            $search = strtolower($request->query('q'));
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        return response()->json($query->orderBy('id')->get());
    }

    /**
     * GET /pokemon/{id}
     */
    public function show(int $id): JsonResponse
    {
        $pokemon = Pokemon::query()
            ->select('pokemons.*', 'habitats.name as habitat_name')
            ->join('habitats', 'habitats.id', '=', 'pokemons.habitat_id')
            ->where('pokemons.id', $id)
            ->first();

        if (! $pokemon) {
            return response()->json(['message' => 'Pokemon no encontrado'], 404);
        }

        $types = DB::table('pokemon_type')
            ->join('types', 'types.id', '=', 'pokemon_type.type_id')
            ->where('pokemon_type.pokemon_id', $id)
            ->orderBy('types.id')
            ->pluck('types.name');

        return response()->json([
            'id' => $pokemon->id,
            'nombre' => $pokemon->name,
            'descripcion' => $pokemon->description,
            'tipos' => $types,
            'habitat' => $pokemon->habitat_name,
            'ataque' => $pokemon->attack,
            'defensa' => $pokemon->defense,
            'puntos_salud' => $pokemon->hp,
        ]);
    }
}
