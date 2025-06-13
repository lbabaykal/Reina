<script>
export default {
    name: 'CoverImage',
    props: {
        cover: String,
    },
};
</script>

<template>
    <div
        v-if="cover"
        class="shadow-cover-white dark:shadow-cover-black absolute top-0 left-0 z-10 h-full w-full bg-cover bg-center"
        :style="{ backgroundImage: `url(${cover})` }"
    ></div>

    <div
        v-else
        class="shadow-cover-white dark:shadow-cover-black absolute top-0 left-0 z-10 flex size-full items-center justify-center text-3xl font-semibold text-black dark:text-white"
    >
        Нет изображения
    </div>
</template>
