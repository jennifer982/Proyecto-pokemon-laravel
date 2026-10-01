
@extends('layouts.app')

@push('styles')
<style>

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

    .poke-skeleton .poke-card-img,
    .poke-skeleton .poke-card-name-bar {
        animation: poke-pulse 1.1s ease-in-out infinite;
    }

    .poke-skeleton .poke-card-name-bar {
        width: 70%;
        height: 12px;
        border-radius: 6px;
        background-color: #E6E6E6;
    }

    @keyframes poke-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
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

    <form id="poke-search-form" action="/pokemon" method="GET" class="poke-search">

        <svg class="poke-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>

        <input
            id="poke-search-input"
            type="text"
            name="search"
            placeholder="Buscar Pokémon..."
            value="{{ $search ?? '' }}"
            aria-label="Buscar Pokemon por nombre"
            autocomplete="off"
        >

    </form>

    <p class="poke-hint" id="poke-hint">
        Cargando Pokemon...
    </p>

</div>

<div class="poke-grid" id="poke-grid"></div>

@endsection

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {

        var SPRITE_BASE = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/';
        var LIST_URL = 'https://pokeapi.co/api/v2/pokemon?limit=1351&offset=0';
        var DEFAULT_COUNT = 20;
        var MAX_RESULTS = 60;

        var grid = document.getElementById('poke-grid');
        var hint = document.getElementById('poke-hint');
        var form = document.getElementById('poke-search-form');
        var input = document.getElementById('poke-search-input');

        var canAnimate = typeof gsap !== 'undefined'
            && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var allPokemon = [];
        var cardTween = null;

        var headerTl = canAnimate
            ? gsap.from('[data-reveal]', { opacity: 0, y: -12, duration: 0.4, ease: 'power2.out', stagger: 0.08 })
            : null;

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                if (headerTl) headerTl.progress(1);
                if (cardTween) cardTween.progress(1);
            }
        });

        function extractId(url) {
            var match = url.match(/\/pokemon\/(\d+)\/?$/);
            return match ? match[1] : null;
        }

        function cardHTML(pokemon) {
            return '<a href="/pokemon/' + pokemon.name + '" class="poke-card" data-card>'
                + '<div class="poke-card-img"><img src="' + SPRITE_BASE + pokemon.id + '.png" alt="' + pokemon.name + '" loading="lazy"></div>'
                + '<div class="poke-card-name">' + pokemon.name + '</div>'
                + '</a>';
        }

        function skeletonHTML() {
            return '<div class="poke-card poke-skeleton">'
                + '<div class="poke-card-img"></div>'
                + '<div class="poke-card-name"><div class="poke-card-name-bar"></div></div>'
                + '</div>';
        }

        function renderSkeleton(count) {
            grid.innerHTML = new Array(count).fill(skeletonHTML()).join('');
        }

        function render(list, emptyMessage) {

            if (!list.length) {
                grid.innerHTML = '';
                hint.textContent = emptyMessage;
                return;
            }

            hint.textContent = 'Resultados sugeridos';
            grid.innerHTML = list.map(cardHTML).join('');

            if (canAnimate) {
                cardTween = gsap.from('[data-card]', {
                    opacity: 0,
                    y: 16,
                    duration: 0.3,
                    ease: 'power1.out',
                    stagger: 0.02,
                });
            }
        }

        function filterAndRender(term) {

            var query = term.trim().toLowerCase();

            if (query === '') {
                render(allPokemon.slice(0, DEFAULT_COUNT));
                return;
            }

            var matches = allPokemon.filter(function (pokemon) {
                return pokemon.name.includes(query);
            });

            render(
                matches.slice(0, MAX_RESULTS),
                'No se encontro ningun Pokemon, por favor vuelve a intentar.'
            );
        }

        function updateUrl(term) {
            var url = new URL(window.location.href);

            if (term.trim() === '') {
                url.searchParams.delete('search');
            } else {
                url.searchParams.set('search', term);
            }

            window.history.replaceState({}, '', url);
        }

        renderSkeleton(DEFAULT_COUNT);

        fetch(LIST_URL)
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('request failed');
                }
                return response.json();
            })
            .then(function (data) {

                allPokemon = data.results
                    .map(function (pokemon) {
                        return { name: pokemon.name, id: extractId(pokemon.url) };
                    })
                    .filter(function (pokemon) {
                        return pokemon.id !== null;
                    });

                filterAndRender(input.value);
            })
            .catch(function () {
                grid.innerHTML = '';
                hint.textContent = 'No se pudo obtener la informacion de Pokemon.';
            });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            updateUrl(input.value);
            filterAndRender(input.value);
        });

        input.addEventListener('input', function () {
            updateUrl(input.value);
            filterAndRender(input.value);
        });

    });

</script>
@endpush
