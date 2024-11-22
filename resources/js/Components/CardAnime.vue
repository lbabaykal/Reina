<script>
export default {
    name: "CardAnime",
    props: {
        id: Number,
        slug: String,
        poster: String,
        title: String,
        rating: String,
        episodes_released: Number,
        episodes_total: Number,
    }
}
</script>

<template>
    <div>
        <div class="w-full aspect-[5/7] flex items-center justify-center select-none">
            <router-link :to="{ name: 'animes.show', params: { slug: this.slug } }"
                         class="group relative overflow-hidden rounded-md w-95% aspect-[5/7] bg-gray-700
                         transition-all duration-500
                         hover:w-full hover:drop-shadow-[0_0_8px_rgb(255,0,0)]"
            >
                <img :src="poster"
                     :alt="title"
                     class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-110"
                />

                <div class="absolute px-2 top-1 right-1 bg-red-500/80 rounded">★ {{ rating }}</div>

                <div v-if="episodes_total !== 1"
                     class="absolute bottom-2 left-2 px-1.5 py-0.5 bg-violet-600/70 transition-all duration-500 group-hover:opacity-0 group-hover:invisible"
                >
                    EPS: {{ episodes_released + ' / ' + episodes_total }}
                </div>

                <div class="absolute w-full p-2 h-14 bottom-0 flex justify-center items-center transition-all duration-500 invisible opacity-0 bg-black/25
                group-hover:visible group-hover:opacity-100 backdrop-blur"
                >
                    <span class="text-center line-clamp-2">
                        {{ title }}
                    </span>
                </div>
            </router-link>
        </div>
    </div>
</template>
