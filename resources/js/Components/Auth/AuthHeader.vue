<script>
export default {
    name: 'AuthHeader',
};
</script>

<template>
    <div class="flex w-full justify-around text-gray-500 shadow-md">
        <router-link
            :to="{ name: 'login' }"
            class="w-36 border-b-2 border-transparent py-3 text-center"
            :class="$route.name === 'login' ? 'border-rose-400! text-black' : 'hover:border-rose-400 hover:text-black'"
        >
            Вход
        </router-link>
        <router-link
            :to="{ name: 'register' }"
            class="w-36 border-b-2 border-transparent py-3 text-center"
            :class="$route.name === 'register' ? 'border-sky-400! text-black' : 'hover:border-sky-400 hover:text-black'"
        >
            Регистрации
        </router-link>
        <router-link
            :to="{ name: 'password.request' }"
            class="w-36 border-b-2 border-transparent py-3 text-center"
            :class="$route.name === 'password.request' ? 'border-green-400! text-black' : 'hover:border-green-400 hover:text-black'"
        >
            Восстановление
        </router-link>
    </div>
</template>
