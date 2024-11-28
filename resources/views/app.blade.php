<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/svg+xml" sizes="256x256" href="{{ asset('favicon.svg') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/js/app.js', "resources/css/app.css"])
    </head>
    <body id="app" class="w-full bg-black font-openSans text-white antialiased leading-none overflow-x-hidden overflow-y-auto">
    </body>
</html>
{{--Success--}}
{{--Error--}}
{{--Info--}}
{{--Warning--}}
