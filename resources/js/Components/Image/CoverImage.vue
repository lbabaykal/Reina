<script>
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'CoverImage',
    components: { LogoSvg },
    props: {
        cover: String,
    },
};
</script>

<template>
    <div
        v-if="cover"
        class="shadow-cover-white dark:shadow-cover-black absolute top-0 left-0 z-10 h-full w-full bg-cover bg-center"
        :style="{ backgroundImage: `url(${cover})` }"
    ></div>

    <div
        v-else
        class="shadow-cover-white dark:shadow-cover-black absolute top-0 left-0 z-10 flex size-full items-center justify-center"
    >
        <LogoSvg classes="size-20 filter grayscale" />
    </div>
</template>
