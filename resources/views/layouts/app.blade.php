
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PokeWiki</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <link
        href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #F5E6C4;
            color: #2D2D2D;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #2D2D2D !important;
            border-bottom: 5px solid #E53935;
        }

        .navbar-brand {
            color: #FFFFFF !important;
            font-family: 'Press Start 2P', cursive;
            font-size: 18px;
        }

        .btn-primary {
            background-color: #E53935;
            border-color: #E53935;
        }

        .btn-primary:hover {
            background-color: #c62828;
            border-color: #c62828;
        }

        .btn-outline-light:hover {
            color: #2D2D2D;
        }

        .card {
            background-color: #FFFFFF;
            border: 3px solid #2D2D2D;
            border-radius: 12px;
            box-shadow: 5px 5px 0px #2D2D2D !important;
        }

        h1,
        h2,
        h3 {
            color: #2D2D2D;
        }

        .pixel-title {
            font-family: 'Press Start 2P', cursive;
        }

    </style>
</head>

<body>

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
                    Pokémon
                </a>

                <a class="btn btn-outline-light" href="/about">
                    Acerca de
                </a>
            </div>

        </div>
    </nav>

    <main class="container py-4">

        @yield('content')

    </main>

</body>
</html>

