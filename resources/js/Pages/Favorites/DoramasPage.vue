<script>
import CardDorama from "../../Components/Doramas/CardDorama.vue";
import CardLoading from "../../Components/CardLoading.vue";
import Pagination from "../../Components/Pagination.vue";
import Folders from "../../Components/Doramas/Folders.vue";


export default {
    name: "DoramasPage",
    components: {Folders, Pagination, CardLoading, CardDorama},
    data() {
        return {
            dataDoramas: [Array, Object],
            selectedFolder: 0,
            dataParams: {
                page: 1,
                folder: 0,
            },
            dataPagination: {
                links: [],
                current_page: Number,
                from: Number,
                last_page: Number,
                per_page: Number,
                to: Number,
                total: Number,
            },
            dataLoading: false,
        }
    },
    methods: {
        async getDoramasInFolderData() {
        this.dataLoading = false;
            await axios.get('/api/folders/doramas/show',  { params: this.dataParams })
                .then(response => {
                this.dataDoramas = response.data.data;
                this.dataPagination = response.data.meta;
                })
                .catch(error => {
                    console.log(error.response)
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        },
        updateSelectedFolder(obj) {
            this.dataParams.folder = obj.selectedFolder;
            this.dataParams.page = 1;
            this.routerPush();
        },
        pageChange(page) {
            this.dataParams.page = page;
            this.routerPush();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        loadParamsFromRoute() {
            const query = this.$route.query;

            this.dataParams = {
                page: Number(query.page) || 1,
                folder: Number(query.folder) || 0,
            };
        },
        routerPush() {
            this.$router.push({ query: { ...this.dataParams } });
        }
    },
    mounted() {
        this.loadParamsFromRoute();
        this.getDoramasInFolderData();
    },
    watch: {
        '$route.query': function() {
            this.loadParamsFromRoute();
            this.getDoramasInFolderData();
        }
    },
}
</script>

<template>
    <section id="TopPage" class="mt-15">
        <div class="flex flex-row w-full">
            <div class="w-15% mt-2.5 mx-2 select-none">
                <Folders @updateSelectedFolder="updateSelectedFolder"
                         :selectedFolder="selectedFolder"
                />
            </div>

            <div class="w-85% mt-2.5 px-2.5 grid gap-2 grid-flow-row grid-cols-7">
                <CardDorama v-if="dataLoading"
                           v-for="dataAnime in dataDoramas"
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
        </div>

        <Pagination v-if="dataDoramas"
                    :dataPagination="dataPagination"
                    @pageChange="pageChange"
        />
    </section>
</template>
