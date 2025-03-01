<script>
import NoAvatarSvg from '../Svg/NoAvatarSvg.vue';

export default {
    name: 'LoginLoading',
    components: { NoAvatarSvg },
};
</script>

<template>
    <div class="flex h-10 flex-row rounded-full bg-black/60 transition-all duration-300 select-none hover:bg-white/25">
        <div class="flex flex-col justify-center text-center text-nowrap">
            <div class="px-16 text-lg font-bold">Loading...</div>
        </div>
        <NoAvatarSvg class="h-10 w-10 rounded-full bg-cover bg-center" />
    </div>
</template>
