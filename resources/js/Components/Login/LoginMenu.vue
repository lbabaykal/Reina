<script>

import SearchSvg from "@/Components/Svg/SearchSvg.vue";
import SubscribeSvg from "@/Components/Svg/SubscribeSvg.vue";
import LoginGuestComponent from "@/Components/Login/LoginGuest.vue";
import LoginAuthComponent from "@/Components/Login/LoginAuth.vue";
import SubscribeBackgroundSvg from "@/Components/Svg/SubscribeBackgroundSvg.vue";
import {useAuthStore} from "../../Stores/authStore.js";
import LoginLoading from "./LoginLoading.vue";

export default {
    name: "LoginMenu",
    components: {LoginLoading, SubscribeBackgroundSvg, LoginAuthComponent, LoginGuestComponent, SubscribeSvg, SearchSvg},
    data() {
        return {
            dataUser: {
                id: null,
                avatar: null,
                name: null,
            },
            isLoaderDataUser: true,
            authStore: useAuthStore(),
        }
    },
    methods: {
        getUser() {
            axios.get('/api/user-data')
                .then(response => {
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
                .catch(error => {
                    //TODO Уведомление что не получилось получить пользователя
                })
                .finally(() => {
                    this.isLoaderDataUser = false;
                });
        }
    },
    computed: {
        isAuthenticated() {
            return this.authStore.isAuthenticated;
        },
    },
    mounted() {
        this.getUser();
    },
    watch: {
    }
}
</script>

<template>
    <div>
        <div class="flex flex-row items-center">
            <router-link :to="{ name: 'search' }"
                         class="mx-6 flex items-center justify-center hover:text-red-500 duration-200"
            >
                <SearchSvg
                    classes="h-8 w-8 drop-shadow-[0_0_8px_rgba(0,0,0,1)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,1)]"/>
            </router-link>
            <router-link :to="{ name: 'subscription' }"
                         class="mr-6 flex items-center justify-center hover:text-red-500 duration-200 drop-shadow-[0_0_6px_rgba(0,0,0,0.5)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,0.8)]"
            >
                <SubscribeSvg classes="w-9 h-9"></SubscribeSvg>

                <div class="w-28 h-full text-white text-md flex items-center justify-center">
                    <div class="text-white z-10">
                        Подписка
                    </div>
                    <SubscribeBackgroundSvg class="absolute text-[#ec6161] w-28"/>
                </div>
            </router-link>

            <LoginLoading v-if="isLoaderDataUser"/>
            <LoginGuestComponent v-if="!isLoaderDataUser && !isAuthenticated"/>
            <LoginAuthComponent v-if="!isLoaderDataUser && isAuthenticated" :dataUser="dataUser"/>

        </div>
    </div>
</template>
