<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}">
    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="w-full bg-black font-main text-white antialiased">
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

</body>
</html>

<script>
    window.onload = function(){
        window.dispatchEvent(new Event("scroll"));
    }

    window.addEventListener("scroll",function() {
        let header = document.getElementById('header');
        let menu = document.getElementById('MenuDropdownButton');

        if (window.scrollY > 60) {
            // header.classList.add('!bg-black', 'shadow-md', 'shadow-red-600/50');
            header.classList.add('header-change');
            menu.classList.add('hover:bg-white/25');
            menu.classList.remove('hover:bg-black');
        } else {
            header.classList.remove('header-change');
            menu.classList.remove('hover:bg-white/25');
            menu.classList.add('hover:bg-black');
        }
    });
</script>
