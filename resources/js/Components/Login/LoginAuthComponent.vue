<script>
import LogoutSvg from "@/Components/Svg/LogoutSvg.vue";
import SettingsSvg from "@/Components/Svg/SettingsSvg.vue";
import FavoriteSvg from "@/Components/Svg/FavoriteSvg.vue";
import SubscribeSvg from "@/Components/Svg/SubscribeSvg.vue";
import ProfileSvg from "@/Components/Svg/ProfileSvg.vue";
import AdminPanelSvg from "@/Components/Svg/AdminPanelSvg.vue";

export default {
    name: "LoginAuthComponent",
    components: {AdminPanelSvg, ProfileSvg, SubscribeSvg, FavoriteSvg, SettingsSvg, LogoutSvg},
    data() {
        return {
            isDropdownUserMenu: false,
        }
    },
    props: {
        isScrolledHeader: Boolean,
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
    watch: {
        isScrolledHeader() {
            let menu = document.getElementById('menuAuth');

            if (this.isScrolledHeader) {
                menu.classList.add('hover:bg-white/25');
                menu.classList.remove('hover:bg-black');
            } else {
                menu.classList.remove('hover:bg-white/25');
                menu.classList.add('hover:bg-black');
            }
        },
    }
}
</script>

<template>
    <div>
        <div v-if="dataUser.id"
             id="menuAuth"
             @click="toggleUserMenu"
             class="group flex cursor-pointer select-none flex-row transition-all duration-300 h-[40px] rounded-full bg-black/60"
        >
            <div class="relative flex flex-col justify-center text-nowrap text-center">
                <div class="truncate max-w-80 px-4 text-lg">
                    <span class="text-blue-500">{{ showWelcomeMessage }}</span>
                    <span class="text-red-500 font-bold">{{ dataUser.name }}</span>
                </div>
            </div>
            <img :src="`${dataUser.avatar}`"
                 class="h-10 w-10 rounded-full bg-cover bg-center group-hover:drop-shadow-[0_0_16px_rgb(255,0,0)]"
            >
        </div>
        <div v-else
             class="flex select-none flex-row transition-all duration-200 h-[40px] rounded-full bg-black/60 hover:bg-white/25"
        >
            <div class="flex flex-col justify-center text-nowrap text-center">
                <div class="font-bold !text-lg px-4">
                    Loading...
                </div>
            </div>
            <img :src="`/images/avatars/no_avatar.png`"
                 class="h-10 w-10 rounded-full bg-cover bg-center"
            >
        </div>

        <div v-show="isDropdownUserMenu"
             class="absolute right-14 top-[60px] w-72 select-none rounded bg-gray-900 shadow-[0_5px_10px_0_rgba(0,0,0,0.7)]"
        >
            <div class="flex items-center border-b-2 border-b-blue-600">
                <img :src="`${dataUser.avatar}`"
                     class="m-3 h-16 w-16 rounded-full bg-cover bg-center"
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
                <button type="submit"
                        form="logout"
                        class="group flex flex-row items-center px-4 hover:bg-gray-100"
                >
                    <LogoutSvg classes="m-1.5 h-8 w-8 group-hover:stroke-black"/>
                    <span class="ml-2 group-hover:text-black">
                        Выход
                    </span>
                </button>
            </div>

            <form id="logout"
                  class="profile-menu-button"
                  action="{{ route('logout') }}"
                  method="POST">
            </form>
        </div>
    </div>
</template>
