<script>
import SendSvg from '../../Svg/SendSvg.vue';

export default {
    name: 'SuccessButton',
    components: { SendSvg },
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
        class="flex min-w-16 shrink-0 cursor-pointer items-center justify-center rounded-sm border-b-2 border-lime-500 bg-white px-3 py-1.5 font-bold text-black hover:border-lime-500 hover:bg-lime-500 hover:text-white disabled:opacity-60 dark:bg-black dark:text-white"
        :disabled="disabledButton"
    >
        <span
            class="mr-2"
            v-if="isText"
        >
            {{ text }}
        </span>
        <SendSvg classes="size-6 fill-none" />
    </button>
</template>
