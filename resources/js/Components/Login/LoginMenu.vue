<script>
import SubscribeSvg from '../Svg/SubscribeSvg.vue';
import LoginLoading from './LoginLoading.vue';
import SearchSvg from '../Svg/SearchSvg.vue';
import LoginGuest from './LoginGuest.vue';
import LoginAuth from './LoginAuth.vue';
import { useAuthStore } from '../../Stores/authStore.js';
import SwitchTheme from '../SwitchTheme.vue';

export default {
    name: 'LoginMenu',
    components: { SwitchTheme, LoginAuth, LoginGuest, LoginLoading, SubscribeSvg, SearchSvg },
    data() {
        return {
            authStore: useAuthStore(),
        };
    },
    computed: {
        isAuthenticated() {
            return this.authStore.isAuthenticated;
        },
        isUserDataLoaded() {
            return this.authStore.isUserDataLoaded;
        },
    },
};
</script>

<template>
    <div>
        <div class="flex flex-row items-center">
            <router-link
                :to="{ name: 'search' }"
                class="mx-4 flex items-center justify-center rounded-full bg-black/60 p-0.5 text-violet-400 shadow-sm shadow-violet-400 transition-all duration-300 hover:bg-violet-400 hover:text-white dark:hover:bg-violet-400 dark:hover:text-white"
            >
                <SearchSvg classes="size-8" />
            </router-link>

            <router-link
                :to="{ name: 'subscription' }"
                class="mr-4 flex items-center justify-center rounded-full bg-black/60 px-2 py-1 text-amber-200 shadow-sm shadow-amber-200 duration-300 hover:bg-black dark:hover:bg-amber-200 dark:hover:text-black"
            >
                <SubscribeSvg classes="size-7"></SubscribeSvg>
                <div class="pr-3 pl-2 font-semibold">Подписка</div>
            </router-link>

            <SwitchTheme class="mr-4" />

            <LoginLoading v-if="!isUserDataLoaded" />
            <LoginGuest v-if="isUserDataLoaded && !isAuthenticated" />
            <LoginAuth v-if="isUserDataLoaded && isAuthenticated" />
        </div>
    </div>
</template>
