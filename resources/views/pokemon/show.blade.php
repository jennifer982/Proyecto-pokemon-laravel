
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
        border: 1px solid #D8C9A3;
        border-radius: 999px;
        height: 10px;
        overflow: hidden;
    }

    .show-stat-fill {
        display: block;
        height: 100%;
        border-radius: 999px;
        background-color: var(--pw-white);
        box-shadow: 0 0 0 1px rgba(45, 45, 45, 0.08) inset;
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

    .save-float {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 20;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', Arial, sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: var(--pw-white);
        background-color: var(--pw-black);
        border: none;
        border-radius: 999px;
        padding: 14px 22px;
        box-shadow: 0 6px 16px rgba(45, 45, 45, 0.3);
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.2s ease;
    }

    .save-float:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(45, 45, 45, 0.35);
    }

    .save-float:active:not(:disabled) {
        transform: translateY(-1px) scale(0.97);
    }

    .save-float:disabled {
        cursor: default;
    }

    .save-float.is-saved {
        background-color: #3C9F5C;
    }

    .save-float.is-saving {
        opacity: 0.75;
    }

    .save-float-icon-check {
        display: none;
    }

    .save-float.is-saved .save-float-icon-save {
        display: none;
    }

    .save-float.is-saved .save-float-icon-check {
        display: block;
    }

</style>
@endpush

@section('content')

@include('partials.poke-header')

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

    <div class="show-section" data-reveal id="stats-section">

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

    @if($pokemon['movimientosPorMetodo']->isNotEmpty())

        <div class="show-section" data-reveal>

            <div class="show-section-title">Movimientos</div>

            <div class="show-moves-tabs" role="tablist">

                @foreach($pokemon['movimientosPorMetodo'] as $metodo => $lista)
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

            @foreach($pokemon['movimientosPorMetodo'] as $metodo => $lista)

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

<button
    type="button"
    id="save-button"
    class="save-float {{ $estaGuardado ? 'is-saved' : '' }}"
    data-name="{{ $pokemon['nombre'] }}"
    title="{{ $estaGuardado ? 'Guardado en base de datos' : 'Guardar en base de datos' }}"
    {{ $estaGuardado ? 'disabled' : '' }}
>

    <svg class="save-float-icon-save" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
        <polyline points="17 21 17 13 7 13 7 21"></polyline>
        <polyline points="7 3 7 8 15 8"></polyline>
    </svg>

    <svg class="save-float-icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
        <polyline points="20 6 9 17 4 12"></polyline>
    </svg>

    <span class="save-float-label">
        {{ $estaGuardado ? 'Guardado' : 'Guardar' }}
    </span>

</button>

@endsection

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {

        var canAnimate = typeof gsap !== 'undefined'
            && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var tl = null;

        if (canAnimate) {
            tl = gsap.timeline();
            tl.from('[data-reveal]', {
                opacity: 0,
                y: 18,
                duration: 0.4,
                ease: 'power2.out',
                stagger: 0.1,
            });
        }

        function fillStats(container) {
            container.querySelectorAll('[data-stat-fill]').forEach(function (bar) {
                requestAnimationFrame(function () {
                    bar.style.width = bar.dataset.value + '%';
                });
            });
        }

        var statsSection = document.getElementById('stats-section');

        if (statsSection) {
            if ('IntersectionObserver' in window) {
                var statsObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            fillStats(statsSection);
                            statsObserver.unobserve(statsSection);
                        }
                    });
                }, { threshold: 0.3 });
                statsObserver.observe(statsSection);
            } else {
                fillStats(statsSection);
            }
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

        var saveBtn = document.getElementById('save-button');

        if (saveBtn) {
            saveBtn.addEventListener('click', function () {

                saveBtn.disabled = true;
                saveBtn.classList.add('is-saving');

                var token = document.querySelector('meta[name="csrf-token"]').content;

                fetch('/pokemon/' + saveBtn.dataset.name + '/guardar', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {

                        saveBtn.classList.remove('is-saving');

                        if (data.guardado) {
                            saveBtn.classList.add('is-saved');
                            saveBtn.title = 'Guardado en base de datos';
                            saveBtn.querySelector('.save-float-label').textContent = 'Guardado';
                        } else {
                            saveBtn.disabled = false;
                            saveBtn.title = data.mensaje || 'No se pudo guardar';
                        }

                    })
                    .catch(function () {
                        saveBtn.disabled = false;
                        saveBtn.classList.remove('is-saving');
                        saveBtn.title = 'No se pudo guardar';
                    });

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
