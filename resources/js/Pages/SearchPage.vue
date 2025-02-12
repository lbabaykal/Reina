<script>
import CardDorama from "../Components/Doramas/CardDorama.vue";
import CardAnime from "../Components/Animes/CardAnime.vue";
import CardLoading from "../Components/CardLoading.vue";
import Search from "../Components/Search.vue";

export default {
    name: "SearchPage",
    components: {Search, CardLoading, CardAnime, CardDorama},
    data() {
        return {
            dataAnimes: [],
            animesTotalFound: 0,
            dataDoramas: [],
            doramasTotalFound: 0,
            dataLoading: false,
            selectedDataSearch: {
                page: 1,
                title: null,
                types: [],
                genres: [],
                studios: [],
                countries: [],
                strict_genre: false,
                strict_studio: false,
                year_from: null,
                year_to: null,
                sorting: null,
            },
        }
    },
    methods: {
        async getSearchData() {
            this.dataLoading = false;
            await axios.get('/api/search',  { params: this.selectedDataSearch })
                .then(response => {
                    this.dataAnimes = response.data.dataAnimes;
                    this.dataDoramas = response.data.dataDoramas;
                    this.animesTotalFound = response.data.animesTotalFound;
                    this.doramasTotalFound = response.data.doramasTotalFound;
                })
                .catch(error => {
                    console.log(error.response)
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        },
        updateSelectFilters(filters) {
            this.selectedDataSearch = { ...this.selectedDataSearch, ...filters.selectedDataSearch };
            this.selectedDataSearch.page = 1;
            this.routerPush();
        },
        pageChange(page) {
            this.selectedDataSearch.page = page;
            this.routerPush();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        loadFiltersFromRoute() {
            const query = this.$route.query;

            this.selectedDataSearch = {
                page: Number(query.page) || 1,
                types: Array.isArray(query.types) ? query.types : [query.types],
                genres: Array.isArray(query.genres) ? query.genres : [query.genres],
                studios: Array.isArray(query.studios) ? query.studios : [query.studios],
                countries: Array.isArray(query.countries) ? query.countries : [query.countries],
                title: query.title || '',
                strict_genre: query.strict_genre === 'true',
                strict_studio: query.strict_studio === 'true',
                year_from: query.year_from ? Number(query.year_from) : null,
                year_to: query.year_to ? Number(query.year_to) : null,
                sorting: query.sorting || '',
            };
        },
        routerPush() {
            this.$router.push({ query: { ...this.selectedDataSearch } });
        }
    },
    mounted() {
        this.loadFiltersFromRoute();
        this.getSearchData();
    },
    watch: {
        '$route.query': function() {
            this.loadFiltersFromRoute();
            this.getSearchData();
        }
    },
}
</script>

<template>
    <div class="mt-15">
        <Search @updateSelectFilters="updateSelectFilters"
                :selectedDataSearch="selectedDataSearch"
        />

        <div class="py-1 my-2 select-none flex flex-row items-center justify-center">
            <router-link :to="{ name: 'animes.index', query: { ...$route.query } }"
                         class="font-bold group flex flex-row items-center justify-center text-3xl"
            >
                <span class="text-red-500">❮</span>
                <span class="px-3 group-hover:text-red-500 duration-300">НАЙДЕНО</span>
                <span class="text-red-500 text-4xl">{{ this.animesTotalFound }}</span>
                <span class="px-3 group-hover:text-red-500 duration-300">АНИМЕ</span>
                <span class="text-red-500">❯</span>
            </router-link>
        </div>

        <div class="w-full px-2.5 grid gap-3 grid-cols-8 place-items-center grid-flow-row ">
            <CardAnime v-if="dataLoading"
                       v-for="dataAnime in dataAnimes"
                       :id="dataAnime.id"
                       :slug="dataAnime.slug"
                       :poster="dataAnime.poster"
                       :title="dataAnime.title"
                       :rating="dataAnime.rating"
                       :episodes_released="dataAnime.episodes_released"
                       :episodes_total="dataAnime.episodes_total"
            />

            <CardLoading v-else v-for="n in 8" :key="n" />
        </div>

        <div class="py-1 my-2 select-none flex flex-row items-center justify-center">
            <router-link :to="{ name: 'doramas.index', query: { ...$route.query } }"
                         class="font-bold group flex flex-row items-center justify-center text-3xl"
            >
                <span class="text-violet-500">❮</span>
                <span class="px-3 group-hover:text-violet-500 duration-300">НАЙДЕНО</span>
                <span class="text-violet-500 text-4xl">{{ this.doramasTotalFound }}</span>
                <span class="px-3 group-hover:text-violet-500 duration-300">ДОРАМА</span>
                <span class="text-violet-500">❯</span>
            </router-link>
        </div>

        <div class="w-full px-2.5 grid gap-3 grid-cols-8 place-items-center grid-flow-row">
            <CardDorama v-if="dataLoading"
                        v-for="dataDorama in dataDoramas"
                        :id="dataDorama.id"
                        :slug="dataDorama.slug"
                        :poster="dataDorama.poster"
                        :title="dataDorama.title"
                        :rating="dataDorama.rating"
                        :episodes_released="dataDorama.episodes_released"
                        :episodes_total="dataDorama.episodes_total"
            />

            <CardLoading v-else v-for="n in 8" :key="n" />
        </div>
    </div>
</template>
