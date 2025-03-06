<script>
import CardAnime from '../../Components/Animes/CardAnime.vue';
import CardLoading from '../../Components/CardLoading.vue';
import Pagination from '../../Components/Pagination.vue';
import Search from '../../Components/Search.vue';
import { push } from 'notivue';

export default {
    name: 'IndexPage',
    components: { Search, Pagination, CardLoading, CardAnime },
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
            selectedSearchData: {
                page: Number,
                title: String,
                types: Array,
                genres: Array,
                genres_exclude: Array,
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
        async getAnimesData() {
            this.dataLoading = false;
            await axios
                .get('/api/animes', { params: this.selectedSearchData })
                .then((response) => {
                    this.dataAnimes = response.data.data;
                    this.dataPagination = response.data.meta;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data.message);
                });
        },
        updateSelectFilters(filters) {
            this.selectedSearchData = { ...this.selectedSearchData, ...filters.selectedSearchData };

            this.getAnimesData();
        },
        pageChange(page) {
            this.$refs.searchRef.changePage(page);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    },
};
</script>

<template>
    <section id="TopPage">
        <Search
            @updateSelectFilters="updateSelectFilters"
            ref="searchRef"
        />

        <div class="mt-2 grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5">
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
                v-if="!dataLoading"
                v-for="n in 24"
                :key="n"
            />
        </div>

        <Pagination
            v-if="dataAnimes"
            :dataPagination="dataPagination"
            @pageChange="pageChange"
        />
    </section>
</template>
