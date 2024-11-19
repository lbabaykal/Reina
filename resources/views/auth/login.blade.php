@extends('layouts.auth')
@section('auth_title', config('app.name') . ' - Вход')
@section('auth_content')
    <section class="w-[500px] flex items-center shadow-2xl rounded-2xl flex-col overflow-hidden bg-white backdrop:blur-sm select-none">
        <x-auth-select></x-auth-select>

        <div class="w-full text-center py-8 font-bold text-3xl text-rose-500">
            {{ __('Авторизация') }}
        </div>

        <form class="flex flex-col items-center" action="{{ route('login') }}" method="POST">
            @csrf
            <input
                class="w-80 border-0 border-b-2 border-gray-500 bg-gray-100 py-1 my-3 text-center focus:border-rose-400 focus:ring-0"
                name="email"
                type="email"
                value="{{ old('email') }}"
                placeholder="{{ __('Email') }}"
                required
            />
            @error('email')
                <span class="mb-1 text-red-500 text-sm">
                    {{ $message }}
                </span>
            @enderror

            <input
                class="w-80 border-0 border-b-2 border-gray-500 bg-gray-100 py-1 my-3 text-center focus:border-rose-400 focus:ring-0"
                name="password"
                type="password"
                placeholder="{{ __('Пароль') }}"
                required
            />
            @error('password')
                <span class="mb-1 text-red-500 text-sm">
                    {{ $message }}
                </span>
            @enderror

            <button
                class="w-48 py-1 my-4 font-bold text-lg text-white bg-rose-700 hover:bg-rose-600 rounded-md"
                type="submit"
            >
                {{ __('Войти') }}
            </button>
        </form>

        <div class="w-full flex items-center text-black0 justify-around my-3">
            <hr class="w-40 h-0.5 bg-neutral-400" />
            {{ __('или') }}
            <hr class="w-40 h-0.5 bg-neutral-400" />
        </div>

        <x-auth-social></x-auth-social>

    </section>
@endsection
