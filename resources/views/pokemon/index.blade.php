
@extends('layouts.app')

@section('content')

<div class="text-center mb-5">

    <h1 class="pixel-title fw-bold">
        Pokemon
    </h1>

    <p class="text-muted">
        Explora los Pokemon disponibles.
    </p>

</div>

<form action="/pokemon" method="GET" class="mb-5">

    <div class="input-group">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Buscar Pokemon por nombre"
            value="{{ $search ?? '' }}"
        >

        <button type="submit" class="btn btn-primary">
            Buscar
        </button>

    </div>

    @if($error)
        <div class="alert alert-danger mt-3">
            {{ $error }}
        </div>
    @endif

</form>

<div class="row g-4">

    @forelse($pokemons as $pokemon)

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">

            <div class="card h-100 text-center">

                @if($pokemon['imagen'])

                    <div class="pt-3">

                        <img
                            src="{{ $pokemon['imagen'] }}"
                            alt="{{ $pokemon['nombre'] }}"
                            style="width: 180px; height: 180px; object-fit: contain;"
                        >

                    </div>

                @endif

                <div class="card-body">

                    <h5 class="fw-bold text-capitalize">
                        {{ $pokemon['nombre'] }}
                    </h5>

                    <a
                        href="/pokemon/{{ $pokemon['nombre'] }}"
                        class="btn btn-primary mt-2"
                    >
                        Ver
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-warning text-center">
                No se encontro ningun Pokmon, por favor vuelve a intentar.
            </div>

        </div>

    @endforelse

</div>

@endsection
