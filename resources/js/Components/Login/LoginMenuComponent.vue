<script>

import SearchSvg from "@/Components/Svg/SearchSvg.vue";
import SubscribeSvg from "@/Components/Svg/SubscribeSvg.vue";
import LoginGuestComponent from "@/Components/Login/LoginGuestComponent.vue";
import LoginAuthComponent from "@/Components/Login/LoginAuthComponent.vue";

export default {
    name: "LoginMenuComponent",
    components: {LoginAuthComponent, LoginGuestComponent, SubscribeSvg, SearchSvg},
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
        <div class="flex flex-row">
            <router-link :to="{ name: 'search' }"
                         class="mr-6 flex items-center justify-center hover:text-red-500 duration-200"
            >
                <SearchSvg classes="h-8 w-8 drop-shadow-[0_0_8px_rgba(0,0,0,1)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,1)]"/>
            </router-link>
            <router-link :to="{ name: 'subscription' }"
                         class="mr-6 flex items-center justify-center hover:text-red-500 duration-200 drop-shadow-[0_0_6px_rgba(0,0,0,0.5)] hover:drop-shadow-[0_0_8px_rgba(255,0,0,0.8)]"
            >
                <SubscribeSvg classes="w-9 h-9"></SubscribeSvg>

                <div class="w-28 h-full text-white text-md flex items-center justify-center"
                     :style="{backgroundImage: `url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; fill=&quot;%23EC6161&quot; viewBox=&quot;0 0 252 60&quot;><g transform=&quot;translate(0,60) scale(0.1,-0.1)&quot; stroke=&quot;none&quot;><path d=&quot;M335 590 c-90 -19 -161 -67 -201 -137 -15 -26 -50 -72 -78 -100 l-50 -53 50 -52 c28 -29 63 -75 78 -101 32 -56 102 -110 166 -129 36 -10 245 -13 1020 -13 l975 0 47 24 c61 30 121 89 150 149 32 66 32 178 0 244 -29 60 -90 120 -150 150 l-47 23 -960 2 c-528 0 -978 -3 -1000 -7z&quot; /></g></svg>')`,
                     backgroundRepeat: 'no-repeat',
                     backgroundPosition: 'center'}"
                >
                    Подписка
                </div>
            </router-link>

            <LoginGuestComponent :isScrolledHeader="isScrolledHeader"/>
            <LoginAuthComponent :isScrolledHeader="isScrolledHeader"
                                :dataUser="dataUser"
            />

        </div>
    </div>
</template>
