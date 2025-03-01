<script>
import PlaySvg from '../../Svg/PlaySvg.vue';

export default {
    name: 'WatchOnlineButton',
    components: { PlaySvg },
};
</script>

<template>
    <div
        class="group relative flex flex-row items-center justify-center rounded-sm bg-linear-to-r from-orange-500 via-red-500 to-violet-600 px-12 py-2 font-bold text-white"
    >
        <PlaySvg classes="w-7 h-7 inline-block" />
        &nbsp;Смотреть онлайн
        <div
            class="absolute inset-0 -z-10 rounded-lg bg-linear-to-r from-orange-500 via-red-500 to-violet-600 opacity-0 blur-md transition-all duration-300 group-hover:opacity-100"
        ></div>
    </div>
</template>
