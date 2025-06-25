<script>
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'PosterImage',
    components: { LogoSvg },
    props: {
        poster: String,
        alt: String,
    },
};
</script>

<template>
    <img
        v-if="poster"
        :src="poster"
        :alt="alt"
        class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-110"
    />
    <div
        v-else
        class="flex size-full items-center justify-center transition-all duration-500 group-hover:scale-105"
    >
        <LogoSvg classes="size-15 filter grayscale" />
    </div>
</template>
