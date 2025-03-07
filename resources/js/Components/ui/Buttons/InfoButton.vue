<script>
import CloseSvg from '../../Svg/CloseSvg.vue';

export default {
    name: 'InfoButton',
    components: { CloseSvg },
    props: {
        text: {
            type: String,
            required: false,
            default: null,
        },
        disabledButton: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    computed: {
        isText() {
            return this.text && this.text.length > 0;
        },
    },
};
</script>

<template>
    <button
        type="button"
        class="flex min-w-16 shrink-0 cursor-pointer items-center justify-center rounded-sm border-b-2 border-sky-500 bg-black px-3 py-1.5 font-bold text-white hover:border-sky-600 hover:bg-sky-500 hover:text-black disabled:opacity-60"
        :disabled="disabledButton"
    >
        <span
            class="mr-2"
            v-if="isText"
        >
            {{ text }}
        </span>
        <CloseSvg classes="size-6" />
    </button>
</template>
