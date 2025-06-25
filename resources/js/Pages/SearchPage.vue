<script>
import CardDorama from '../Components/Doramas/CardDorama.vue';
import CardAnime from '../Components/Animes/CardAnime.vue';
import CardLoading from '../Components/Cards/CardLoading.vue';
import Search from '../Components/Search.vue';
import { push } from 'notivue';

export default {
    name: 'SearchPage',
    components: { Search, CardLoading, CardAnime, CardDorama },
    data() {
        return {
            dataAnimes: [],
            animesTotalFound: 0,
            dataDoramas: [],
            doramasTotalFound: 0,
            dataLoading: false,
            selectedSearchData: {
                page: Number,
                title: String,
                types: Array,
                genres: Array,
                studios: Array,
                countries: Array,
                strict_genre: Boolean,
                strict_studio: Boolean,
                year_from: Number,
                year_to: Number,
                sorting: String,
            },
        };
    },
    methods: {
        async getSearchData() {
            this.dataLoading = false;
            await axios
                .get('/api/search', { params: this.selectedSearchData })
                .then((response) => {
                    this.dataAnimes = response.data.dataAnimes;
                    this.dataDoramas = response.data.dataDoramas;
                    this.animesTotalFound = response.data.animesTotalFound;
                    this.doramasTotalFound = response.data.doramasTotalFound;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        updateSelectFilters(filters) {
            this.selectedSearchData = { ...this.selectedSearchData, ...filters.selectedSearchData };

            this.getSearchData();
        },
    },
};
</script>

<template>
    <section>
        <Search @updateSelectFilters="updateSelectFilters" />

        <div class="flex flex-row items-center justify-center py-3 select-none">
            <router-link
                :to="{ name: 'animes.index', query: { ...$route.query } }"
                class="group flex flex-row items-center justify-center text-3xl font-bold"
            >
                <span class="text-red-500">❮</span>
                <span class="px-3 text-black duration-300 group-hover:pl-5 dark:text-white">НАЙДЕНО</span>
                <span class="text-4xl text-red-500">{{ this.animesTotalFound }}</span>
                <span class="px-3 text-black duration-300 group-hover:pr-5 dark:text-white">АНИМЕ</span>
                <span class="text-red-500">❯</span>
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
                v-for="n in 8"
                :key="n"
            />
        </div>

        <div class="flex flex-row items-center justify-center py-3 select-none">
            <router-link
                :to="{ name: 'doramas.index', query: { ...$route.query } }"
                class="group flex flex-row items-center justify-center text-3xl font-bold"
            >
                <span class="text-violet-500">❮</span>
                <span class="px-3 text-black duration-300 group-hover:pl-5 dark:text-white">НАЙДЕНА</span>
                <span class="text-4xl text-violet-500">{{ this.doramasTotalFound }}</span>
                <span class="px-3 text-black duration-300 group-hover:pr-5 dark:text-white">ДОРАМА</span>
                <span class="text-violet-500">❯</span>
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
                v-for="n in 8"
                :key="n"
            />
        </div>
    </section>
</template>
