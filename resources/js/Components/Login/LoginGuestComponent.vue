<script>
import NoAvatar from "@/Components/Svg/NoAvatarSvg.vue";

export default {
    name: "LoginGuestComponent",
    components: {NoAvatar},
    props: {
        isScrolledHeader: Boolean,
    },
    watch: {
        isScrolledHeader() {
            // TODO Убрать или нет
            let menu = document.getElementById('menuGuest');

            if (this.isScrolledHeader) {
                // menu.classList.add('hover:bg-white/25');
                // menu.classList.remove('hover:bg-black');
            } else {
                // menu.classList.remove('hover:bg-white/25');
                // menu.classList.add('hover:bg-black');
            }
        },
    }
}
</script>

<template>
    <div>
        <a href="https://auth.reina.online/login"
           id="menuGuest"
           class="group flex select-none flex-row transition-all duration-300 h-[40px] rounded-full
           bg-black/60 hover:bg-black hover:shadow-blue-600 hover:shadow-md"
        >
            <div class="flex flex-col justify-center text-nowrap text-center">
                <div class="font-bold text-lg px-6">
                    Вход | Регистрация
                </div>
            </div>
            <NoAvatar class="h-10 w-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(0,0,255)]"/>
        </a>
    </div>
</template>
