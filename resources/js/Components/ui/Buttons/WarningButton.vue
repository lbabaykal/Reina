<script>
import TrashSvg from '../../Svg/TrashSvg.vue';

export default {
    name: 'WarningButton',
    components: { TrashSvg },
    props: {
        text: String,
        disabledButton: Boolean,
    },
};
</script>

<template>
    <button
        type="button"
        class="inline-flex min-w-32 cursor-pointer items-center justify-center rounded-sm border-b-2 border-orange-400 bg-black px-4 py-2 font-bold text-white shadow-md hover:border-orange-400 hover:bg-orange-400 hover:text-black disabled:opacity-60"
        :disabled="disabledButton"
    >
        <span class="mr-2">{{ text }}</span>
        <TrashSvg classes="size-6 fill-none" />
    </button>
</template>
