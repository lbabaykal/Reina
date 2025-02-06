<script>
import StarSvg from "../../Components/Svg/StarSvg.vue";
import FavoriteSvg from "../../Components/Svg/FavoriteSvg.vue";
import PlaySvg from "../../Components/Svg/PlaySvg.vue";
import LoadingSvg from "../../Components/Svg/LoadingSvg.vue";
import Description from "../../Components/Animes/Description.vue";
import SendSvg from "../../Components/Svg/SendSvg.vue";
import Rating from "./Modals/Rating.vue";
import Favorite from "./Modals/Favorite.vue";
import ToolTip from "../../Components/ToolTip.vue";

export default {
    name: "AnimeShowPage",
    components: {ToolTip, Favorite, Rating, SendSvg, Description, LoadingSvg, PlaySvg, FavoriteSvg, StarSvg},
    props: {
        slug: String,
    },
    data() {
        return {
            dataAnime: {
                id: Number,
                slug: String,
                poster: String,
                cover: String,
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
                studios: {
                    id: Number,
                    slug: String,
                    title: String,
                },
                countries: {
                    id: Number,
                    slug: String,
                    title_ru: String,
                    title_en: String,
                },
                age_rating: String,
                episodes_released: Number,
                episodes_total: Number,
                duration: String,
                release: String,
                year: Number,
                description: Text,
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
            dataLoading: false,
        }
    },
    methods: {
        getAnimeData() {
            this.dataLoading = false;
            axios.get(`/api/animes/${this.slug}`)
                .then(response => {
                    this.dataAnime = response.data.dataAnime;
                    this.dataUserForAnime = response.data.dataUserForAnime;
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
    <div>
        <section v-if="dataLoading">
            <div class="relative w-full aspect-[16/7] flex flex-row select-none">
                <div class="absolute bottom-24 left-24 min-w-120 max-w-200 flex flex-col justify-end justify-items-stretch items-center z-20 bg-black/60 backdrop-blur rounded py-2.5 px-5">

                    <div class="w-full text-2xl font-bold text-center my-1">
                        {{ dataAnime.title_ru }}
                    </div>

                    <div class="w-full flex flex-row items-center justify-center my-1 text-gray-300 text-lg divide-x divide-gray-500">
                        <span class="px-3 py-0.5 text-lime-400 font-bold text-2xl">{{ dataAnime.rating }}</span>

                        <span v-if="isEpisodes"
                              class="px-3"
                        >
                            {{ dataAnime.episodes_released }} / {{ dataAnime.episodes_total }}
                        </span>
                        <span class="px-3">
                            {{ dataAnime.duration }}
                        </span>

                        <router-link :to="{ name: 'animes.index', query: { year_from: dataAnime.year, year_to: dataAnime.year } }"
                                     class="px-3 underline decoration-1 underline-offset-4 hover:decoration-red-500 hover:text-red-500 tracking-wide"
                        >
                            {{ dataAnime.year }}
                        </router-link>

                        <span class="px-3 text-red-500 text-xl font-bold">
                            {{ dataAnime.age_rating }}
                        </span>
                    </div>

                    <div class="w-full my-1.5 text-gray-300 flex flex-row justify-center items-center content-center">
                        <div v-for="(dataAnimeGenre, index) in dataAnime.genres">
                            <router-link :to="{ name: 'animes.index', query: { genres: dataAnimeGenre.slug } }"
                                         class="underline decoration-1 underline-offset-4 hover:decoration-red-500 hover:text-red-500 tracking-wide"
                            >
                                {{ dataAnimeGenre.title_ru }}
                            </router-link>
                            <span v-if="index !== dataAnime.genres.length - 1" class="mx-1.5 text-red-500">|</span>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-center items-center content-center my-3 space-x-3">
                        <router-link :to="{ name: 'animes.watch', params: { slug: dataAnime.slug } }">
                            <div class="group px-12 py-2 rounded relative flex flex-row justify-center items-center text-white font-bold bg-gradient-to-r from-orange-500 via-red-500 to-violet-600"
                            >
                                <PlaySvg classes="w-7 h-7 inline-block"/>
                                &nbsp;Смотреть онлайн
                                <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-orange-500 via-red-500 to-violet-600 blur-md -z-10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                            </div>
                        </router-link>

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
                    </div>
                </div>

                <div class="absolute top-0 left-0 w-full h-full bg-center bg-cover shadow-[0px_-80px_100px_25px_rgba(0,0,0,1)_inset] z-10"
                     :style="{ backgroundImage: `url(${dataAnime.cover})` }">
                </div>
            </div>

            <Description :dataAnime="this.dataAnime"
                         :isEpisodes="isEpisodes"
            />

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
        </section>

        <section v-else
                 class="flex items-center justify-center h-screen"
        >
            <LoadingSvg classes="w-20 fill-red-500"/>
        </section>
    </div>
</template>
