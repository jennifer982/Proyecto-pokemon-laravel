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

