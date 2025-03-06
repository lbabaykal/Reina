<script>

import CardDorama from "../../Components/Doramas/CardDorama.vue";
import CardLoading from "../../Components/CardLoading.vue";
import CardAnime from "../../Components/Animes/CardAnime.vue";
import { push } from 'notivue';

export default {
    name: "IndexPage",
    components: {CardAnime, CardLoading, CardDorama},
    data() {
        return {
            dataAnimes: Array,
            dataDoramas: Array,
            dataLoading: false,
        }
    },
    methods: {
        getFavoriteData() {
            this.dataLoading = false;
            axios.get('/api/favorites')
                .then(response => {
                    this.dataAnimes = response.data.animes;
                    this.dataDoramas = response.data.doramas;
                    this.dataLoading = true;
                })
                .catch(error => {
                    push.error(error.response.data.message);
                });
        }
    },
    mounted() {
        this.getFavoriteData();
    }
}
</script>

<template>
    <section>
        <div>
            <div class="w-full font-bold select-none py-2 text-center">
                <router-link :to="{ name: 'favorites.animes.index' }"
                             class="group"
                >
                    <span class="text-4xl group-hover:text-red-500 duration-300"
                    >
                        АНИМЕ
                    </span>
                    <span class="text-red-500 text-2xl">
                        Все ❯
                    </span>
                </router-link>
            </div>

            <div v-if="!dataLoading"
                 class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8"
            >
                <CardLoading v-for="n in 8" :key="n"/>
            </div>
            <div v-else-if="dataAnimes.length !== 0"
                 class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8"
            >
                <CardAnime v-for="dataAnime in dataAnimes"
                           :id="dataAnime.id"
                           :slug="dataAnime.slug"
                           :poster="dataAnime.poster"
                           :title="dataAnime.title"
                           :rating="dataAnime.rating"
                           :episodes_released="dataAnime.episodes_released"
                           :episodes_total="dataAnime.episodes_total"
                           :is_rating="dataAnime.is_rating"
                />
            </div>
            <div v-else
                 class="w-full flex justify-center py-6 text-5xl text-red-400 font-bold"
            >
                Пусто
            </div>
        </div>

        <div>
            <div class="w-full font-bold select-none py-2 text-center ">
                <router-link :to="{ name: 'favorites.doramas.index' }"
                             class="group"
                >
                    <span class="text-4xl group-hover:text-violet-500 duration-300"
                    >
                        ДОРАМЫ
                    </span>
                    <span class="text-violet-500 text-2xl">
                        Все ❯
                    </span>
                </router-link>
            </div>

            <div v-if="!dataLoading"
                 class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8"
            >
                <CardLoading v-for="n in 8" :key="n"/>
            </div>
            <div v-else-if="dataDoramas.length !== 0"
                 class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8"
            >
                <CardDorama v-for="dataDorama in dataDoramas"
                            :id="dataDorama.id"
                            :slug="dataDorama.slug"
                            :poster="dataDorama.poster"
                            :title="dataDorama.title"
                            :rating="dataDorama.rating"
                            :episodes_released="dataDorama.episodes_released"
                            :episodes_total="dataDorama.episodes_total"
                            :is_rating="dataDorama.is_rating"
                />
            </div>
            <div v-else
                 class="w-full flex justify-center py-6 text-5xl text-violet-400 font-bold"
            >
                Пусто
            </div>
        </div>
    </section>
</template>
