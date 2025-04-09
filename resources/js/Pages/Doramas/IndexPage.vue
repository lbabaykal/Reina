<script>
import CardDorama from '../../Components/Doramas/CardDorama.vue';
import Search from '../../Components/Search.vue';
import Pagination from '../../Components/Pagination.vue';
import CardLoading from '../../Components/CardLoading.vue';
import { push } from 'notivue';

export default {
    name: 'IndexPage',
    components: { CardDorama, Search, Pagination, CardLoading },
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
        async getDoramasData() {
            this.dataLoading = false;
            await axios
                .get('/api/doramas', { params: this.selectedSearchData })
                .then((response) => {
                    this.dataDoramas = response.data.data;
                    this.dataPagination = response.data.meta;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        updateSelectFilters(filters) {
            this.selectedSearchData = { ...this.selectedSearchData, ...filters.selectedSearchData };

            this.getDoramasData();
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

        <div class="mt-4 grid w-full grid-flow-row grid-cols-8 place-items-center gap-3 px-2.5">
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
                v-for="n in 24"
                :key="n"
            />
        </div>

        <Pagination
            v-if="dataDoramas"
            :dataPagination="dataPagination"
            @pageChange="pageChange"
        />
    </section>
</template>
