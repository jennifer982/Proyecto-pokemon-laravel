<?php

namespace App\Http\Controllers;

use App\Models\SavedPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{

    public function index(Request $request)
    {
        return view('pokemon.index', [
            'search' => $request->query('search'),
        ]);
    }

    public function guardados()
    {
        return response()->json(
            SavedPokemon::orderBy('nombre')->get(['nombre', 'imagen'])->map(function ($pokemon) {
                return [
                    'name' => $pokemon->nombre,
                    'imagen' => $pokemon->imagen,
                ];
            })
        );
    }

    public function show($name)
    {
        $nombre = strtolower($name);

        $guardado = SavedPokemon::where('nombre', $nombre)->first();

        if ($guardado) {
            $pokemon = $this->fromSavedPokemon($guardado);
        } else {
            $response = Http::get(
                'https://pokeapi.co/api/v2/pokemon/' . $nombre
            );

            if (! $response->successful()) {
                return view('pokemon.error', [
                    'mensaje' => 'No se encontro el Pokemon solicitado.',
                    'bareLayout' => true,
                ]);
            }

            $pokemon = $this->shapePokemon($response->json());
        }

        $pokemon['movimientosPorMetodo'] = collect($pokemon['movimientos'])->groupBy('metodo');

        return view('pokemon.show', [
            'pokemon' => $pokemon,
            'estaGuardado' => (bool) $guardado,
            'bareLayout' => true,
        ]);
    }

    public function guardar($name)
    {
        $nombre = strtolower($name);

        if (SavedPokemon::where('nombre', $nombre)->exists()) {
            return response()->json(['guardado' => true]);
        }

        $response = Http::get(
            'https://pokeapi.co/api/v2/pokemon/' . $nombre
        );

        if (! $response->successful()) {
            return response()->json([
                'guardado' => false,
                'mensaje' => 'No se pudo obtener la informacion de Pokemon.',
            ], 422);
        }

        $pokemon = $this->shapePokemon($response->json());

        SavedPokemon::create([
            'pokeapi_id' => $pokemon['id'],
            'nombre' => $pokemon['nombre'],
            'imagen' => $pokemon['imagen'],
            'imagen_shiny' => $pokemon['imagenShiny'],
            'altura' => $pokemon['altura'],
            'peso' => $pokemon['peso'],
            'experiencia' => $pokemon['experiencia'],
            'tipos' => $pokemon['tipos'],
            'habilidades' => $pokemon['habilidades'],
            'stats' => $pokemon['stats'],
            'movimientos' => $pokemon['movimientos'],
        ]);

        return response()->json(['guardado' => true]);
    }

    private function shapePokemon(array $data): array
    {
        $artwork = $data['sprites']['other']['official-artwork'] ?? [];

        $stats = collect($data['stats'])->map(function ($stat) {
            return [
                'nombre' => $stat['stat']['name'],
                'valor' => $stat['base_stat'],
            ];
        })->values()->all();

        $movimientos = collect($data['moves'])->map(function ($move) {
            $detalle = end($move['version_group_details']);

            return [
                'nombre' => str_replace('-', ' ', $move['move']['name']),
                'metodo' => $detalle['move_learn_method']['name'],
                'nivel' => $detalle['level_learned_at'],
            ];
        })->sortBy('nivel')->values()->all();

        return [
            'id' => $data['id'],
            'nombre' => $data['name'],
            'imagen' => $artwork['front_default'] ?? $data['sprites']['front_default'],
            'imagenShiny' => $artwork['front_shiny'] ?? $data['sprites']['front_shiny'] ?? null,
            'tipos' => collect($data['types'])->pluck('type.name')->values()->all(),
            'habilidades' => collect($data['abilities'])->map(function ($ability) {
                return [
                    'nombre' => str_replace('-', ' ', $ability['ability']['name']),
                    'oculta' => $ability['is_hidden'],
                ];
            })->values()->all(),
            'altura' => $data['height'] / 10,
            'peso' => $data['weight'] / 10,
            'experiencia' => $data['base_experience'],
            'stats' => $stats,
            'movimientos' => $movimientos,
        ];
    }

    private function fromSavedPokemon(SavedPokemon $guardado): array
    {
        return [
            'id' => $guardado->pokeapi_id,
            'nombre' => $guardado->nombre,
            'imagen' => $guardado->imagen,
            'imagenShiny' => $guardado->imagen_shiny,
            'tipos' => $guardado->tipos,
            'habilidades' => $guardado->habilidades,
            'altura' => $guardado->altura,
            'peso' => $guardado->peso,
            'experiencia' => $guardado->experiencia,
            'stats' => $guardado->stats,
            'movimientos' => $guardado->movimientos,
        ];
    }
}
