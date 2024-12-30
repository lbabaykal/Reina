<script>
import NoAvatar from "@/Components/Svg/NoAvatarSvg.vue";

export default {
    name: "LoginGuest",
    components: {NoAvatar},
}
</script>

<template>
    <div>
        <router-link :to="{ name: 'login' }"
                     class="group flex select-none flex-row transition-all duration-300 h-10 rounded-full bg-black/60
                     shadow shadow-blue-600 hover:bg-black hover:shadow-blue-600 hover:shadow-md"
        >
            <div class="flex flex-col justify-center text-nowrap text-center">
                <div class="font-bold text-lg px-6">
                    Вход | Регистрация
                </div>
            </div>
            <NoAvatar class="h-10 w-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(0,0,255)]"/>
        </router-link>
    </div>
</template>
