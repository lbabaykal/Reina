<script>
import NoAvatarSvg from '../Svg/NoAvatarSvg.vue';

export default {
    name: 'LoginGuest',
    components: { NoAvatarSvg },
};
</script>

<template>
    <div>
        <router-link
            :to="{ name: 'login' }"
            class="group flex h-10 flex-row rounded-full bg-black/60 shadow shadow-blue-600 transition-all duration-300 select-none hover:bg-black hover:shadow-md hover:shadow-blue-600"
        >
            <div class="flex flex-col justify-center text-center text-nowrap">
                <div class="px-6 text-lg font-bold">Вход | Регистрация</div>
            </div>
            <NoAvatarSvg class="h-10 w-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(0,0,255)]" />
        </router-link>
    </div>
</template>
