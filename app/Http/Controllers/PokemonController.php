<?php

namespace App\Http\Controllers;

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

    public function show($name)
    {
        $response = Http::get(
            'https://pokeapi.co/api/v2/pokemon/' . strtolower($name)
        );

        if (! $response->successful()) {
            return view('pokemon.error', [
                'mensaje' => 'No se encontro el Pokemon solicitado.',
                'bareLayout' => true,
            ]);
        }

        $data = $response->json();

        $artwork = $data['sprites']['other']['official-artwork'] ?? [];

        $stats = collect($data['stats'])->map(function ($stat) {
            return [
                'nombre' => $stat['stat']['name'],
                'valor' => $stat['base_stat'],
            ];
        });

        $movimientos = collect($data['moves'])
            ->map(function ($move) {
                $detalle = end($move['version_group_details']);

                return [
                    'nombre' => str_replace('-', ' ', $move['move']['name']),
                    'metodo' => $detalle['move_learn_method']['name'],
                    'nivel' => $detalle['level_learned_at'],
                ];
            })
            ->sortBy('nivel')
            ->groupBy('metodo');

        $pokemon = [
            'id' => $data['id'],
            'nombre' => $data['name'],
            'imagen' => $artwork['front_default'] ?? $data['sprites']['front_default'],
            'imagenShiny' => $artwork['front_shiny'] ?? $data['sprites']['front_shiny'] ?? null,
            'tipos' => collect($data['types'])->pluck('type.name')->toArray(),
            'habilidades' => collect($data['abilities'])->map(function ($ability) {
                return [
                    'nombre' => str_replace('-', ' ', $ability['ability']['name']),
                    'oculta' => $ability['is_hidden'],
                ];
            }),
            'altura' => $data['height'] / 10,
            'peso' => $data['weight'] / 10,
            'experiencia' => $data['base_experience'],
            'stats' => $stats,
            'movimientos' => $movimientos,
        ];

        return view('pokemon.show', [
            'pokemon' => $pokemon,
            'bareLayout' => true,
        ]);
    }
}

