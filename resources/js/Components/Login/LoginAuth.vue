<script>
import AdminPanelSvg from '../Svg/AdminPanelSvg.vue';
import ProfileSvg from '../Svg/ProfileSvg.vue';
import SubscribeSvg from '../Svg/SubscribeSvg.vue';
import FavoriteSvg from '../Svg/FavoriteSvg.vue';
import SettingsSvg from '../Svg/SettingsSvg.vue';
import LogoutSvg from '../Svg/LogoutSvg.vue';
import { useAuthStore } from '../../Stores/authStore.js';

export default {
    name: 'LoginAuth',
    components: { AdminPanelSvg, ProfileSvg, SubscribeSvg, FavoriteSvg, SettingsSvg, LogoutSvg },
    data() {
        return {
            dataUser: useAuthStore().user,
            isDropdownUserMenu: false,
        };
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
};
</script>

<template>
    <div
        id="menuAuth"
        @click="toggleUserMenu"
        class="group flex h-10 cursor-pointer flex-row rounded-full bg-black/60 shadow shadow-red-600 transition-all duration-300 select-none hover:bg-black hover:shadow-md hover:shadow-red-600"
    >
        <div class="relative flex min-w-60 flex-col justify-center text-center text-nowrap">
            <div class="max-w-80 truncate px-4 text-lg">
                <span class="text-white">{{ showWelcomeMessage }}</span>
                <span class="font-bold text-red-500">{{ dataUser.name }}</span>
            </div>
        </div>
        <img
            :src="dataUser.avatar"
            class="size-10 rounded-full bg-cover bg-center duration-300 group-hover:drop-shadow-[0_0_16px_rgb(255,0,0)]"
            :alt="dataUser.name"
        />
    </div>

    <div
        v-show="isDropdownUserMenu"
        class="dark:shadow-modals-black shadow-modals-white bg-whiteSimple dark:bg-blackSimple absolute top-15 right-14 w-72 overflow-hidden rounded-md select-none"
    >
        <div class="flex items-center border-b-2 border-b-blue-600">
            <img
                :src="dataUser.avatar"
                class="m-3 size-16 rounded-full bg-cover bg-center"
                :alt="dataUser.name"
            />
            <div class="w-50 flex-row">
                <div class="truncate text-xl font-bold">{{ dataUser.name }}</div>
                <div class="truncate text-lg text-red-500">Администратор</div>
            </div>
        </div>

        <div
            @click="toggleUserMenu"
            class="flex flex-col text-lg"
        >
            <RouterLink
                :to="{ name: 'admin' }"
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <AdminPanelSvg classes="m-1.5 size-8 group-hover:stroke-fuchsia-700" />
                <span class="ml-2"> Admin_Panel </span>
            </RouterLink>
            <RouterLink
                to=""
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <ProfileSvg classes="m-1.5 size-8 fill-none stroke-lime-500 group-hover:fill-lime-500 group-hover:stroke-lime-500" />
                <span class="ml-2"> Профиль </span>
            </RouterLink>
            <RouterLink
                :to="{ name: 'subscription' }"
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <SubscribeSvg classes="m-1.5 size-8 group-hover:drop-shadow-[0_0_6px_rgba(255,0,0,1)]" />
                <span class="ml-2"> Подписка </span>
            </RouterLink>
            <RouterLink
                :to="{ name: 'favorites.index' }"
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <FavoriteSvg classes="m-1.5 size-8 fill-none stroke-red-500 group-hover:fill-red-500 group-hover:stroke-red-500" />
                <span class="ml-2"> Избранное </span>
            </RouterLink>
            <RouterLink
                to=""
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <SettingsSvg classes="m-1.5 size-8 fill-none stroke-blue-600 group-hover:fill-blue-600 group-hover:stroke-blue-600" />
                <span class="ml-2"> Настройки </span>
            </RouterLink>
            <RouterLink
                :to="{ name: 'logout' }"
                class="group flex flex-row items-center px-4 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            >
                <LogoutSvg classes="m-1.5 size-8" />
                <span class="ml-2"> Выход </span>
            </RouterLink>
        </div>
    </div>
</template>
