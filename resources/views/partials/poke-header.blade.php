<div class="poke-header" data-reveal>

    <a href="/" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
        <img src="{{ asset('pokeball.png') }}" alt="PokeWiki" class="poke-logo-ball">
        <span class="poke-logo-text">PokeWiki</span>
    </a>

    <div class="poke-header-links">

        @unless(request()->is('pokemon'))
            <a href="/pokemon" class="poke-back-link">Pokemon</a>
        @endunless

        @unless(request()->is('about'))
            <a href="/about" class="poke-back-link">Acerca de</a>
        @endunless

    </div>

</div>
