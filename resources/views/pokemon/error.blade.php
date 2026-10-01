@extends('layouts.app')

@section('content')

<div class="text-center py-5">

    <h1 class="fw-bold">
        Pokémon no encontrado
    </h1>

    <p class="text-muted mt-3">
        {{ $mensaje }}
    </p>

    <a href="/pokemon" class="btn btn-primary mt-3">
        Volver a Pokémon
    </a>

</div>

@endsection

