<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet">
        <title>{{ config('app.name') }}</title>
        @vite(["resources/css/app.css"])
    </head>
    <body class="w-full font-main antialiased grid h-screen place-items-center bg-gray-100">

        <div class="w-[500px] flex items-center shadow-2xl rounded-2xl flex-col overflow-hidden bg-white backdrop:blur-sm">
            <div class="w-full flex justify-around text-gray-500 shadow-md">
                <a href="#" class="w-36 text-center py-3 border-b-2 border-transparent hover:border-rose-400 hover:text-black">
                    {{ __('Вход') }}
                </a>
                <a href="#" class="w-36 text-center py-3 border-b-2 border-transparent hover:border-blue-500 hover:text-black">
                    {{ __('Регистрации') }}
                </a>
                <a href="#" class="w-36 text-center py-3 border-b-2 border-transparent  hover:border-green-400 hover:text-black">
                    {{ __('Забыли пароль?') }}
                </a>
            </div>
            <div class="w-full text-center py-6 font-bold text-3xl text-black">
                {{ __('Авторизация') }}
            </div>
            <form class="flex flex-col items-center" action="{{ route('auth.login') }}" method="POST">
                @csrf
                <input
                    class="w-80 border-0 border-b-2 border-gray-500 py-1 my-3 focus:border-rose-400 focus:ring-0 text-center"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="{{ __('Email') }}"
                    required
                />
                @error('email')
                    <span class="my-1 text-red-500">
                        {{ $message }} Неверный емаил
                    </span>
                @enderror

                <input
                    class="w-80 border-0 border-b-2 border-gray-500 py-1 my-3 focus:border-rose-400 focus:ring-0 text-center"
                    name="password"
                    type="password"
                    placeholder="{{ __('Пароль') }}"
                    required
                />
                @error('password')
                <span class="my-1 text-red-500">
                        {{ $message }} Пароль слишком короткий
                    </span>
                @enderror

                <button
                    class="w-48 py-1 my-5 font-bold text-lg text-white bg-rose-600 hover:bg-rose-700"
                    type="submit"
                >
                    {{ __('Войти') }}
                </button>
            </form>

            <div class="flex items-center text-gray-500">
                {{ __('или') }}
            </div>


            <div>
                Google Yandex
            </div>


        </div>

    </body>
</html>
