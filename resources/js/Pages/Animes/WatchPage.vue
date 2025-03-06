<script>
import StarSvg from '../../Components/Svg/StarSvg.vue';
import Rating from '../../Components/Animes/Modals/Rating.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import FavoriteSvg from '../../Components/Svg/FavoriteSvg.vue';
import Favorite from '../../Components/Animes/Modals/Favorite.vue';
import FavoriteButton from '../../Components/ui/Buttons/FavoriteButton.vue';
import RatingButton from '../../Components/ui/Buttons/RatingButton.vue';
import EpisodesButton from '../../Components/ui/Buttons/EpisodesButton.vue';
import { push } from 'notivue';

export default {
    name: 'WatchPage',
    components: { EpisodesButton, RatingButton, FavoriteButton, Favorite, FavoriteSvg, LoadingSvg, Rating, StarSvg },
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
            },
        };
    },
    methods: {
        async getAnimeData() {
            this.dataLoading = false;
            await axios
                .get(`/api/animes/${this.slug}/watch`)
                .then((response) => {
                    this.dataAnime = response.data.dataAnime;
                    this.dataUserForAnime = response.data.dataUserForAnime;
                    this.dataEpisodes = response.data.dataEpisodes || [];
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data.message);
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
        isRatingUser() {
            return this.dataUserForAnime.rating !== 0;
        },
        isFavoriteUser() {
            return this.dataUserForAnime.favorite.id !== 0;
        },
    },
    mounted() {
        this.getAnimeData();
    },
};
</script>

<template>
    <section v-if="dataLoading">
        <div class="bg-blackSimple flex h-16 w-full items-center justify-center text-white">
            <div class="w-90% flex shrink-0 items-center justify-between px-5">
                <div class="flex flex-col">
                    <div class="max-w-100% truncate">
                        <router-link
                            :to="{ name: 'animes.show', params: { slug: this.slug } }"
                            class="text-2xl transition-all duration-300 hover:text-red-500"
                        >
                            {{ dataAnime.title_ru }}
                        </router-link>
                    </div>

                    <div class="flex items-center text-white select-none">
                        <div class="flex shrink-0 font-bold">
                            {{ dataAnime.types.title_ru }}
                        </div>

                        <div class="flex flex-row px-2">
                            <span v-for="(dataAnimeGenre, index) in dataAnime.genres">
                                <router-link
                                    :to="{ name: 'animes.index', query: { genres: dataAnimeGenre.slug } }"
                                    class="mx-1 tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                                >
                                    {{ dataAnimeGenre.title_ru }}
                                </router-link>
                                <span
                                    v-if="index !== dataAnime.genres.length - 1"
                                    class="mx-1.5 text-red-500"
                                    >|</span
                                >
                            </span>
                        </div>

                        <div class="pr-2 text-lg font-bold text-red-500">
                            {{ dataAnime.age_rating }}
                        </div>

                        <div class="flex shrink-0 flex-row items-end">
                            <StarSvg classes="size-5 my-auto mx-1 stroke-amber-400 fill-amber-400" />
                            <span class="text-lg text-yellow-400">
                                {{ dataAnime.rating }}
                            </span>
                            <span class="px-1 text-gray-400"> / {{ dataAnime.count_assessments }} </span>
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 flex-row items-center justify-end space-x-4">
                    <RatingButton
                        :is_rating="dataAnime.is_rating"
                        :isRatingUser="isRatingUser"
                        @clickMethod="openRatingModal"
                    />

                    <FavoriteButton
                        :isFavoriteUser="isFavoriteUser"
                        @click="openFavoriteModal"
                    />

                    <EpisodesButton
                        v-if="isEpisodes"
                        @click="toggleEpisodesMenu"
                        :text="`Эпизодов ${dataAnime.episodes_released} / ${dataAnime.episodes_total}`"
                    />
                </div>

                <Rating
                    ref="ratingRef"
                    :animeId="dataAnime.id"
                    :dataUserForAnime="dataUserForAnime"
                    :isRatingUser="isRatingUser"
                />

                <Favorite
                    ref="favoriteRef"
                    :animeId="dataAnime.id"
                    :dataUserForAnime="dataUserForAnime"
                    :isFavoriteUser="isFavoriteUser"
                />
            </div>
        </div>

        <div class="w-90% mx-auto mt-2.5 flex flex-row justify-center px-5">
            <div class="w-full max-w-360 min-w-120 overflow-hidden rounded-lg bg-lime-600">
                <iframe
                    class="aspect-16/9 w-full"
                    src="https://www.youtube.com/embed/oEJVq2Cpg3k"
                    allowfullscreen
                ></iframe>
            </div>

            <div
                v-if="episodesMenu"
                class="bg-blackBack/70 border-blackActive ml-5 aspect-9/16 w-full max-w-96 min-w-60 overflow-hidden rounded-md border py-1.5 text-white backdrop-blur-sm select-none"
            >
                <div
                    v-if="dataEpisodes.length !== 0"
                    class="max-h-full overflow-hidden overflow-y-scroll rounded-md pr-1.5 pl-2.5 text-base"
                >
                    <div
                        v-for="(dataEpisode, index) in dataEpisodes"
                        class="bg-blackSimple my-1.5 block cursor-pointer truncate rounded-md p-3 hover:bg-gray-100 hover:text-black"
                    >
                        {{ dataEpisode.number + '. ' + dataEpisode.title_ru }}
                    </div>
                </div>
                <div
                    v-else
                    class="flex h-full w-full items-center justify-center text-2xl text-red-400"
                >
                    Пусто
                </div>
            </div>
        </div>
        <div class="mt-5">КОММЕНТАРИИ</div>
    </section>
    <section
        v-else
        class="flex h-screen items-center justify-center"
    >
        <LoadingSvg classes="w-20 fill-red-500" />
    </section>
</template>
