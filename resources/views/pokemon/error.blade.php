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

</style>
@endpush

@section('content')

@include('partials.poke-header')

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

            <a href="/pokemon" class="pw-button">

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
