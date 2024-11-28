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
            dataPagination: Object,
            searchText: null,
            selectTypes: [],
            selectGenres: [],
            selectStudios: [],
            selectCountries: [],
            strict_genre: '',
            strict_studio: '',
            year_from: null,
            year_to: null,
            selectSorting: null,
        }
    },
    methods: {
        async getAnimesData(page = 1) {
            this.dataLoading = false;
            await axios.get('api/animes', {
                params: {
                    page: page,
                    types: this.selectTypes,
                    genres: this.selectGenres,
                    studios: this.selectStudios,
                    countries: this.selectCountries,
                    title: this.searchText,
                    strict_genre: this.strict_genre,
                    strict_studio: this.strict_studio,
                    year_from: this.year_from,
                    year_to: this.year_to,
                    sorting: this.selectSorting,
                }
            })
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
        onPageChange(page) {
            this.$router.push({query: {
                    page: page,
                    types: this.selectTypes,
                    genres: this.selectGenres,
                    studios: this.selectStudios,
                    countries: this.selectCountries,
                    title: this.searchText,
                    strict_genre: this.strict_genre,
                    strict_studio: this.strict_studio,
                    year_from: this.year_from,
                    year_to: this.year_to,
                    sorting: this.selectSorting,
                }
            });
        },
        updateSelectFilters(filters) {
            this.searchText = filters.searchText;
            this.selectTypes = filters.types;
            this.selectGenres = filters.genres;
            this.selectStudios = filters.studios;
            this.selectCountries = filters.countries;
            this.strict_genre = filters.strict_genre;
            this.strict_studio = filters.strict_studio;
            this.year_from = filters.year_from;
            this.year_to = filters.year_to;
            this.selectSorting = filters.sorting;
            this.getAnimesData();
        },
    },
    created() {
        // const page = this.$route.query.page || 1;
        this.getAnimesData();
    },
    beforeRouteUpdate(to, from, next) {
        const newPage = to.query.page || 1;
        this.getAnimesData(newPage);
        next();
    },
}
</script>

<template>
    <section class="margin-content">

        <Search @updateAnimesData="getAnimesData" @updateSelectFilters="updateSelectFilters"/>

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
                    @change-page="onPageChange"
        />
    </section>
</template>
