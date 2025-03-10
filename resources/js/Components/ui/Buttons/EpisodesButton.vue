<script>
import DownArrowSvg from '../../Svg/DownArrowSvg.vue';

export default {
    name: 'EpisodesButton',
    components: { DownArrowSvg },
    props: {
        text: String,
    },
};
</script>

<template>
    <button
        type="button"
        class="flex cursor-pointer items-center rounded-sm bg-gray-600/80 px-4 py-3.5 whitespace-nowrap hover:bg-gray-500"
    >
        {{ text }}
        <DownArrowSvg classes="size-4 ms-2.5" />
    </button>
</template>
