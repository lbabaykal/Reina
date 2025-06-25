<script>
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'PhotoImage',
    components: { LogoSvg },
    props: {
        photo: String,
        alt: {
            type: String,
            default: '',
        }
    },
};
</script>

<template>
    <img
        v-if="photo"
        :src="photo"
        :alt="alt"
        class="min-h-32 w-full rounded-full"
    />

    <div
        v-else
        class="text-md flex min-h-32 w-full items-center justify-center rounded-full border border-gray-500"
    >
        <LogoSvg classes="size-10 filter grayscale" />
    </div>
</template>
