<script>
import CardDorama from "../Components/Doramas/CardDorama.vue";
import CardAnime from "../Components/Animes/CardAnime.vue";
import CardLoading from "../Components/CardLoading.vue";
import { push } from 'notivue';

export default {
    name: "MainPage",
    components: {CardDorama, CardAnime, CardLoading},
    data() {
        return {
            dataAnimes: Array,
            dataDoramas: Array,
            dataLoading: false,
        }
    },
    methods: {
        getMainData() {
            this.dataLoading = false;
            axios.get('/api/main')
                .then(response => {
                    this.dataAnimes = response.data.animes;
                    this.dataDoramas = response.data.doramas;
                    this.dataLoading = true;
                })
                .catch(error => {
                    push.error(error.response.data.message);
                });
        }
    },
    mounted() {
        this.getMainData()
    }
}
</script>

<template>
    <section>
        <div class="py-2 select-none flex flex-row items-center justify-center">
            <router-link :to="{ name: 'animes.index' }"
                         class="font-bold group flex flex-row items-center justify-center"
            >
                <span class="text-red-500 text-3xl">❮</span>
                <span class="group-hover:text-red-500 text-4xl px-3 duration-300 group-hover:px-5">АНИМЕ</span>
                <span class="text-red-500 text-3xl">❯</span>
            </router-link>
        </div>

        <div class="w-full px-2.5 grid gap-3 grid-cols-8 place-items-center grid-flow-row ">
            <CardAnime v-if="dataLoading"
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

            <CardLoading v-else v-for="n in 16" :key="n"/>
        </div>

        <div class="py-2 select-none flex flex-row items-center justify-center">
            <router-link :to="{ name: 'doramas.index' }"
                         class="font-bold group flex flex-row items-center justify-center"
            >
                <span class="text-violet-500 text-3xl">❮</span>
                <span class="group-hover:text-violet-500 text-4xl px-3 duration-300 group-hover:px-5">ДОРАМЫ</span>
                <span class="text-violet-500 text-3xl">❯</span>
            </router-link>
        </div>

        <div class="w-full px-2.5 grid gap-3 grid-cols-8 place-items-center grid-flow-row">
            <CardDorama v-if="dataLoading"
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

            <CardLoading v-else v-for="n in 16" :key="n"/>
        </div>
    </section>
</template>
