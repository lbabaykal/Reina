<script>
import CardLoading from '../../../Components/Cards/CardLoading.vue';
import CardAnime from '../../../Components/Animes/CardAnime.vue';
import Pagination from '../../../Components/Pagination.vue';
import Folders from '../../../Components/Animes/Folders.vue';
import { push } from 'notivue';

export default {
    name: 'AnimesPage',
    components: { Folders, Pagination, CardAnime, CardLoading },
    data() {
        return {
            dataAnimes: [Array, Object],
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
        };
    },
    methods: {
        async getAnimesInFolderData() {
            this.dataLoading = false;
            await axios
                .get('/api/folders/animes/show', { params: this.dataParams })
                .then((response) => {
                    this.dataAnimes = response.data.data;
                    this.dataPagination = response.data.meta;
                })
                .catch((error) => {
                    push.error(error.response.data);
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
        },
    },
    mounted() {
        this.loadParamsFromRoute();
        this.getAnimesInFolderData();
    },
    watch: {
        '$route.query': function () {
            this.loadParamsFromRoute();
            this.getAnimesInFolderData();
        },
    },
};
</script>

<template>
    <section id="TopPage">
        <div class="flex">
            <aside class="fixed top-17 left-0 z-10 flex w-76 justify-center">
                <Folders
                    @updateSelectedFolder="updateSelectedFolder"
                    :selectedFolder="this.dataParams.folder"
                />
            </aside>

            <main class="ml-76 flex-1">
                <div class="mt-2.5 grid grid-flow-row grid-cols-7 gap-2 px-2.5">
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
                        v-for="n in 21"
                        :key="n"
                    />
                </div>

                <Pagination
                    v-if="dataAnimes"
                    :dataPagination="dataPagination"
                    @pageChange="pageChange"
                />
            </main>
        </div>
    </section>
</template>
