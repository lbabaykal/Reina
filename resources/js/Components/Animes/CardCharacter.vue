<script>
import PhotoImage from '../Image/PhotoImage.vue';

export default {
    name: 'CardCharacter',
    components: { PhotoImage },
    props: {
        slug: String,
        full_name_ru: String,
        photo: String,
    },
};
</script>

<template>
    <div class="w-32 text-black dark:text-white">
        <PhotoImage
            :photo="photo"
            :alt="full_name_ru"
        />

        <div class="mt-1 line-clamp-2 w-full items-center justify-center text-center leading-5 font-semibold">
            {{ full_name_ru }}
        </div>
    </div>
</template>
