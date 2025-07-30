<script>
import CardDorama from '../../../Components/Doramas/CardDorama.vue';
import CardLoading from '../../../Components/Cards/CardLoading.vue';
import CardAnime from '../../../Components/Animes/CardAnime.vue';
import { push } from 'notivue';

export default {
    name: 'IndexPage',
    components: { CardAnime, CardLoading, CardDorama },
    data() {
        return {
            dataAnimes: Array,
            dataDoramas: Array,
            dataLoading: false,
        };
    },
    methods: {
        getFavoriteData() {
            this.dataLoading = false;
            axios
                .get('/api/favorites')
                .then((response) => {
                    this.dataAnimes = response.data.animes;
                    this.dataDoramas = response.data.doramas;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
    },
    mounted() {
        this.getFavoriteData();
    },
};
</script>

<template>
    <section>
        <div>
            <div class="w-full my-3 text-center font-bold select-none">
                <router-link
                    :to="{ name: 'favorites.animes.index' }"
                    class="group"
                >
                    <span class="text-4xl text-black duration-300 group-hover:text-red-500 dark:text-white"> АНИМЕ </span>
                    <span class="text-2xl text-red-500"> Все ❯ </span>
                </router-link>
            </div>

            <div
                v-if="!dataLoading"
                class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5"
            >
                <CardLoading
                    v-for="n in 8"
                    :key="n"
                />
            </div>
            <div
                v-else-if="dataAnimes.length !== 0"
                class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5"
            >
                <CardAnime
                    v-for="dataAnime in dataAnimes"
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
            <div
                v-else
                class="flex w-full justify-center my-6 text-5xl font-bold text-red-400"
            >
                Пусто
            </div>
        </div>

        <div>
            <div class="w-full my-3 text-center font-bold select-none">
                <router-link
                    :to="{ name: 'favorites.doramas.index' }"
                    class="group"
                >
                    <span class="text-4xl text-black duration-300 group-hover:text-violet-500 dark:text-white"> ДОРАМЫ </span>
                    <span class="text-2xl text-violet-500"> Все ❯ </span>
                </router-link>
            </div>

            <div
                v-if="!dataLoading"
                class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5"
            >
                <CardLoading
                    v-for="n in 8"
                    :key="n"
                />
            </div>
            <div
                v-else-if="dataDoramas.length !== 0"
                class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5"
            >
                <CardDorama
                    v-for="dataDorama in dataDoramas"
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
            <div
                v-else
                class="flex w-full justify-center my-6 text-5xl font-bold text-violet-400"
            >
                Пусто
            </div>
        </div>
    </section>
</template>
