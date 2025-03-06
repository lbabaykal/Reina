<script>
import TrashSvg from '../../Svg/TrashSvg.vue';

export default {
    name: 'WarningButton',
    components: { TrashSvg },
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
        class="inline-flex min-w-16 cursor-pointer items-center justify-center rounded-sm border-b-2 border-orange-400 bg-black px-4 py-2 font-bold text-white shadow-md hover:border-orange-400 hover:bg-orange-400 hover:text-black disabled:opacity-60"
        :disabled="disabledButton"
    >
        <span
            class="mr-2"
            v-if="isText"
        >
            {{ text }}
        </span>
        <TrashSvg classes="size-6 fill-none" />
    </button>
</template>
