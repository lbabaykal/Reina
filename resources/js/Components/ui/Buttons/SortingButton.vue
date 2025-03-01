<script>
import DownArrowSvg from '../../Svg/DownArrowSvg.vue';
import SortingSvg from '../../Svg/SortingSvg.vue';

export default {
    name: 'SortingButton',
    components: { SortingSvg, DownArrowSvg },
    props: {
        text: String,
        isSortingMenu: Boolean,
    },
};
</script>

<template>
    <button
        type="button"
        class="bg-blackSimple hover:bg-blackActive flex w-56 cursor-pointer items-center justify-between rounded-sm border-b border-red-400 px-3 py-2 font-medium text-white transition-all duration-200"
        :class="[isSortingMenu ? '!bg-blackActive' : '']"
    >
        <DownArrowSvg classes="size-4" />
        <span class="px-6"> {{ text }} </span>
        <SortingSvg classes="size-6" />
    </button>
</template>
