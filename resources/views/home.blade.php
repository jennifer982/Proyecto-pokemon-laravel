
@extends('layouts.app')

@push('styles')
<style>

    .splash {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .splash-lockup {
        display: flex;
        align-items: center;
        gap: 28px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .splash-title {
        font-family: 'Press Start 2P', cursive;
        font-size: 48px;
        line-height: 1.5;
        color: var(--pw-black);
        text-align: left;
        margin: 0;
    }

    .splash-ball {
        width: 130px;
        height: 130px;
        object-fit: contain;
        transform-origin: center;
    }

    .splash-ball.is-ready {
        transition: transform 0.3s ease;
    }

    .splash-ball.is-ready:hover {
        transform: rotate(15deg) scale(1.05);
    }

    .splash-start-wrap {
        display: flex;
        justify-content: center;
        margin-top: 36px;
    }

    .splash-start {
        font-family: 'Press Start 2P', cursive;
        font-size: 14px;
        color: var(--pw-black);
        background-color: var(--pw-white);
        border: 3px solid var(--pw-black);
        border-radius: 10px;
        padding: 14px 32px;
        box-shadow: 4px 4px 0px var(--pw-black);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        text-decoration: none;
        display: inline-block;
    }

    .splash-start:hover {
        color: var(--pw-black);
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px var(--pw-black);
    }

    .splash-start:active {
        transform: translate(1px, 1px);
        box-shadow: 2px 2px 0px var(--pw-black);
    }

</style>
@endpush

@section('content')

<div class="splash">

    <div class="text-center">

        <div class="splash-lockup">

            <h1 class="splash-title" data-splash-title>
                Poke<br>Wiki
            </h1>

            <img
                src="{{ asset('pokeball.png') }}"
                alt="Pokeball"
                class="splash-ball"
                data-splash-ball
            >

        </div>

        <div class="splash-start-wrap">

            <a href="/pokemon" class="splash-start" data-splash-button>
                Iniciar
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

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (reduceMotion) {
            return;
        }

        var ball = document.querySelector('[data-splash-ball]');

        var tl = gsap.timeline({
            defaults: { ease: 'power2.out' },
            onComplete: function () {
                ball.classList.add('is-ready');
            }
        });

        tl.from('[data-splash-title]', { opacity: 0, y: 24, duration: 0.5 })
          .from(ball, { opacity: 0, scale: 0.4, rotate: -120, duration: 0.6, ease: 'back.out(1.7)' }, '-=0.3')
          .from('[data-splash-button]', { opacity: 0, y: 16, duration: 0.35 }, '-=0.15');

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                tl.progress(1);
            }
        });

    });

</script>
@endpush
