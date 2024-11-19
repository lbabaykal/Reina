<script>
export default {
    name: "AuthHeader"
}
</script>

<template>
    <div class="w-full flex justify-around text-gray-500 shadow-md">
        <router-link :to="{ name: 'auth.login' }"
                     class="w-32 text-center py-2.5 border-b-2 border-transparent"
                     :class="$route.name === 'auth.login' ? '!border-rose-400 text-black' : 'hover:border-rose-400 hover:text-black'"
        >
            Вход
        </router-link>
        <router-link :to="{ name: 'auth.register' }"
                    class="w-32 text-center py-2.5 border-b-2 border-transparent"
                    :class="$route.name === 'auth.register' ? '!border-blue-400 text-black' : 'hover:border-blue-400 hover:text-black'"
        >
            Регистрации
        </router-link>
        <router-link :to="{ name: 'auth.password.request' }"
                     class="w-32 text-center py-2.5 border-b-2 border-transparent"
                     :class="$route.name === 'auth.password.request' ? '!border-green-400 text-black' : 'hover:border-green-400 hover:text-black'"
        >
            Сброс пароля
        </router-link>
    </div>
</template>
