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
        class="inline-flex cursor-pointer items-center justify-center rounded-sm fill-white p-1 text-sm hover:bg-rose-500 hover:fill-black hover:text-white"
    >
        <CloseSvg classes="size-6" />
    </button>
</template>
