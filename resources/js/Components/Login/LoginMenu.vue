<script>
import SubscribeSvg from '../Svg/SubscribeSvg.vue';
import SubscribeBackgroundSvg from '../Svg/SubscribeBackgroundSvg.vue';
import LoginLoading from './LoginLoading.vue';
import SearchSvg from '../Svg/SearchSvg.vue';
import LoginGuest from './LoginGuest.vue';
import LoginAuth from './LoginAuth.vue';
import { useAuthStore } from '../../Stores/authStore.js';
import { push } from 'notivue';

export default {
    name: 'LoginMenu',
    components: { LoginAuth, LoginGuest, LoginLoading, SubscribeBackgroundSvg, SubscribeSvg, SearchSvg },
    data() {
        return {
            dataUser: {
                id: null,
                avatar: null,
                name: null,
            },
            isLoaderDataUser: true,
            authStore: useAuthStore(),
        };
    },
    methods: {
        getUser() {
            axios
                .get('/api/user-data')
                .then((response) => {
                    if (response.data.authenticated === true) {
                        this.dataUser.id = response.data.user.id;
                        this.dataUser.avatar = response.data.user.avatar;
                        this.dataUser.name = response.data.user.name;

                        const authData = {
                            id: response.data.user.id,
                            avatar: response.data.user.avatar,
                            name: response.data.user.name,
                        };
                        this.authStore.storeUser(authData);
                    } else {
                        this.authStore.destroyUser();
                    }
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.isLoaderDataUser = false;
                });
        },
    },
    computed: {
        isAuthenticated() {
            return this.authStore.isAuthenticated;
        },
    },
    mounted() {
        this.getUser();
    },
    watch: {},
};
</script>

<template>
    <div>
        <div class="flex flex-row items-center">
            <router-link
                :to="{ name: 'search' }"
                class="mx-6 flex items-center justify-center duration-200 hover:text-red-500"
            >
                <SearchSvg classes="h-8 w-8 drop-shadow-[0_0_8px_rgba(0,0,0,1)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,1)]" />
            </router-link>
            <router-link
                :to="{ name: 'subscription' }"
                class="mr-6 flex items-center justify-center drop-shadow-[0_0_6px_rgba(0,0,0,0.5)] duration-200 hover:text-red-500 hover:drop-shadow-[0_0_8px_rgba(255,0,0,0.8)]"
            >
                <SubscribeSvg classes="w-9 h-9"></SubscribeSvg>

                <div class="text-md flex h-full w-28 items-center justify-center text-white">
                    <div class="z-10 text-white">Подписка</div>
                    <SubscribeBackgroundSvg class="absolute w-28 text-[#ec6161]" />
                </div>
            </router-link>

            <LoginLoading v-if="isLoaderDataUser" />
            <LoginGuest v-if="!isLoaderDataUser && !isAuthenticated" />
            <LoginAuth
                v-if="!isLoaderDataUser && isAuthenticated"
                :dataUser="dataUser"
            />
        </div>
    </div>
</template>
