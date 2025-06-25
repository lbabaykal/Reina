<script>

export default {
    name: 'TabNotData',
    props: {
        title: {
            type: String,
            default: 'Данных нет',
        },
    },
};
</script>

<template>
    <div class="flex flex-1 items-center justify-center text-2xl text-gray-400">
        {{ title }}
    </div>
</template>
