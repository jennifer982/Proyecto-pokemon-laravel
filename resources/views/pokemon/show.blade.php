
@extends('layouts.app')

@php

    $typeColors = [
        'normal' => '#A8A878', 'fire' => '#F08030', 'water' => '#6890F0',
        'electric' => '#F8D030', 'grass' => '#78C850', 'ice' => '#98D8D8',
        'fighting' => '#C03028', 'poison' => '#A040A0', 'ground' => '#E0C068',
        'flying' => '#A890F0', 'psychic' => '#F85888', 'bug' => '#A8B820',
        'rock' => '#B8A038', 'ghost' => '#705898', 'dragon' => '#7038F8',
        'dark' => '#705848', 'steel' => '#B8B8D0', 'fairy' => '#EE99AC',
    ];

    $statLabels = [
        'hp' => 'HP', 'attack' => 'Ataque', 'defense' => 'Defensa',
        'special-attack' => 'At. especial', 'special-defense' => 'Def. especial',
        'speed' => 'Velocidad',
    ];

    $methodLabels = [
        'level-up' => 'Nivel', 'machine' => 'Maquina', 'egg' => 'Cria',
        'tutor' => 'Tutor',
    ];

    $mainColor = $typeColors[$pokemon['tipos'][0]] ?? '#888888';

@endphp

@push('styles')
<style>

    .show-header {
        display: flex;
        align-items: center;
        padding: 20px 24px 0;
    }

    .show-wrap {
        max-width: 820px;
        margin: 0 auto;
        padding: 20px 24px 60px;
    }

    .show-hero {
        background-color: var(--pw-white);
        border: 2px solid var(--pw-black);
        border-radius: 24px;
        padding: 28px 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .show-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, {{ $mainColor }}33, transparent 65%);
        pointer-events: none;
    }

    .show-id {
        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        color: #B0A58A;
    }

    .show-image-wrap {
        position: relative;
        width: 220px;
        height: 220px;
        margin: 10px auto 6px;
    }

    .show-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .show-image-wrap:hover .show-image {
        transform: scale(1.05) rotate(-2deg);
    }

    .show-tools {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .show-tool-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 2px solid var(--pw-black);
        border-radius: 999px;
        background-color: var(--pw-white);
        color: var(--pw-black);
        cursor: pointer;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    .show-tool-btn:hover {
        transform: translateY(-2px);
        background-color: #FFF4DA;
    }

    .show-tool-btn:active {
        transform: translateY(0) scale(0.92);
    }

    .show-tool-btn.is-active {
        background-color: #FFD24C;
    }

    .show-name {
        font-family: 'Press Start 2P', cursive;
        font-size: 24px;
        text-transform: capitalize;
        margin-bottom: 12px;
    }

    .show-types {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .show-type-badge {
        font-family: 'Inter', Arial, sans-serif;
        font-weight: 700;
        font-size: 12px;
        text-transform: capitalize;
        color: var(--pw-white);
        padding: 6px 16px;
        border-radius: 999px;
        border: 2px solid var(--pw-black);
    }

    .show-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 26px;
    }

    .show-meta-box {
        background-color: var(--pw-white);
        border: 2px solid var(--pw-black);
        border-radius: 14px;
        padding: 14px 8px;
        text-align: center;
    }

    .show-meta-label {
        font-size: 11px;
        color: #9A8B6F;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .show-meta-value {
        font-family: 'Press Start 2P', cursive;
        font-size: 14px;
        margin-top: 6px;
    }

    .show-section {
        margin-top: 28px;
    }

    .show-section-title {
        font-family: 'Press Start 2P', cursive;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .show-abilities {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .show-ability-badge {
        font-size: 13px;
        text-transform: capitalize;
        background-color: var(--pw-white);
        border: 2px solid var(--pw-black);
        border-radius: 999px;
        padding: 6px 14px;
    }

    .show-ability-badge.is-hidden {
        background-color: #FFF4DA;
        border-style: dashed;
    }

    .show-stat-row {
        display: grid;
        grid-template-columns: 110px 1fr 36px;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .show-stat-label {
        font-weight: 600;
        color: #6B6B6B;
    }

    .show-stat-track {
        background-color: #EDE3CC;
        border-radius: 999px;
        height: 10px;
        overflow: hidden;
    }

    .show-stat-fill {
        height: 100%;
        border-radius: 999px;
        background-color: {{ $mainColor }};
        width: 0%;
        transition: width 1s ease;
    }

    .show-stat-value {
        text-align: right;
        font-weight: 700;
    }

    .show-moves-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
    }

    .show-moves-tab {
        font-family: 'Inter', Arial, sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--pw-black);
        background-color: var(--pw-white);
        border: 2px solid var(--pw-black);
        border-radius: 999px;
        padding: 6px 16px;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.15s ease;
    }

    .show-moves-tab:hover {
        transform: translateY(-2px);
    }

    .show-moves-tab.is-active {
        background-color: var(--pw-black);
        color: var(--pw-white);
    }

    .show-moves-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .show-moves-panel {
        display: none;
    }

    .show-moves-panel.is-active {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .show-move-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        text-transform: capitalize;
        background-color: var(--pw-white);
        border: 2px solid var(--pw-black);
        border-radius: 10px;
        padding: 6px 12px;
    }

    .show-move-pill svg {
        flex-shrink: 0;
        color: {{ $mainColor }};
    }

    .show-move-level {
        font-size: 11px;
        color: #9A8B6F;
    }

    .show-back-wrap {
        display: flex;
        justify-content: center;
        margin-top: 34px;
    }

</style>
@endpush

@section('content')

<div class="show-header" data-reveal>

    <a href="/" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
        <img src="{{ asset('pokeball.png') }}" alt="PokeWiki" class="poke-logo-ball">
        <span class="poke-logo-text">PokeWiki</span>
    </a>

    <a href="/pokemon" class="poke-back-link">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>

        Pokemon

    </a>

</div>

<div class="show-wrap">

    <div class="show-hero" data-reveal>

        <div class="show-id">#{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}</div>

        <div class="show-image-wrap">
            <img
                src="{{ $pokemon['imagen'] }}"
                alt="{{ $pokemon['nombre'] }}"
                class="show-image"
                id="show-image"
                data-normal="{{ $pokemon['imagen'] }}"
                data-shiny="{{ $pokemon['imagenShiny'] }}"
            >
        </div>

        <div class="show-tools">

            @if($pokemon['imagenShiny'])
                <button type="button" class="show-tool-btn" id="shiny-toggle" title="Ver version shiny" aria-pressed="false">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.8 6.2L20 10l-6.2 1.8L12 18l-1.8-6.2L4 10l6.2-1.8L12 2z"></path></svg>
                </button>
            @endif

        </div>

        <h1 class="show-name">{{ $pokemon['nombre'] }}</h1>

        <div class="show-types">

            @foreach($pokemon['tipos'] as $tipo)
                <span class="show-type-badge" style="background-color: {{ $typeColors[$tipo] ?? '#888888' }};">
                    {{ $tipo }}
                </span>
            @endforeach

        </div>

        <div class="show-meta">

            <div class="show-meta-box">
                <div class="show-meta-label">Altura</div>
                <div class="show-meta-value">{{ $pokemon['altura'] }} m</div>
            </div>

            <div class="show-meta-box">
                <div class="show-meta-label">Peso</div>
                <div class="show-meta-value">{{ $pokemon['peso'] }} kg</div>
            </div>

            <div class="show-meta-box">
                <div class="show-meta-label">Exp. base</div>
                <div class="show-meta-value">{{ $pokemon['experiencia'] }}</div>
            </div>

        </div>

    </div>

    <div class="show-section" data-reveal>

        <div class="show-section-title">Habilidades</div>

        <div class="show-abilities">

            @foreach($pokemon['habilidades'] as $habilidad)
                <span class="show-ability-badge {{ $habilidad['oculta'] ? 'is-hidden' : '' }}">
                    {{ $habilidad['nombre'] }}
                    @if($habilidad['oculta'])
                        (oculta)
                    @endif
                </span>
            @endforeach

        </div>

    </div>

    <div class="show-section" data-reveal>

        <div class="show-section-title">Estadisticas</div>

        @foreach($pokemon['stats'] as $stat)

            <div class="show-stat-row">
                <span class="show-stat-label">{{ $statLabels[$stat['nombre']] ?? $stat['nombre'] }}</span>
                <span class="show-stat-track">
                    <span class="show-stat-fill" data-stat-fill data-value="{{ min(100, round($stat['valor'] / 200 * 100)) }}"></span>
                </span>
                <span class="show-stat-value">{{ $stat['valor'] }}</span>
            </div>

        @endforeach

    </div>

    @if($pokemon['movimientos']->isNotEmpty())

        <div class="show-section" data-reveal>

            <div class="show-section-title">Movimientos</div>

            <div class="show-moves-tabs" role="tablist">

                @foreach($pokemon['movimientos'] as $metodo => $lista)
                    <button
                        type="button"
                        class="show-moves-tab {{ $loop->first ? 'is-active' : '' }}"
                        data-moves-tab="{{ $metodo }}"
                        role="tab"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    >
                        {{ $methodLabels[$metodo] ?? ucfirst($metodo) }}
                        <span style="opacity:.6;">({{ $lista->count() }})</span>
                    </button>
                @endforeach

            </div>

            @foreach($pokemon['movimientos'] as $metodo => $lista)

                <div class="show-moves-panel {{ $loop->first ? 'is-active' : '' }}" data-moves-panel="{{ $metodo }}">

                    @foreach($lista as $movimiento)
                        <span class="show-move-pill">

                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.4 7.4L12 16.8 5.6 21.4 8 14 2 9.4h7.6z"></path></svg>

                            {{ $movimiento['nombre'] }}

                            @if($metodo === 'level-up' && $movimiento['nivel'] > 0)
                                <span class="show-move-level">Nv. {{ $movimiento['nivel'] }}</span>
                            @endif

                        </span>
                    @endforeach

                </div>

            @endforeach

        </div>

    @endif

    <div class="show-back-wrap">

        <a href="/pokemon" class="pw-button">

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>

            Volver

        </a>

    </div>

</div>

@endsection

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {

        var canAnimate = typeof gsap !== 'undefined'
            && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var tl = null;

        function animateStats() {
            document.querySelectorAll('[data-stat-fill]').forEach(function (bar) {
                requestAnimationFrame(function () {
                    bar.style.width = bar.dataset.value + '%';
                });
            });
        }

        if (canAnimate) {
            tl = gsap.timeline({ onComplete: animateStats });
            tl.from('[data-reveal]', {
                opacity: 0,
                y: 18,
                duration: 0.4,
                ease: 'power2.out',
                stagger: 0.1,
            });
        } else {
            animateStats();
        }

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden && tl) {
                tl.progress(1);
            }
        });

        var shinyBtn = document.getElementById('shiny-toggle');
        var image = document.getElementById('show-image');

        if (shinyBtn && image) {
            shinyBtn.addEventListener('click', function () {
                var showingShiny = shinyBtn.classList.toggle('is-active');
                shinyBtn.setAttribute('aria-pressed', showingShiny ? 'true' : 'false');
                image.src = showingShiny ? image.dataset.shiny : image.dataset.normal;
            });
        }

        document.querySelectorAll('[data-moves-tab]').forEach(function (tab) {
            tab.addEventListener('click', function () {

                var method = tab.dataset.movesTab;

                document.querySelectorAll('[data-moves-tab]').forEach(function (t) {
                    t.classList.toggle('is-active', t === tab);
                    t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
                });

                document.querySelectorAll('[data-moves-panel]').forEach(function (panel) {
                    panel.classList.toggle('is-active', panel.dataset.movesPanel === method);
                });

            });
        });

    });

</script>
@endpush
