<script>

import AuthHeader from "./AuthHeader.vue";
import LogoSvg from "../Svg/LogoSvg.vue";

export default {
    name: "AuthWindow" ,
    components: {LogoSvg, AuthHeader: AuthHeader}
}
</script>

<template>
    <div class="w-full min-h-screen items-center justify-center flex-col flex bg-gray-300">
        <router-link :to="{ name: 'main' }"
                     class="text-4xl font-bold text-black flex flex-row content-center items-center select-none mb-5"
        >
            Reina
            <LogoSvg classes="size-16 ml-4"/>
        </router-link>
        <section class="w-120 flex items-center shadow-2xl rounded-2xl flex-col overflow-hidden bg-white backdrop:blur-sm select-none">
            <AuthHeader />

            <slot></slot>
        </section>
    </div>
</template>
