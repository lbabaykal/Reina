<script>
import AuthWindow from "../../Components/Auth/AuthWindow.vue";

export default {
    name: "ForgotPasswordPage" ,
    components: {AuthWindowComponent: AuthWindow}
}
</script>

<template>
    <AuthWindowComponent>
        <div class="w-full text-center py-8 font-bold text-2xl text-green-500">
            Забыли пароль?
        </div>

        <div class="flex flex-col items-center">
            <input
                class="w-80 border-0 border-b-2 border-gray-500 bg-gray-100 py-1 my-3 text-center focus:border-rose-400 focus:ring-0"
                name="email"
                type="email"
                value="email"
                placeholder="Email"
                required
            />
            <span class="mb-1 text-red-500 text-sm">
            ERROR
        </span>

            <input
                class="w-80 border-0 border-b-2 border-gray-500 bg-gray-100 py-1 my-3 text-center focus:border-rose-400 focus:ring-0"
                name="password"
                type="password"
                placeholder="Пароль"
                required
            />
            <span class="mb-1 text-red-500 text-sm">
            ERROR
        </span>

            <button
                class="w-48 py-1 my-4 font-bold text-lg text-white bg-rose-700 hover:bg-rose-600 rounded-md"
                type="submit"
            >
                Войти
            </button>
        </div>
    </AuthWindowComponent>
</template>
