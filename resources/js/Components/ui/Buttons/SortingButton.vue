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
        class="dark:hover:bg-blackActive hover:bg-whiteActive flex w-56 cursor-pointer items-center justify-between rounded-md border-b border-red-400 bg-white px-3 py-2 font-medium text-black shadow-md transition-all duration-300 dark:bg-black dark:text-white"
        :class="[isSortingMenu ? 'dark:!bg-blackActive !bg-whiteActive' : '']"
    >
        <DownArrowSvg classes="size-4" />
        <span class="px-6"> {{ text }} </span>
        <SortingSvg classes="size-6" />
    </button>
</template>
