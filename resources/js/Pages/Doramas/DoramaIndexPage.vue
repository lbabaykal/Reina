<script>
import CardLoadingComponent from "@/Components/CardLoadingComponent.vue";
import PaginationComponent from "@/Components/PaginationComponent.vue";
import SearchComponent from "@/Components/SearchComponent.vue";
import CardDoramaComponent from "@/Components/CardDoramaComponent.vue";

export default {
    name: "DoramaIndexPage",
    components: {CardDoramaComponent, SearchComponent, PaginationComponent, CardLoadingComponent},
    data() {
        return {
            dataDoramas: [],
            dataLoading: false,
            dataPagination: Object,
        }
    },
    methods: {
        getDoramasData(page = 1) {
            this.dataLoading = false;
            axios.get('api/doramas',{
                params: {
                    page: page
                }
            })
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
        onPageChange(page) {
            this.$router.push({ query: { page: page } });
        },
    },
    created() {
        const page = this.$route.query.page || 1;
        this.getDoramasData(page);
    },
    beforeRouteUpdate(to, from, next) {
        const newPage = to.query.page || 1;
        this.getDoramasData(newPage);
        next();
    },
}
</script>

<template>
    <section class="margin-content">

        <SearchComponent/>

        <div class="w-full mt-2 px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8">
            <CardDoramaComponent v-if="dataLoading"
                                v-for="dataDorama in dataDoramas"
                                :id="dataDorama.id"
                                :slug="dataDorama.slug"
                                :poster="dataDorama.poster"
                                :title="dataDorama.title"
                                :rating="dataDorama.rating"
                                :episodes_released="dataDorama.episodes_released"
                                :episodes_total="dataDorama.episodes_total"
            />

            <CardLoadingComponent v-else
                                  v-for="n in 24"
                                  :key="n"
            />
        </div>

        <PaginationComponent v-if="dataDoramas"
                             :dataPagination="dataPagination"
                             @change-page="onPageChange"
        />
<!--        :getDoramasData="getDoramasData"-->
    </section>
</template>
