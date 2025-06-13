<script>

export default {
    name: 'PosterRelationImage',
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
         class="h-full w-full object-cover"
    />

    <div v-else class="size-full flex items-center justify-center text-black dark:text-white font-semibold
    border-r border-r-gray-500
    ">
        ????
    </div>
</template>
