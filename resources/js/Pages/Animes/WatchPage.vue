<script>
import ToolTip from "../../Components/ToolTip.vue";
import StarSvg from "../../Components/Svg/StarSvg.vue";
import Rating from "../../Components/Animes/Modals/Rating.vue";
import LoadingSvg from "../../Components/Svg/LoadingSvg.vue";
import FavoriteSvg from "../../Components/Svg/FavoriteSvg.vue";
import Favorite from "../../Components/Animes/Modals/Favorite.vue";
import DownArrowSvg from "../../Components/Svg/DownArrowSvg.vue";

export default {
    name: "WatchPage",
    components: {DownArrowSvg, Favorite, FavoriteSvg, LoadingSvg, Rating, StarSvg, ToolTip},
    props: {
        slug: String,
    },
    data() {
        return {
            dataAnime: {
                id: Number,
                slug: String,
                title_org: String,
                title_ru: String,
                title_en: String,
                types: {
                    id: Number,
                    slug: String,
                    title_ru: String,
                    title_en: String,
                },
                genres: {
                    id: Number,
                    slug: String,
                    title_ru: String,
                    title_en: String,
                },
                age_rating: String,
                episodes_released: Number,
                episodes_total: Number,
                rating: Number,
                count_assessments: Number,
                is_comment: Boolean,
                is_rating: Boolean,
            },
            dataUserForAnime: {
                rating: Number,
                favorite: {
                    id: Number,
                    title: String,
                },
            },
            dataEpisodes: [],
            dataLoading: false,
            episodesMenu: {
                type: Boolean,
                default: true,
            }
        }
    },
    methods: {
        getAnimeData() {
            this.dataLoading = false;
            axios.get(`/api/animes/${this.slug}/watch`)
                .then(response => {
                    this.dataAnime = response.data.dataAnime;
                    this.dataUserForAnime = response.data.dataUserForAnime;
                    this.dataEpisodes = response.data.dataEpisodes || [];
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        },
        openRatingModal() {
            this.$refs.ratingRef.openRatingModal();
        },
        openFavoriteModal() {
            this.$refs.favoriteRef.openFavoriteModal();
        },
        toggleEpisodesMenu() {
            this.episodesMenu = !this.episodesMenu;
        },
    },
    computed: {
        isEpisodes() {
            return this.dataAnime.episodes_total !== 1;
        },
        isRating() {
            return this.dataUserForAnime.rating !== 0;
        },
        isFavorite() {
            return this.dataUserForAnime.favorite.id !== 0;
        },
    },
    mounted() {
        this.getAnimeData()
    }
}
</script>

<template>
    <section class="mt-15" v-if="dataLoading">
        <div class="w-full h-16 bg-blackSimple text-white flex items-center justify-center">
            <div class="w-90% flex flex-shrink-0 items-center justify-between px-5">
                <div class="flex flex-col">
                    <div class="max-w-100% truncate">
                        <router-link :to="{ name: 'animes.show', params: { slug: this.slug } }"
                                     class="text-2xl hover:text-red-500 duration-300 transition-all"
                        >
                            {{ dataAnime.title_ru }}
                        </router-link>
                    </div>

                    <div class="flex items-center text-white select-none">
                        <div class="flex flex-shrink-0 font-bold">
                             {{ dataAnime.types.title_ru }}
                        </div>

                        <div class="flex flex-row px-2">
                            <span v-for="(dataAnimeGenre, index) in dataAnime.genres">
                                <router-link :to="{ name: 'animes.index', query: { genres: dataAnimeGenre.slug } }"
                                             class="underline decoration-1 underline-offset-4 hover:decoration-red-500 hover:text-red-500 tracking-wide mx-1"
                                >
                                    {{ dataAnimeGenre.title_ru }}
                                </router-link>
                                <span v-if="index !== dataAnime.genres.length - 1" class="mx-1.5 text-red-500">|</span>
                            </span>
                        </div>

                        <div class="text-red-500 text-lg font-bold pr-2">
                            {{ dataAnime.age_rating }}
                        </div>

                        <div class="flex flex-row flex-shrink-0 items-end">
                            <StarSvg classes="size-5 my-auto mx-1 stroke-amber-400 fill-amber-400"/>
                            <span class="text-yellow-400 text-lg">
                                {{ dataAnime.rating }}
                            </span>
                            <span class="px-1 text-gray-400">
                                / {{ dataAnime.count_assessments }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 flex flex-row items-center justify-end space-x-4">
                    <ToolTip message="Оценить"
                             classes="py-2 px-4 bg-gray-600 text-yellow-400"
                    >
                        <button type="button"
                                class="group block bg-gray-700/80 hover:bg-gray-600 p-2 rounded"
                                @click="openRatingModal"
                        >
                            <StarSvg :classes="[
                            'w-7 h-7 stroke-amber-400 group-hover:fill-amber-400',
                            isRating ? 'fill-amber-400' : 'fill-transparent'
                            ]"
                            />
                        </button>
                    </ToolTip>

                    <ToolTip message="В избранное"
                             classes="py-2 px-4 bg-gray-600 text-red-400"
                    >
                        <button type="button"
                                class="group flex flex-row items-center bg-gray-700/80 hover:bg-gray-600 p-2 rounded text-red-500"
                                @click="openFavoriteModal"
                        >
                            <FavoriteSvg :classes="[
                                'w-7 h-7 stroke-red-500 group-hover:fill-red-500',
                                isFavorite ? 'fill-red-500' : 'fill-transparent'
                                ]"
                            />
                        </button>
                    </ToolTip>

                    <button v-if="isEpisodes"
                            @click="toggleEpisodesMenu"
                            type="button"
                            class="flex items-center py-3.5 px-4 rounded bg-gray-700/80 hover:bg-gray-600 whitespace-nowrap"
                    >
                        Эпизодов {{ dataAnime.episodes_released + ' / ' + dataAnime.episodes_total }}
                        <DownArrowSvg classes="size-4 ms-2.5"/>
                    </button>
                </div>

                <Rating ref="ratingRef"
                        :animeId="dataAnime.id"
                        :dataUserForAnime="dataUserForAnime"
                        :isRating="isRating"
                />

                <Favorite ref="favoriteRef"
                          :animeId="dataAnime.id"
                          :dataUserForAnime="dataUserForAnime"
                          :isFavorite="isFavorite"
                />
            </div>
        </div>

        <div class="w-90% flex flex-row mt-2.5 justify-center px-5 mx-auto">
            <div class="min-w-120 w-full max-w-360 bg-lime-600 rounded-lg overflow-hidden">
                <iframe class="w-full aspect-[16/9]" src="https://www.youtube.com/embed/oEJVq2Cpg3k" allowfullscreen></iframe>
            </div>

            <div v-if="episodesMenu"
                 class="min-w-60 w-full max-w-96 aspect-[9/16] text-white rounded-md overflow-hidden bg-blackBack/70 backdrop-blur py-1.5 ml-5 border border-blackActive select-none"
            >
                <div v-if="dataEpisodes.length !== 0"
                     class="max-h-full pl-2.5 pr-1.5 rounded-md overflow-hidden overflow-y-scroll text-base"
                >
                    <div v-for="(dataEpisode, index) in dataEpisodes"
                         class="block p-3 truncate cursor-pointer bg-blackSimple rounded-md hover:bg-gray-100 hover:text-black my-1.5"
                    >
                        {{ dataEpisode.number + '. ' + dataEpisode.title_ru }}
                    </div>
                </div>
                <div v-else
                     class="w-full h-full text-red-400 text-2xl flex justify-center items-center"
                >
                    Пусто
                </div>
            </div>
        </div>
        <div class="mt-5">
            КОММЕНТАРИИ
        </div>
    </section>
    <section v-else
             class="flex items-center justify-center h-screen"
    >
        <LoadingSvg classes="w-20 fill-red-500"/>
    </section>
</template>
