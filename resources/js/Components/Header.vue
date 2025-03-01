<script>
import LogoSvg from './Svg/LogoSvg.vue';
import LoginMenu from './Login/LoginMenu.vue';

export default {
    name: 'Header',
    components: { LoginMenu, LogoSvg },
    data() {
        return {
            isScrolledHeader: false,
        };
    },
    methods: {
        handleScroll() {
            const header = document.getElementById('header');

            if (window.scrollY > 10) {
                header.classList.add('header-change');
                this.isScrolledHeader = true;
            } else {
                header.classList.remove('header-change');
                this.isScrolledHeader = false;
            }
        },
    },
    computed: {},
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
};
</script>

<template>
    <div>
        <header
            id="header"
            class="fixed top-0 z-50 w-full bg-transparent transition-all duration-300 ease-linear"
        >
            <nav class="mx-auto flex h-14 items-center justify-between px-15">
                <RouterLink
                    :to="{ name: 'main' }"
                    class="flex flex-row content-center items-center text-3xl font-bold text-white select-none"
                >
                    Reina
                    <LogoSvg classes="w-10 ml-2" />
                </RouterLink>
                <LoginMenu :isScrolledHeader />
            </nav>
        </header>
    </div>
</template>
