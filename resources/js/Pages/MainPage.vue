<script>
import CardLoadingComponent from "@/Components/CardLoadingComponent.vue";
import CardAnimeComponent from "@/Components/CardAnimeComponent.vue";
import CardDoramaComponent from "@/Components/CardDoramaComponent.vue";

export default {
    name: "MainPage",
    components: {CardDoramaComponent, CardAnimeComponent, CardLoadingComponent},
    data() {
        return {
            dataAnimes: [],
            dataDoramas: [],
            dataLoading: false,
        }
    },
    methods: {
        getMainPageData() {
            this.dataLoading = false;
            axios.get('api/main')
                .then( response => {
                    console.log(response)
                    this.dataAnimes = response.data['animes'];
                    this.dataDoramas = response.data['doramas'];
                })
                .catch( error => {
                    console.log(error.response)
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        }
    },
    created() {
        this.getMainPageData()
    }
}
</script>

<template>
    <div>
        <section class="margin-content">
            <div class="py-2 select-none flex flex-row items-center justify-center">
                <router-link :to="{ name: 'animes.index' }"
                             class="font-bold group flex flex-row items-center justify-center"
                >
                    <span class="text-red-500 text-3xl">❮</span>
                    <span class="group-hover:text-red-500 text-4xl px-3 duration-300">АНИМЕ</span>
                    <span class="text-red-500 text-3xl">❯</span>
                </router-link>
            </div>

            <div class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8">
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

                <CardLoadingComponent v-else v-for="n in 16" :key="n" />
            </div>

            <div class="py-2 select-none flex flex-row items-center justify-center">
                <router-link :to="{ name: 'doramas.index' }"
                             class="font-bold group flex flex-row items-center justify-center"
                >
                    <span class="text-violet-500 text-3xl">❮</span>
                    <span class="group-hover:text-violet-500 text-4xl px-3 duration-300">ДОРАМЫ</span>
                    <span class="text-violet-500 text-3xl">❯</span>
                </router-link>
            </div>

            <div class="w-full px-2.5 grid gap-3 place-items-center grid-flow-row grid-cols-8">
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

                <CardLoadingComponent v-else v-for="n in 16" :key="n" />
            </div>
        </section>
    </div>
</template>
