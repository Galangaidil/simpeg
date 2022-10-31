<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <!-- LeafletJS CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
              integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
              crossorigin=""/>

        <!-- LeafletJS JS -->
        <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
                integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
                crossorigin=""></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
