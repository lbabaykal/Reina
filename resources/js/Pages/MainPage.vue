<script>
import CardDorama from '../Components/Doramas/CardDorama.vue';
import CardAnime from '../Components/Animes/CardAnime.vue';
import CardLoading from '../Components/Cards/CardLoading.vue';
import { push } from 'notivue';

export default {
    name: 'MainPage',
    components: { CardDorama, CardAnime, CardLoading },
    data() {
        return {
            dataAnimes: Array,
            dataDoramas: Array,
            dataLoading: false,
        };
    },
    methods: {
        getMainData() {
            this.dataLoading = false;
            axios
                .get('/api/main')
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
        this.getMainData();
    },
};
</script>

<template>
    <section>
        <div class="flex flex-row items-center justify-center py-3 select-none">
            <router-link
                :to="{ name: 'animes.index' }"
                class="group flex flex-row items-center justify-center font-bold"
            >
                <span class="text-3xl text-red-500">❮</span>
                <span class="px-3 text-4xl text-black duration-300 group-hover:px-5 group-hover:text-red-500 dark:text-white">АНИМЕ</span>
                <span class="text-3xl text-red-500">❯</span>
            </router-link>
        </div>

        <div class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5">
            <CardAnime
                v-if="dataLoading"
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

            <CardLoading
                v-else
                v-for="n in 16"
                :key="n"
            />
        </div>

        <div class="flex flex-row items-center justify-center py-3 select-none">
            <router-link
                :to="{ name: 'doramas.index' }"
                class="group flex flex-row items-center justify-center font-bold"
            >
                <span class="text-3xl text-violet-500">❮</span>
                <span class="px-3 text-4xl text-black duration-300 group-hover:px-5 group-hover:text-violet-500 dark:text-white">ДОРАМЫ</span>
                <span class="text-3xl text-violet-500">❯</span>
            </router-link>
        </div>

        <div class="grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5">
            <CardDorama
                v-if="dataLoading"
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

            <CardLoading
                v-else
                v-for="n in 16"
                :key="n"
            />
        </div>
    </section>
</template>
