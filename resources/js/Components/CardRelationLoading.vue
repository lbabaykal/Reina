<script>
export default {
    name: 'CardRelation',
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
    <div class="animate-shine h-32 w-80 rounded-md bg-linear-to-r from-gray-700 via-gray-500 to-gray-700 dark:from-gray-900 dark:via-gray-700 dark:to-gray-900 bg-[length:300%_100%]"></div>
</template>
