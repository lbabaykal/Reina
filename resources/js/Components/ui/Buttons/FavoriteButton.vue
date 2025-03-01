<script>
import ToolTip from '../../ToolTip.vue';
import FavoriteSvg from '../../Svg/FavoriteSvg.vue';

export default {
    name: 'FavoriteButton',
    components: { FavoriteSvg, ToolTip },
    props: {
        isFavoriteUser: Boolean,
    },
};
</script>

<template>
    <ToolTip
        message="В избранное"
        classes="py-2 px-4 bg-gray-600 text-red-500"
    >
        <button
            type="button"
            class="group flex cursor-pointer flex-row items-center rounded-sm bg-gray-600/80 p-2 text-red-500 hover:bg-gray-500"
        >
            <FavoriteSvg :classes="['w-7 h-7 stroke-red-500 group-hover:fill-red-500', isFavoriteUser ? 'fill-red-500' : 'fill-transparent']" />
        </button>
    </ToolTip>
</template>
