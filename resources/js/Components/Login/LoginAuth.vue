<script>

import AdminPanelSvg from "../Svg/AdminPanelSvg.vue";
import ProfileSvg from "../Svg/ProfileSvg.vue";
import SubscribeSvg from "../Svg/SubscribeSvg.vue";
import FavoriteSvg from "../Svg/FavoriteSvg.vue";
import SettingsSvg from "../Svg/SettingsSvg.vue";
import LogoutSvg from "../Svg/LogoutSvg.vue";

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
    <div id="menuAuth"
         @click="toggleUserMenu"
         class="group flex cursor-pointer select-none flex-row transition-all duration-300 h-10 rounded-full
         bg-black/60 shadow shadow-red-600 hover:bg-black hover:shadow-red-600 hover:shadow-md"
    >
        <div class="relative flex flex-col justify-center text-nowrap text-center">
            <div class="truncate max-w-80 px-6 text-lg">
                <span class="text-white">{{ showWelcomeMessage }}</span>
                <span class="text-red-500 font-bold">{{ dataUser.name }}</span>
            </div>
        </div>
        <img :src="dataUser.avatar"
             class="size-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(255,0,0)]"
             :alt="dataUser.name"
        >
    </div>

    <div v-show="isDropdownUserMenu"
         class="absolute right-14 top-15 w-72 select-none rounded overflow-hidden bg-blackSimple shadow-modals"
    >
        <div class="flex items-center border-b-2 border-b-blue-600">
            <img :src="dataUser.avatar"
                 class="m-3 size-16 rounded-full bg-cover bg-center"
                 :alt="dataUser.name"
            >
            <div class="flex-row w-[200px]">
                <div class="truncate text-xl font-bold">{{ dataUser.name }}</div>
                <div class="truncate text-lg text-red-500">
                    Администратор
                </div>
            </div>
        </div>

        <div @click="toggleUserMenu"
             class="flex flex-col text-lg"
        >
            <RouterLink :to="{ name: 'admin' }"
                        class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <AdminPanelSvg classes="m-1.5 size-8 group-hover:stroke-fuchsia-700"/>
                <span class="ml-2 group-hover:text-black">
                    Admin_Panel
                </span>
            </RouterLink>
            <RouterLink to=""
               class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <ProfileSvg classes="m-1.5 size-8 fill-none stroke-lime-500 group-hover:fill-lime-500 group-hover:stroke-lime-500"/>
                <span class="ml-2 group-hover:text-black">
                    Профиль
                </span>
            </RouterLink>
            <RouterLink :to="{name: 'subscription'}"
                         class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <SubscribeSvg classes="m-1.5 size-8 group-hover:drop-shadow-[0_0_6px_rgba(255,0,0,1)]"/>
                <span class="ml-2 group-hover:text-black">
                    Подписка
                </span>
            </RouterLink>
            <RouterLink :to="{name: 'favorites.index'}"
               class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <FavoriteSvg classes="m-1.5 size-8 fill-none stroke-red-500 group-hover:fill-red-500 group-hover:stroke-red-500"/>
                <span class="ml-2 group-hover:text-black">
                    Избранное
                </span>
            </RouterLink>
            <RouterLink to=""
               class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <SettingsSvg classes="m-1.5 size-8 fill-none stroke-blue-600 group-hover:fill-blue-600 group-hover:stroke-blue-600"/>
                <span class="ml-2 group-hover:text-black">
                    Настройки
                </span>
            </RouterLink>
            <RouterLink :to="{name: 'logout'}"
                         class="group flex flex-row items-center px-4 hover:bg-gray-100"
            >
                <LogoutSvg classes="m-1.5 size-8 group-hover:stroke-black"/>
                <span class="ml-2 group-hover:text-black">
                    Выход
                </span>
            </RouterLink>
        </div>
    </div>
</template>
