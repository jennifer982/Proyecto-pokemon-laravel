
@extends('layouts.app')

@section('content')

<div class="text-center">

    <h1 class="fw-bold text-capitalize">
        {{ $pokemon['nombre'] }}
    </h1>

    <div class="card mx-auto mt-4 shadow-sm" style="max-width: 500px;">

        <div class="card-body">

            <img
                src="{{ $pokemon['imagen'] }}"
                alt="{{ $pokemon['nombre'] }}"
                class="img-fluid"
                style="width: 200px;"
            >

            <h3 class="mt-3 text-capitalize">
                {{ $pokemon['nombre'] }}
            </h3>

            <h5 class="mt-4">
                Tipos
            </h5>

            <div class="mb-4">

                @foreach($pokemon['tipos'] as $tipo)

                    <span class="badge bg-primary text-capitalize me-1">
                        {{ $tipo }}
                    </span>

                @endforeach

            </div>

            <h5>
                Estadisticas
            </h5>

            <div class="row mt-3">

                <div class="col-4">
                    <div class="border rounded p-3">
                        <strong>HP</strong>
                        <br>
                        {{ $pokemon['hp'] }}
                    </div>
                </div>

                <div class="col-4">
                    <div class="border rounded p-3">
                        <strong>Ataque</strong>
                        <br>
                        {{ $pokemon['ataque'] }}
                    </div>
                </div>

                <div class="col-4">
                    <div class="border rounded p-3">
                        <strong>Defensa</strong>
                        <br>
                        {{ $pokemon['defensa'] }}
                    </div>
                </div>

            </div>

            <a href="/pokemon" class="btn btn-secondary mt-4">
                Volver
            </a>

        </div>

    </div>

</div>

@endsection

