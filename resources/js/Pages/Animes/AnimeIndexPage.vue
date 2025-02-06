<script>
import CardAnime from "@/Components/CardAnime.vue";
import CardLoading from "@/Components/CardLoading.vue";
import Pagination from "@/Components/Pagination.vue";
import Search from "@/Components/Search.vue";

export default {
    name: "AnimeIndexPage",
    components: {Search, Pagination, CardLoading, CardAnime},
    data() {
        return {
            dataAnimes: [],
            dataLoading: false,
            dataPagination: {
                links: [],
                current_page: Number,
                from: Number,
                last_page: Number,
                per_page: Number,
                to: Number,
                total: Number,
            },
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
        async getAnimesData() {
            this.dataLoading = false;
            await axios.get('/api/animes',  { params: this.selectedDataSearch })
            .then(response => {
                this.dataAnimes = response.data.data;
                this.dataPagination = response.data.meta;
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
        this.getAnimesData();
    },
    watch: {
        '$route.query': function() {
            this.loadFiltersFromRoute();
            this.getAnimesData();
        }
    },
}
</script>

<template>
    <section id="TopPage" class="mt-15">

        <Search @updateSelectFilters="updateSelectFilters"
                :selectedDataSearch="selectedDataSearch"
        />

        <div class="w-full mt-2 px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8">
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

            <CardLoading v-if="!dataLoading"
                         v-for="n in 24"
                         :key="n"
            />
        </div>

        <Pagination v-if="dataAnimes"
                    :dataPagination="dataPagination"
                    @pageChange="pageChange"
        />
    </section>
</template>
