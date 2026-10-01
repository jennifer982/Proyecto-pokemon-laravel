
<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/pokemon', [PokemonController::class, 'index']);

Route::get('/pokemon/{name}', [PokemonController::class, 'show']);

Route::get('/about', function () {
    return view('about');
});
