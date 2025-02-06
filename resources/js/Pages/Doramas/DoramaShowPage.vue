<script>
import FavoriteSvg from "../../Components/Svg/FavoriteSvg.vue";
import PlaySvg from "../../Components/Svg/PlaySvg.vue";
import StarSvg from "../../Components/Svg/StarSvg.vue";
import Description from "../../Components/Doramas/Description.vue";
import LoadingSvg from "../../Components/Svg/LoadingSvg.vue";

export default {
    name: "DoramaShowPage",
    components: {LoadingSvg, Description, StarSvg, PlaySvg, FavoriteSvg},
    props: {
        slug: String,
    },
    data() {
        return {
            dataDorama: [],
            dataUserForDorama: {
                rating: Number,
                favoriteId: Number,
                folders: Array
            },
            dataLoading: false,
        }
    },
    methods: {
        getDoramaData() {
            this.dataLoading = false;
            axios.get(`/api/doramas/${this.slug}`)
                .then(response => {
                    this.dataDorama = response.data['dataDorama'];
                    this.dataUserForDorama = response.data['dataUserForDorama'];
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        }
    },
    mounted() {
        this.getDoramaData()
    }
}
</script>

<template>
    <div>
        <section v-if="dataLoading">
            <div class="relative w-full aspect-[16/7] flex flex-row select-none">
                <div class="absolute bottom-24 left-24 min-w-120 max-w-200 flex flex-col justify-end justify-items-stretch items-center z-10 bg-black/60 backdrop-blur rounded py-2.5 px-5">

                    <div class="w-full text-2xl font-bold text-center my-1">
                        {{ dataDorama.title_ru }}
                    </div>

                    <div class="w-full flex flex-row items-center justify-center my-1 text-gray-300 text-lg divide-x divide-gray-500">
                        <span class="px-3 py-0.5 text-lime-400 font-bold text-2xl">{{ dataDorama.rating }}</span>

                        <span v-if="dataDorama.episodes_total !== 1" class="px-3">
                        {{ dataDorama.episodes_released }} / {{ dataDorama.episodes_total }}
                    </span>

                        <span class="px-3">
                        {{ dataDorama.duration }}
                    </span>

                        <router-link :to="{ name: 'doramas.index', query: { year_from: dataDorama.year, year_to: dataDorama.year } }"
                                     class="px-3 underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                        >
                            {{ dataDorama.year }}
                        </router-link>

                        <span class="px-3 text-violet-500 text-xl font-bold">
                        {{ dataDorama.age_rating }}
                    </span>
                    </div>

                    <div class="w-full my-1.5 text-gray-300 flex flex-row justify-center items-center content-center">
                        <div v-for="(dataDoramaGenre, index) in dataDorama.genres"
                             class="text-nowrap mx-0.5"
                        >
                            <router-link :to="{ name: 'doramas.index', query: { genres: dataDoramaGenre.slug } }"
                                         class="underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                            >
                                {{ dataDoramaGenre.title_ru }}
                            </router-link>
                            <span v-if="index !== dataDorama.genres.length - 1"
                                  class="text-violet-500 text-xs"
                            >
                                &#9679;
                            </span>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-center items-center content-center my-3">
                        <router-link :to="{ name: 'doramas.watch', params: { slug: dataDorama.slug } }">
                            <div class="group px-12 py-2 ml-2 rounded relative flex flex-row justify-center items-center text-white font-bold
                                    bg-gradient-to-r from-orange-500 via-red-500 to-violet-600"
                            >
                                <PlaySvg classes="w-7 h-7 inline-block"/>
                                &nbsp;Смотреть онлайн
                                <div class="absolute inset-0 rounded-lg group-hover:bg-gradient-to-r from-orange-500 via-red-500 to-violet-600 blur-md -z-10"></div>
                            </div>
                        </router-link>

                        <button type="button"
                                class="group block bg-gray-700/80 hover:bg-gray-600 p-2 rounded ml-4"
                        >
                            <StarSvg :classes="[
                                'w-7 h-7 stroke-amber-400 group-hover:fill-amber-400',
                                dataUserForDorama.rating !== 0 ? 'fill-amber-400' : 'fill-transparent'
                                ]"
                            />
                        </button>

                        <button type="button"
                                class="group block bg-gray-700/80 hover:bg-gray-600 p-2 rounded ml-3 mr-2"
                        >
                            <FavoriteSvg :classes="[
                                'w-7 h-7 stroke-red-500 group-hover:fill-red-500',
                                dataUserForDorama.favoriteId !== 0 ? 'fill-red-500' : 'fill-transparent'
                                ]"
                            />
                        </button>
                    </div>
                </div>

                <div class="absolute top-0 left-0 w-full h-full bg-center bg-cover shadow-[0px_-80px_100px_25px_rgba(0,0,0,1)_inset]"
                     :style="{ backgroundImage: `url(${dataDorama.cover})` }">
                </div>
            </div>

            <Description :dataDorama="this.dataDorama"/>

        </section>

        <section v-else>
            <div class="flex items-center justify-center h-screen">
                <LoadingSvg classes="w-20 fill-violet-500"/>
            </div>
        </section>
    </div>
</template>
