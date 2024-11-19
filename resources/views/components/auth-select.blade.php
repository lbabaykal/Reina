<div class="w-full flex justify-around text-gray-500 shadow-md">
    <a href="#"
       class="w-36 text-center py-3 border-b-2 border-transparent
                    {{ Route::is('login') ? '!border-rose-400 text-black' : 'hover:border-rose-400 hover:text-black' }}
                   ">
        {{ __('Вход') }}
    </a>
    <a href="#"
       class="w-36 text-center py-3 border-b-2 border-transparent hover:border-blue-500 hover:text-black
                    {{ Route::is('register') ? '!border-blue-400 text-black' : 'hover:border-blue-400 hover:text-black' }}
                ">
        {{ __('Регистрации') }}
    </a>
    <a href="#"
       class="w-36 text-center py-3 border-b-2 border-transparent  hover:border-green-400 hover:text-black
                    {{ Route::is('password.request') ? '!border-green-400 text-black' : 'hover:border-green-400 hover:text-black' }}
                   ">
        {{ __('Забыли пароль?') }}
    </a>
</div>
