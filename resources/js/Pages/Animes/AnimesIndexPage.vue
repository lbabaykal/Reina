<script>
import CardAnimeComponent from "@/Components/CardAnimeComponent.vue";
import CardLoadingComponent from "@/Components/CardLoadingComponent.vue";
import PaginationComponent from "@/Components/PaginationComponent.vue";
import SearchComponent from "@/Components/SearchComponent.vue";

export default {
    name: "AnimesIndexPage",
    components: {SearchComponent, PaginationComponent, CardLoadingComponent, CardAnimeComponent},
    data() {
        return {
            dataAnimes: [],
            dataLoading: false,
            dataPagination: Object,
        }
    },
    methods: {
        getAnimesData(page = 1) {
            this.dataLoading = false;
            axios.get('api/anime',{
                params: {
                    page: page
                }
            })
                .then( response => {
                    this.dataAnimes = response.data.data;
                    this.dataPagination = response.data.meta;
                })
                .catch( error => {
                    // console.log(error.response)
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
        this.getAnimesData(page);
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

        <SearchComponent/>

        <div class="w-full mt-2 px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8">
            <CardAnimeComponent v-if="dataLoading"
                                v-for="dataAnime in dataAnimes"
                                :id="dataAnime.id"
                                :slug="dataAnime.slug"
                                :poster="dataAnime.poster"
                                :title="dataAnime.title"
                                :rating="dataAnime.rating"
                                :episodes_released="dataAnime.episodes_released"
                                :episodes_total="dataAnime.episodes_total"
            />

            <CardLoadingComponent v-else
                                  v-for="n in 24"
            />
        </div>

        <PaginationComponent :dataPagination="dataPagination"
                             @change-page="onPageChange"
        />
<!--        :getAnimesData="getAnimesData"-->
    </section>
</template>
