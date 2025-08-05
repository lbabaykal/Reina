<script>
import AuthHeader from './AuthHeader.vue';
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'AuthWindow',
    components: { LogoSvg, AuthHeader },
};
</script>

<template>
    <div class="flex min-h-screen w-full flex-col items-center justify-center bg-gray-300">
        <router-link
            :to="{ name: 'main' }"
            class="mb-5 flex flex-row content-center items-center text-4xl font-bold text-black select-none"
        >
            Reina
            <LogoSvg classes="size-16 ml-4" />
        </router-link>
        <section class="flex w-120 flex-col items-center overflow-hidden rounded-2xl bg-white shadow-2xl select-none backdrop:blur-xs">
            <AuthHeader />

            <slot></slot>
        </section>
    </div>
</template>
