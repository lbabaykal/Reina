<script>
import CardLoading from "@/Components/CardLoading.vue";
import Pagination from "@/Components/Pagination.vue";
import Search from "@/Components/Search.vue";
import CardDorama from "@/Components/CardDorama.vue";

export default {
    name: "DoramaIndexPage",
    components: {CardDorama, Search, Pagination, CardLoading},
    data() {
        return {
            dataDoramas: [],
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
        async getDoramasData() {
            this.dataLoading = false;
            await axios.get('/api/doramas',{ params: this.selectedDataSearch })
                .then( response => {
                    this.dataDoramas = response.data.data;
                    this.dataPagination = response.data.meta;
                })
                .catch( error => {
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
        this.getDoramasData();
    },
    watch: {
        '$route.query': function() {
            this.loadFiltersFromRoute();
            this.getDoramasData();
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

            <CardLoading v-else
                                  v-for="n in 24"
                                  :key="n"
            />
        </div>

        <Pagination v-if="dataDoramas"
                    :dataPagination="dataPagination"
                    @pageChange="pageChange"
        />
    </section>
</template>
