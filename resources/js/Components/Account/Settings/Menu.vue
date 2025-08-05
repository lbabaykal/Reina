<script>
import ProfileSvg from '../../Svg/ProfileSvg.vue';
import ShieldSvg from '../../Svg/ShieldSvg.vue';
import { useRoute } from 'vue-router';

export default {
    name: 'Menu',
    components: { ShieldSvg, ProfileSvg },
    setup() {
        const route = useRoute();
        return { route };
    },
};
</script>

<template>
    <div class="mr-5 flex w-60 h-full flex-col rounded-md bg-white p-2 text-black dark:bg-black dark:text-white space-y-1">
        <RouterLink
            :to="{ name: 'account.settings.profile' }"
            class="group flex flex-row items-center rounded-md px-1 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            :class="{ 'bg-black text-white dark:bg-white dark:text-black': route.name === 'account.settings.profile' }"
        >
            <ProfileSvg classes="m-1.5 size-7 stroke-lime-500 fill-lime-500" />
            <span class="ml-2 w-full"> Профиль </span>
        </RouterLink>
        <RouterLink
            :to="{ name: 'account.settings.security' }"
            class="group flex flex-row items-center rounded-md px-1 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black"
            :class="{ 'bg-black text-white dark:bg-white dark:text-black': route.name === 'account.settings.security' }"
        >
            <ShieldSvg classes="m-1.5 size-7 stroke-sky-500 fill-sky-500" />
            <span class="ml-2 w-full"> Безопасность </span>
        </RouterLink>
    </div>
</template>
