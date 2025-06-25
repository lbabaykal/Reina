<script>
import LoadingSvg from '../Svg/LoadingSvg.vue';

export default {
    name: 'TabLoading',
    components: { LoadingSvg },
    props: {
        classes: {
            type: String,
            default: 'w-full h-full',
        },
    },
};
</script>

<template>
    <div class="flex-1 flex items-center justify-center">
        <LoadingSvg
            :classes="classes"
            class="size-20"
        />
    </div>
</template>
