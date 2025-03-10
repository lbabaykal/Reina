<script>
import StarSvg from '../../Svg/StarSvg.vue';
import ToolTip from '../../ToolTip.vue';

export default {
    name: 'RatingButton',
    components: { ToolTip, StarSvg },
    props: {
        is_rating: Boolean,
        isRatingUser: Boolean,
    },
    methods: {
        clickMethod() {
            this.$emit('clickMethod');
        },
    },
};
</script>

<template>
    <ToolTip
        message="Оценить"
        classes="py-2 px-4 bg-gray-600 text-yellow-500"
    >
        <button
            type="button"
            class="group flex cursor-pointer flex-row items-center rounded-sm bg-gray-600/80 p-2 hover:bg-gray-500 disabled:opacity-70"
            @click="clickMethod"
            :disabled="!is_rating"
        >
            <StarSvg :classes="['size-7 stroke-amber-400 group-hover:fill-amber-400', isRatingUser ? 'fill-amber-400' : 'fill-transparent']" />
        </button>
    </ToolTip>
</template>
