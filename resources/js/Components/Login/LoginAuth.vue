<script>
import LogoutSvg from "@/Components/Svg/LogoutSvg.vue";
import SettingsSvg from "@/Components/Svg/SettingsSvg.vue";
import FavoriteSvg from "@/Components/Svg/FavoriteSvg.vue";
import SubscribeSvg from "@/Components/Svg/SubscribeSvg.vue";
import ProfileSvg from "@/Components/Svg/ProfileSvg.vue";
import AdminPanelSvg from "@/Components/Svg/AdminPanelSvg.vue";

export default {
    name: "LoginAuth",
    components: { AdminPanelSvg, ProfileSvg, SubscribeSvg, FavoriteSvg, SettingsSvg, LogoutSvg},
    data() {
        return {
            isDropdownUserMenu: false,
        }
    },
    props: {
        dataUser: null,
    },
    methods: {
        toggleUserMenu() {
            this.isDropdownUserMenu = !this.isDropdownUserMenu;
        },
    },
    computed: {
        showWelcomeMessage() {
            let currentHour = new Date().getHours();
            let message = '';

            switch (true) {
                case currentHour >= 6 && currentHour < 12:
                    message = 'Доброе утро, ';
                    break;
                case currentHour >= 12 && currentHour < 18:
                    message = 'Добрый день, ';
                    break;
                case currentHour >= 18 && currentHour <= 23:
                    message = 'Добрый вечер, ';
                    break;
                case currentHour >= 0 && currentHour < 6:
                    message = 'Доброй ночи, ';
                    break;
                default:
                    message = 'Здравствуйте, ';
                    break;
            }

            return message;
        },
    },
}
</script>

<template>
    <div>
        <div id="menuAuth"
             @click="toggleUserMenu"
             class="group flex cursor-pointer select-none flex-row transition-all duration-300 h-[40px] rounded-full
             bg-black/60 hover:bg-black hover:shadow-red-600 hover:shadow-md"
        >
            <div class="relative flex flex-col justify-center text-nowrap text-center">
                <div class="truncate max-w-80 px-6 text-lg">
                    <span class="text-white">{{ showWelcomeMessage }}</span>
                    <span class="text-red-500 font-bold">{{ dataUser.name }}</span>
                </div>
            </div>
            <img :src="`${dataUser.avatar}`"
                 class="h-10 w-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(255,0,0)]"
                 :alt="`${dataUser.name}`"
            >
        </div>

        <div v-show="isDropdownUserMenu"
             class="absolute right-14 top-[60px] w-72 select-none rounded bg-gray-900 shadow-[0_5px_10px_0_rgba(0,0,0,0.7)]"
        >
            <div class="flex items-center border-b-2 border-b-blue-600">
                <img :src="`${dataUser.avatar}`"
                     class="m-3 h-16 w-16 rounded-full bg-cover bg-center"
                     :alt="`${dataUser.name}`"
                >
                <div class="flex-row w-[200px]">
                    <div class="truncate text-xl font-bold">{{ dataUser.name }}</div>
                    <div class="truncate text-lg text-red-500">
                        Администратор
                    </div>
                </div>
            </div>

            <div class="flex flex-col text-lg">
                <RouterLink :to="{ name: 'admin' }"
                            class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <AdminPanelSvg classes="m-1.5 h-8 w-8 group-hover:stroke-fuchsia-700"/>
                    <span class="ml-2 group-hover:text-black">
                        Admin_Panel
                    </span>
                </RouterLink>
<!--                <a href="https://admin.reina.online"-->
<!--                   class="group flex flex-row items-center px-4 hover:bg-gray-100"-->
<!--                >-->
<!--                    <AdminPanelSvg classes="m-1.5 h-8 w-8 group-hover:stroke-fuchsia-700"/>-->
<!--                    <span class="ml-2 group-hover:text-black">-->
<!--                        Admin_Panel-->
<!--                    </span>-->
<!--                </a>-->
                <a href="#"
                   class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <ProfileSvg classes="m-1.5 h-8 w-8 fill-none stroke-lime-500 group-hover:fill-lime-500 group-hover:stroke-lime-500"/>
                    <span class="ml-2 group-hover:text-black">
                        Профиль
                    </span>
                </a>
                <a href="{{ route('user.subscription.index') }}"
                   class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <SubscribeSvg classes="m-1.5 w-8 h-8 group-hover:drop-shadow-[0_0_6px_rgba(255,0,0,1)]"/>
                    <span class="ml-2 group-hover:text-black">
                        Подписка
                    </span>
                </a>
                <a href="{{ route('user.folders.index') }}"
                   class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <FavoriteSvg classes="m-1.5 h-8 w-8 fill-none stroke-red-500 group-hover:fill-red-500 group-hover:stroke-red-500"/>
                    <span class="ml-2 group-hover:text-black">
                        Избранное
                    </span>
                </a>
                <a href="#"
                   class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <SettingsSvg classes="m-1.5 h-8 w-8 fill-none stroke-blue-600 group-hover:fill-blue-600 group-hover:stroke-blue-600"/>
                    <span class="ml-2 group-hover:text-black">
                        Настройки
                    </span>
                </a>
                <router-link :to="{name: 'auth.logout'}"
                             class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <LogoutSvg classes="m-1.5 h-8 w-8 group-hover:stroke-black"/>
                    <span class="ml-2 group-hover:text-black">
                        Выход
                    </span>
                </router-link>
            </div>
        </div>
    </div>
</template>
