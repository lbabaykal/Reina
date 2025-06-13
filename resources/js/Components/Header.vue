<script>
import LogoSvg from './Svg/LogoSvg.vue';
import LoginMenu from './Login/LoginMenu.vue';

export default {
    name: 'Header',
    components: { LoginMenu, LogoSvg },
    methods: {
        // handleScroll() {
        //     if (window.scrollY > 5) {
        //         this.$refs.header.classList.remove('header-change');
        //     } else {
        //         this.$refs.header.classList.add('header-change');
        //     }
        // },
    },
    mounted() {
        // window.addEventListener('scroll', this.handleScroll);
    },
    unmounted() {
        // window.removeEventListener('scroll', this.handleScroll);
    },
};
</script>

<template>
    <div>
        <header
            ref="header"
            class="fixed top-0 z-50 w-full bg-white/70 text-black dark:bg-black/70 dark:text-white backdrop-blur-sm"
        >
            <nav class="mx-auto flex h-14 items-center justify-between px-15">
                <RouterLink
                    :to="{ name: 'main' }"
                    class="flex flex-row content-center items-center text-3xl font-bold select-none"
                >
                    Reina
                    <LogoSvg classes="w-10 ml-2" />
                </RouterLink>

                <LoginMenu />
            </nav>
        </header>
    </div>
</template>
