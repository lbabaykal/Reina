<script>

import LogoSvg from "./Svg/LogoSvg.vue";
import LoginMenu from "./Login/LoginMenu.vue";

export default {
    name: "Header",
    components: {LoginMenu, LogoSvg},
    data() {
        return {
            isScrolledHeader: false
        }
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
    computed: {

    },
    mounted() {
        window.addEventListener("scroll", this.handleScroll);
    },
}
</script>

<template>
    <div>
        <header id="header"
                class="w-full bg-transparent fixed top-0 transition-all duration-300 ease-linear z-50"
        >
            <nav class="mx-auto flex items-center justify-between h-14 px-15">
                <RouterLink :to="{ name: 'main' }"
                            class="text-3xl font-bold text-white flex flex-row content-center items-center select-none"
                >
                    Reina
                    <LogoSvg classes="w-10 ml-2" />
                </RouterLink>
                <LoginMenu :isScrolledHeader/>
            </nav>
        </header>
    </div>
</template>
