<script>
import PhotoImage from '../Image/PhotoImage.vue';

export default {
    name: 'CardCharacterNotData',
    components: { PhotoImage },
    props: {
        title: String,
    },
};
</script>

<template>
    <div class="w-32 text-black dark:text-white">
        <PhotoImage
            :photo="null"
        />

        <div class="mt-1 line-clamp-2 w-full items-center justify-center text-center leading-5 font-semibold">
            {{ title }}
        </div>
    </div>
</template>
