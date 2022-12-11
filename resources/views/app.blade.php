<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

{{--        <title inertia>{{ config('app.name', 'Laravel') }}</title>--}}

        <!-- Primary Meta Tags -->
        <title inertia>Simpeg</title>
        <meta name="title" content="Simpeg">
        <meta name="description" content=" Sistem Informasi Kepegawaian Tauke Sawit Dhea Putri Mustafa.">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta property="og:title" content="Simpeg">
        <meta property="og:description" content=" Sistem Informasi Kepegawaian Tauke Sawit Dhea Putri Mustafa.">
        <meta property="og:image" content="/meta-og-image.png">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ config('app.url') }}">
        <meta property="twitter:title" content="Simpeg">
        <meta property="twitter:description" content=" Sistem Informasi Kepegawaian Tauke Sawit Dhea Putri Mustafa.">
        <meta property="twitter:image" content="/meta-og-image.png">

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
