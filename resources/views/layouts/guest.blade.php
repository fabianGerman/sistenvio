<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased" style="background: linear-gradient(to right, #24a4ee, #6ce2e2, #94cbe0, #b1ccd3); 
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
            {{ $slot }}
        </div>
    </body>
</html>
