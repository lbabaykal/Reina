<script>
import PosterImage from '../Image/PosterImage.vue';

export default {
    name: 'CardAnime',
    components: { PosterImage },
    props: {
        id: Number,
        slug: String,
        poster: String,
        title: String,
        rating: [Number, String],
        episodes_released: Number,
        episodes_total: Number,
        is_rating: Boolean,
    },
    computed: {
        isRating() {
            return this.is_rating;
        },
        displayEpisodes() {
            return this.episodes_released === this.episodes_total ? this.episodes_total : `${this.episodes_released} / ${this.episodes_total}` ;
        }
    },
};
</script>

<template>
    <div class="flex aspect-5/7 w-full items-center justify-center text-white select-none">
        <router-link
            :to="{ name: 'animes.show', params: { slug: this.slug } }"
            class="group w-95% bg-whiteSimple dark:bg-blackSimple relative aspect-5/7 overflow-hidden rounded-lg transition-all duration-500 hover:w-full hover:drop-shadow-[0_0_12px_rgb(255,0,0)]"
        >
            <PosterImage
                :poster="poster"
                :alt="title"
            />

            <div class="absolute top-1 right-1 rounded-md bg-black/60 px-2 py-1 duration-500">
                <span v-if="isRating">★ {{ rating }}</span>
                <span v-else>—</span>
            </div>

            <div
                v-if="episodes_total !== 1"
                class="absolute bottom-2 left-2 rounded-sm bg-red-500/90 px-1.5 py-0.5 text-sm transition-all duration-500 group-hover:invisible group-hover:opacity-0"
            >
                EPS: {{ displayEpisodes }}
            </div>

            <div
                class="invisible absolute bottom-0 flex h-14 w-full items-center justify-center bg-black/25 p-2 opacity-0 backdrop-blur transition-all duration-500 group-hover:visible group-hover:opacity-100"
            >
                <span class="line-clamp-2 text-center leading-5">
                    {{ title }}
                </span>
            </div>
        </router-link>
    </div>
</template>
