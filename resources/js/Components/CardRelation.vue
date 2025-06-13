<script>
import StarSvg from './Svg/StarSvg.vue';
import PosterRelationImage from './Image/PosterRelationImage.vue';

export default {
    name: 'CardRelation',
    components: { PosterRelationImage, StarSvg },
    props: {
        id: Number,
        slug: String,
        poster: String,
        type: {
            id: Number,
            slug: String,
            title_ru: String,
            title_en: String,
        },
        title_ru: String,
        release: String,
        rating: Number,
        relation_type: String,
    },
};
</script>

<template>
    <RouterLink
        :to="{ name: this.relation_type + '.show', params: { slug: this.slug } }"
        class="flex flex-row w-80 h-32 rounded-md overflow-hidden
                bg-whiteFon hover:bg-whiteActive
                dark:bg-blackFon dark:hover:bg-blackActive
                transition-all duration-300
                "
    >
        <div class="h-32 w-22 overflow-hidden shrink-0">
            <PosterRelationImage :poster="poster" :alt="title_ru"/>
        </div>

        <div class="my-2 mx-3 w-full flex flex-col justify-between">
            <div class="line-clamp-2 font-semibold">
                {{ this.title_ru }}
            </div>

            <div class="flex justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-0.5">
                    <div>
                        Тип: <span class="font-semibold">{{ this.type.title_ru }}</span>
                    </div>
                    <div>
                        Премьера: <span class="font-semibold">{{ this.release }}</span>
                    </div>
                </div>
                <div class="flex flex-row items-center">
                    <StarSvg classes="size-4 text-amber-400"></StarSvg>
                    <div class="ml-1 font-semibold">{{ this.rating }}</div>
                </div>
            </div>
        </div>
    </RouterLink>
</template>
