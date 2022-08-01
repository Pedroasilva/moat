<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="UTF-8">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="format-detection" content="telephone=no">

        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon/favicon-144x144.png') }}" sizes="144x144" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-16x16.png') }}" sizes="16x16" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-128x128.png') }}" sizes="128x128" />
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    </head>
    <body>

        @yield('content')

        <!-- Scripts -->
        <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
        <script src="{{ asset('assets/js/app.js') }}" defer></script>
    </body>
</html>
