
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PokeWiki</title>

    <link rel="icon" type="image/png" href="{{ asset('pokeball.png') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <style>

        :root {
            --pw-bg: #FEEECC;
            --pw-black: #2D2D2D;
            --pw-white: #FFFFFF;
            --pw-red: #E53935;
            --pw-red-dark: #c62828;
        }

        body {
            background-color: var(--pw-bg);
            color: var(--pw-black);
            font-family: 'Inter', Arial, sans-serif;
        }

        .navbar {
            background-color: var(--pw-black) !important;
            border-bottom: 5px solid var(--pw-red);
        }

        .navbar-brand {
            color: var(--pw-white) !important;
            font-family: 'Press Start 2P', cursive;
            font-size: 18px;
        }

        .navbar .btn-outline-light {
            font-family: 'Inter', Arial, sans-serif;
            font-weight: 600;
            transition: transform 0.15s ease, background-color 0.15s ease;
        }

        .navbar .btn-outline-light:hover {
            color: var(--pw-black);
            transform: translateY(-2px);
        }

        .navbar .btn-outline-light:active {
            transform: scale(0.95);
        }

        .btn-primary {
            background-color: var(--pw-red);
            border-color: var(--pw-red);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }

        .btn-primary:hover {
            background-color: var(--pw-red-dark);
            border-color: var(--pw-red-dark);
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: scale(0.95);
        }

        .btn-outline-light:hover {
            color: var(--pw-black);
        }

        .card {
            background-color: var(--pw-white);
            border: 3px solid var(--pw-black);
            border-radius: 12px;
            box-shadow: 5px 5px 0px var(--pw-black) !important;
        }

        h1,
        h2,
        h3 {
            color: var(--pw-black);
        }

        .pixel-title {
            font-family: 'Press Start 2P', cursive;
        }

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

        .poke-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            font-family: 'Inter', Arial, sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: var(--pw-black);
            text-decoration: none;
            transition: transform 0.15s ease;
        }

        .poke-back-link:hover {
            color: var(--pw-black);
            transform: translateX(-3px);
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

    </style>

    @stack('styles')
</head>

<body>

    @php
        $bareLayout = $bareLayout ?? (request()->is('/') || request()->is('pokemon'));
    @endphp

    @unless($bareLayout)

        <nav class="navbar navbar-dark">
            <div class="container">

                <a class="navbar-brand" href="/">
                    PokeWiki
                </a>

                <div>
                    <a class="btn btn-outline-light me-2" href="/">
                        Home
                    </a>

                    <a class="btn btn-outline-light me-2" href="/pokemon">
                        Pokemon
                    </a>

                    <a class="btn btn-outline-light" href="/about">
                        Acerca de
                    </a>
                </div>

            </div>
        </nav>

    @endunless

    <main class="{{ $bareLayout ? '' : 'container py-4' }}">

        @yield('content')

    </main>

    @stack('scripts')

</body>
</html>
