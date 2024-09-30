<script>
import LoginMenuComponent from "@/Components/Login/LoginMenuComponent.vue";
import LogoSvg from "@/Components/Svg/LogoSvg.vue";
export default {
    name: "HeaderComponent",
    components: {LoginMenuComponent, LogoSvg},
    data() {
        return {
            isScrolledHeader: false
        }
    },
    methods: {
        handleScroll() {
            const header = document.getElementById('header');

            if (window.scrollY > 60) {
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
                class="w-full bg-transparent fixed top-0 transition-all duration-500 ease-linear z-50"
        >
            <nav class="mx-auto flex items-center justify-between h-[60px] px-[60px]">
                <RouterLink :to="{ name: 'main' }"
                            class="logo-shadow text-3xl font-bold text-white flex flex-row content-center items-center select-none"
                >
                    Reina
                    <LogoSvg classes="w-10 ml-2" />
                </RouterLink>
                <LoginMenuComponent :isScrolledHeader/>
            </nav>
        </header>
    </div>
</template>
