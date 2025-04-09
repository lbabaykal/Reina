<script>
import CloseSvg from '../../Svg/CloseSvg.vue';

export default {
    name: 'ModalCloseButton',
    components: { CloseSvg },
};
</script>

<template>
    <button
        type="button"
        class="inline-flex cursor-pointer items-center justify-center rounded-sm p-1 text-sm
        fill-black dark:fill-white
        text-black dark:text-white
        hover:text-white
        hover:bg-rose-500"
    >
        <CloseSvg classes="size-6" />
    </button>
</template>
