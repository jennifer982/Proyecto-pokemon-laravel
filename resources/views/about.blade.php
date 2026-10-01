
@extends('layouts.app')

@push('styles')
<style>

    .about-wrap {
        max-width: 820px;
        margin: 0 auto;
        padding: 20px 24px 60px;
    }

</style>
@endpush

@section('content')

@include('partials.poke-header')

<div class="about-wrap">

<div class="text-center py-5">

    <h1 class="pixel-title mb-4">
        Acerca de PokeWiki
    </h1>

    <div class="card mx-auto p-4" style="max-width: 800px;">

        <div class="card-body">

            <h3 class="fw-bold mb-3">
                ¿Qué es PokeWiki?
            </h3>

            <p>
                PokeWiki es una pequeña Pokedex web creada con Laravel.
                Su objetivo es permitir consultar informacion de diferentes
                Pokémon de una manera sencilla, rapida y visual.
            </p>

            <hr>

            <h3 class="fw-bold mb-3">
                Datos curiosos
            </h3>

            <div class="row g-3 text-start">

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <strong>Pokemon originales</strong>
                        <p class="mb-0 mt-2 text-muted">
                            La primera generacion comenzo con 151 Pokemon.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <strong>Pokemon favorito</strong>
                        <p class="mb-0 mt-2 text-muted">
                            Pikachu es uno de los Pokemon mas reconocidos
                            de toda la franquicia.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <strong>Tipos Pokemon</strong>
                        <p class="mb-0 mt-2 text-muted">
                            Los Pokemon pueden pertenecer a uno o dos tipos.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <strong>Informacion en tiempo real</strong>
                        <p class="mb-0 mt-2 text-muted">
                            PokeWiki obtiene los datos utilizando PokeAPI.
                        </p>
                    </div>
                </div>

            </div>

            <hr class="my-4">

            <h3 class="fw-bold mb-3">
                Tecnologias utilizadas
            </h3>

            <div class="mb-4">

                <span class="badge bg-dark me-2 p-2">
                    Laravel
                </span>

                <span class="badge bg-danger me-2 p-2">
                    Bootstrap
                </span>

                <span class="badge bg-dark me-2 p-2">
                    PHP
                </span>

                <span class="badge bg-danger p-2">
                    PokeAPI
                </span>

            </div>

            <a href="/pokemon" class="btn btn-primary">
                Explorar Pokemon
            </a>

        </div>

    </div>

</div>

</div>

@endsection

