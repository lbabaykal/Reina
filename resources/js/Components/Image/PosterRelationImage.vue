<script>
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'PosterRelationImage',
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
        class="h-full w-full object-cover"
    />

    <div
        v-else
        class="flex size-full items-center justify-center border-r border-r-gray-500"
    >
        <LogoSvg classes="size-10 filter grayscale" />
    </div>
</template>
