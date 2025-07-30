<script>
import LogoSvg from '../Svg/LogoSvg.vue';

export default {
    name: 'AvatarImage',
    components: { LogoSvg },
    props: {
        avatar: String,
    },
};
</script>

<template>
    <img
        v-if="avatar"
        :src="avatar"
        alt=""
        class="size-full"
    />

    <div
        v-else
        class="flex size-full items-center justify-center"
    >
        <LogoSvg classes="size-10 filter grayscale" />
    </div>
</template>
