<script>
export default {
    name: 'PhotoImage',
    props: {
        photo: String,
        alt: String,
    },
};
</script>

<template>
    <img
        v-if="photo"
        :src="photo"
        :alt="alt"
        class="min-h-32 w-full"
    />

    <div
        v-else
        class="text-md flex min-h-32 w-full items-center justify-center text-center font-semibold text-black dark:text-white border border-gray-500"
    >
        Нет изображения
    </div>
</template>
