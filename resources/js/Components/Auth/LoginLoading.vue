<script>
import NoAvatarSvg from '../Svg/NoAvatarSvg.vue';

export default {
    name: 'LoginLoading',
    components: { NoAvatarSvg },
};
</script>

<template>
    <div class="flex h-10 flex-row rounded-full bg-black/60 shadow shadow-blue-600 transition-all duration-300 select-none hover:bg-white/25">
        <div class="flex min-w-60 flex-col justify-center px-4 text-center text-nowrap">
            <div class="text-lg font-bold text-white">Загрузка...</div>
        </div>
        <NoAvatarSvg class="size-10 rounded-full bg-cover bg-center" />
    </div>
</template>
