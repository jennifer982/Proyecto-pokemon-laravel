
<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/pokemon', [PokemonController::class, 'index']);

Route::get('/pokemon-guardados', [PokemonController::class, 'guardados']);

Route::get('/pokemon/{name}', [PokemonController::class, 'show']);

Route::post('/pokemon/{name}/guardar', [PokemonController::class, 'guardar']);

Route::get('/about', function () {
    return view('about', ['bareLayout' => true]);
});
