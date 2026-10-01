@extends('layouts.app')

@push('styles')
<style>

    .poke-error {
        min-height: calc(100vh - 90px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .poke-error-img {
        width: 200px;
        height: 200px;
        object-fit: contain;
        margin: 0 auto 20px;
        display: block;
    }

    .poke-error-title {
        font-family: 'Press Start 2P', cursive;
        font-size: 20px;
        color: var(--pw-black);
        text-align: center;
        margin-bottom: 14px;
    }

    .poke-error-message {
        text-align: center;
        color: #6B6B6B;
        max-width: 360px;
        margin: 0 auto 28px;
    }

    .poke-error-button-wrap {
        display: flex;
        justify-content: center;
    }

    .poke-error-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-family: 'Press Start 2P', cursive;
        font-size: 13px;
        color: var(--pw-black);
        background-color: var(--pw-white);
        border: 3px solid var(--pw-black);
        border-radius: 10px;
        padding: 14px 28px;
        box-shadow: 4px 4px 0px var(--pw-black);
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .poke-error-button:hover {
        color: var(--pw-black);
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px var(--pw-black);
    }

    .poke-error-button:active {
        transform: translate(1px, 1px);
        box-shadow: 2px 2px 0px var(--pw-black);
    }

    .poke-error-button svg {
        flex-shrink: 0;
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

<div class="poke-error">

    <div data-reveal>

        <img
            src="{{ asset('pikachu-confundido.png') }}"
            alt="Pikachu confundido"
            class="poke-error-img"
        >

        <h1 class="poke-error-title">
            Pokemon no encontrado
        </h1>

        <p class="poke-error-message">
            {{ $mensaje }}
        </p>

        <div class="poke-error-button-wrap">

            <a href="/pokemon" class="poke-error-button">

                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>

                Volver

            </a>

        </div>

    </div>

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

        var tl = gsap.from('[data-reveal]', {
            opacity: 0,
            y: 16,
            duration: 0.4,
            ease: 'power2.out',
            stagger: 0.1,
        });

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                tl.progress(1);
            }
        });

    });

</script>
@endpush
