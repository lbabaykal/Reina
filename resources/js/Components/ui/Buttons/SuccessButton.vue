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
        class="inline-flex min-w-16 cursor-pointer items-center justify-center rounded-sm border-b-2 border-lime-500 bg-black px-4 py-2 font-bold text-white shadow-md hover:border-lime-600 hover:bg-lime-500 hover:text-black disabled:opacity-60"
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
