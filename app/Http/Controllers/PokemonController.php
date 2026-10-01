<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{

    public function index(Request $request)
    {
        $response = Http::get(
            'https://pokeapi.co/api/v2/pokemon?limit=20'
        );

        if (! $response->successful()) {
            return view('pokemon.index', [
                'pokemons' => [],
                'search' => $request->query('search'),
                'error' => 'No se pudo obtener la informacion de Pokemon.',
            ]);
        }

        $data = $response->json();

        $pokemons = collect($data['results'])->map(function ($pokemon) {

            $detailResponse = Http::get($pokemon['url']);

            return [
                'nombre' => $pokemon['name'],
                'imagen' => $detailResponse->successful()
                    ? $detailResponse->json()['sprites']['front_default']
                    : null,
            ];

        })->toArray();

        $search = $request->query('search');
        $error = null;

        if ($request->has('search')) {

            if (trim($search) === '') {

                $error = 'Escribe un nombre de Pokemon para buscar.';

            } else {

                $pokemons = array_filter($pokemons, function ($pokemon) use ($search) {

                    return str_contains(
                        strtolower($pokemon['nombre']),
                        strtolower(trim($search))
                    );

                });
            }
        }

        return view(
            'pokemon.index',
            compact('pokemons', 'search', 'error')
        );
    }

    public function show($name)
    {
        $response = Http::get(
            'https://pokeapi.co/api/v2/pokemon/' . strtolower($name)
        );

        if (! $response->successful()) {
            return view('pokemon.error', [
                'mensaje' => 'No se encontro el Pokemon solicitado.',
            ]);
        }

        $data = $response->json();

        $pokemon = [
            'nombre' => $data['name'],
            'imagen' => $data['sprites']['front_default'],
            'tipos' => collect($data['types'])->map(function ($type) {
                return $type['type']['name'];
            })->toArray(),
            'hp' => $data['stats'][0]['base_stat'],
            'ataque' => $data['stats'][1]['base_stat'],
            'defensa' => $data['stats'][2]['base_stat'],
        ];

        return view('pokemon.show', compact('pokemon'));
    }
}

