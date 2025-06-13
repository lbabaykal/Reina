<script>

export default {
    name: 'PosterImage',
    props: {
        poster: String,
        alt: String,
    },
};
</script>

<template>
    <img v-if="poster"
         :src="poster"
         :alt="alt"
         class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-110"
    />
    <div v-else class="size-full flex items-center justify-center text-black dark:text-white font-semibold transition-all duration-500 group-hover:scale-105">
        Нет изображения
    </div>
</template>
