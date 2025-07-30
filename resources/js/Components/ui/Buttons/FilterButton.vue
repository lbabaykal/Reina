<script>
import FilterSvg from '../../Svg/FilterSvg.vue';
import DownArrowSvg from '../../Svg/DownArrowSvg.vue';

export default {
    name: 'FilterButton',
    components: { DownArrowSvg, FilterSvg },
    props: {
        text: String,
        isFiltersMenu: Boolean,
    },
};
</script>

<template>
    <button
        class="dark:hover:bg-blackActive hover:bg-whiteActive flex w-56 cursor-pointer items-center justify-between rounded-md border-b border-red-400 bg-white px-3 py-2 font-medium text-black shadow-md transition-all duration-200 dark:bg-black dark:text-white"
        :class="[isFiltersMenu ? 'dark:!bg-blackActive !bg-whiteActive' : '']"
        type="button"
    >
        <FilterSvg classes="w-6 h-6" />
        <span class="px-6"> {{ text }} </span>
        <DownArrowSvg classes="w-4 h-4" />
    </button>
</template>
