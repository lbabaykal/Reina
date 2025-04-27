<script>
export default {
    name: 'DescriptionTab',
    props: {
        description: String,
    },
};
</script>

<template>
    <div class="text-justify indent-8 text-lg text-black dark:text-white">
        {{ this.description }}
    </div>
</template>
