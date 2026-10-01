
@extends('layouts.app')

@push('styles')
<style>

    .poke-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px 24px 0;
    }

    .poke-logo-ball {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }

    .poke-logo-text {
        font-family: 'Press Start 2P', cursive;
        font-size: 16px;
        color: var(--pw-black);
        text-decoration: none;
    }

    .poke-search-wrap {
        max-width: 560px;
        margin: 28px auto 6px;
        padding: 0 24px;
    }

    .poke-search {
        position: relative;
    }

    .poke-search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #9A9A9A;
        pointer-events: none;
    }

    .poke-search input {
        width: 100%;
        border: 2px solid var(--pw-black);
        border-radius: 999px;
        padding: 12px 20px 12px 46px;
        font-family: 'Inter', Arial, sans-serif;
        font-size: 15px;
        background-color: var(--pw-white);
        outline: none;
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    .poke-search input:focus {
        box-shadow: 0 0 0 4px rgba(45, 45, 45, 0.12);
        transform: translateY(-1px);
    }

    .poke-hint {
        text-align: center;
        font-size: 12px;
        color: #9A8B6F;
        margin-top: 8px;
    }

    .poke-grid {
        padding: 10px 24px 48px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .poke-card {
        display: flex;
        flex-direction: column;
        height: 210px;
        text-decoration: none;
        color: var(--pw-black);
        border: 2px solid var(--pw-black);
        border-radius: 20px;
        overflow: hidden;
        background-color: var(--pw-white);
        padding: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .poke-card:hover {
        transform: translateY(-4px);
        box-shadow: 4px 4px 0px var(--pw-black);
    }

    .poke-card:active {
        transform: translateY(-1px) scale(0.98);
    }

    .poke-card-img {
        background-color: #E6E6E6;
        height: 130px;
        flex-shrink: 0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: background-color 0.2s ease;
    }

    .poke-card:hover .poke-card-img {
        background-color: #DADADA;
    }

    .poke-card-img img {
        max-width: 72%;
        max-height: 72%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .poke-card:hover .poke-card-img img {
        transform: scale(1.08);
    }

    .poke-card-name {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        text-align: center;
        text-transform: capitalize;
        padding: 14px 4px 4px;
    }

</style>
@endpush

@section('content')

<div class="poke-header" data-reveal>

    <a href="/" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
        <img src="{{ asset('pokeball.png') }}" alt="PokeWiki" class="poke-logo-ball">
        <span class="poke-logo-text">PokeWiki</span>
    </a>

</div>

<div class="poke-search-wrap" data-reveal>

    <form action="/pokemon" method="GET" class="poke-search">

        <svg class="poke-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>

        <input
            type="text"
            name="search"
            placeholder="Buscar Pokémon..."
            value="{{ $search ?? '' }}"
            aria-label="Buscar Pokemon por nombre"
        >

    </form>

    <p class="poke-hint">
        @if($error)
            {{ $error }}
        @else
            Resultados sugeridos
        @endif
    </p>

</div>

<div class="poke-grid">

    @forelse($pokemons as $pokemon)

        <a href="/pokemon/{{ $pokemon['nombre'] }}" class="poke-card" data-card>

            <div class="poke-card-img">

                @if($pokemon['imagen'])
                    <img src="{{ $pokemon['imagen'] }}" alt="{{ $pokemon['nombre'] }}" loading="lazy">
                @endif

            </div>

            <div class="poke-card-name">
                {{ $pokemon['nombre'] }}
            </div>

        </a>

    @empty

        <div class="poke-hint" style="grid-column: 1 / -1;">
            No se encontro ningun Pokemon, por favor vuelve a intentar.
        </div>

    @endforelse

</div>

@endsection

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {

        if (typeof gsap === 'undefined') {
            return;
        }

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        var tl = gsap.timeline();

        tl.from('[data-reveal]', {
            opacity: 0,
            y: -12,
            duration: 0.4,
            ease: 'power2.out',
            stagger: 0.08,
        });

        tl.from('[data-card]', {
            opacity: 0,
            y: 16,
            duration: 0.35,
            ease: 'power1.out',
            stagger: 0.03,
        }, '-=0.1');

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                tl.progress(1);
            }
        });

    });

</script>
@endpush
