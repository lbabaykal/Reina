<script>

import SearchSvg from "@/Components/Svg/SearchSvg.vue";
import SubscribeSvg from "@/Components/Svg/SubscribeSvg.vue";
import LoginGuestComponent from "@/Components/Login/LoginGuestComponent.vue";
import LoginAuthComponent from "@/Components/Login/LoginAuthComponent.vue";
import SubscribeBackgroundSvg from "@/Components/Svg/SubscribeBackgroundSvg.vue";

export default {
    name: "LoginMenuComponent",
    components: {SubscribeBackgroundSvg, LoginAuthComponent, LoginGuestComponent, SubscribeSvg, SearchSvg},
    data() {
        return {
            dataUser: {
                id: null,
                avatar: null,
                name: null,
                email: null,
            },
        }
    },
    props: {
        isScrolledHeader: Boolean,
    },
    methods: {
        getUser() {
            axios.get('api/user')
                .then( response => {
                    console.log()
                    this.dataUser.id = response.data.data.id;
                    this.dataUser.avatar = response.data.data.avatar;
                    this.dataUser.name = response.data.data.name;
                    this.dataUser.email = response.data.data.email;
                })
                .catch( error => {
                    console.log(error.response)
                })
                .finally(() => {

                });
        }
    },
    mounted() {
        this.getUser();
    },
}
</script>

<template>
    <div>
        <div class="flex flex-row items-center">
            <router-link :to="{ name: 'search' }"
                         class="mx-6 flex items-center justify-center hover:text-red-500 duration-200"
            >
                <SearchSvg classes="h-8 w-8 drop-shadow-[0_0_8px_rgba(0,0,0,1)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,1)]"/>
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

            <LoginGuestComponent :isScrolledHeader="isScrolledHeader"/>
            <LoginAuthComponent :isScrolledHeader="isScrolledHeader"
                                :dataUser="dataUser"
            />

        </div>
    </div>
</template>
