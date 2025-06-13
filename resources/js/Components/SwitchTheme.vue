<script>
import { useThemeStore } from '../Stores/themeStore.js';
import SunSvg from './Svg/SunSvg.vue';
import MoonSvg from './Svg/MoonSvg.vue';
import SystemSvg from './Svg/SystemSvg.vue';

export default {
    name: 'SwitchTheme',
    components: { SystemSvg, MoonSvg, SunSvg },
    data() {
        return {
            themeStore: useThemeStore(),
        };
    },
    methods: {
        toggleTheme() {
            this.themeStore.toggleTheme();
        },
    },
};
</script>

<template>
    <button
        @click="toggleTheme"
        class="cursor-pointer transition-all duration-300 bg-white/70 dark:bg-black/70 hover:bg-black dark:hover:bg-white p-1.5 rounded-full shadow-md shadow-blue-500"
    >
        <SunSvg
            v-if="this.themeStore.isLight"
            classes="size-6 fill-amber-400 stroke-none"
        />

        <MoonSvg
            v-else-if="this.themeStore.isDark"
            classes="size-6"
        />

        <SystemSvg
            v-else
            classes="size-6"
        />
    </button>
</template>
