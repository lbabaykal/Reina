<script>
import StarSvg from '../../Components/Svg/StarSvg.vue';
import Rating from '../../Components/Doramas/Modals/Rating.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import FavoriteSvg from '../../Components/Svg/FavoriteSvg.vue';
import Favorite from '../../Components/Doramas/Modals/Favorite.vue';
import FavoriteButton from '../../Components/ui/Buttons/FavoriteButton.vue';
import RatingButton from '../../Components/ui/Buttons/RatingButton.vue';
import EpisodesButton from '../../Components/ui/Buttons/EpisodesButton.vue';
import CheckSvg from '../../Components/Svg/CheckSvg.vue';
import { push } from 'notivue';

export default {
    name: 'WatchPage',
    components: { CheckSvg, EpisodesButton, RatingButton, FavoriteButton, Favorite, FavoriteSvg, LoadingSvg, Rating, StarSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            dataDorama: {
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
            dataUserForDorama: {
                rating: Number,
                favorite: {
                    folder_id: 0,
                    episode: 0,
                },
            },
            dataEpisodes: [],
            dataLoading: false,
            episodesMenu: true,
        };
    },
    methods: {
        getDoramaData() {
            this.dataLoading = false;
            axios
                .get(`/api/doramas/${this.slug}/watch`)
                .then((response) => {
                    this.dataDorama = response.data.dataDorama;
                    this.dataUserForDorama = response.data.dataUserForDorama;
                    this.dataEpisodes = response.data.dataEpisodes || [];
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data.message);
                });
        },
        async changeFavoriteEpisode(episode) {
            axios
                .post(`/api/doramas/${this.dataDorama.id}/favorite-change`, { folder_id: this.dataUserForDorama.favorite.folder_id, episode: episode })
                .then((response) => {
                    this.dataUserForDorama.favorite = response.data.favorite;
                    push.success(response.data.message);
                })
                .catch((error) => {
                    push.error(error.response.data);
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
            return this.dataDorama.episodes_total !== 1;
        },
        isRatingUser() {
            return this.dataUserForDorama.rating !== 0;
        },
        isFavoriteUser() {
            return this.dataUserForDorama.favorite.folder_id !== 0;
        },
        isFavoriteEpisode() {
            return (value) => {
                return value === this.dataUserForDorama.favorite.episode;
            };
        },
        isCheckedEpisode() {
            return (value) => {
                return value < this.dataUserForDorama.favorite.episode;
            };
        },
        isUncheckedEpisode() {
            return (value) => {
                return value > this.dataUserForDorama.favorite.episode;
            };
        },
    },
    mounted() {
        this.getDoramaData();
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
                            :to="{ name: 'doramas.show', params: { slug: this.slug } }"
                            class="text-2xl transition-all duration-300 hover:text-violet-500"
                        >
                            {{ dataDorama.title_ru }}
                        </router-link>
                    </div>

                    <div class="flex items-center text-white select-none">
                        <div class="flex shrink-0 font-bold">
                            {{ dataDorama.types.title_ru }}
                        </div>

                        <div class="flex flex-row px-2">
                            <span v-for="(dataDoramaGenre, index) in dataDorama.genres">
                                <router-link
                                    :to="{ name: 'doramas.index', query: { genres: dataDoramaGenre.slug } }"
                                    class="mx-1 tracking-wide underline decoration-1 underline-offset-4 hover:text-violet-500 hover:decoration-violet-500"
                                >
                                    {{ dataDoramaGenre.title_ru }}
                                </router-link>
                                <span
                                    v-if="index !== dataDorama.genres.length - 1"
                                    class="mx-1.5 text-violet-500"
                                    >|</span
                                >
                            </span>
                        </div>

                        <div class="pr-2 text-lg font-bold text-red-500">
                            {{ dataDorama.age_rating }}
                        </div>

                        <div class="flex shrink-0 flex-row items-end">
                            <StarSvg classes="size-5 my-auto mx-1 stroke-amber-400 fill-amber-400" />
                            <span class="text-lg text-yellow-400">
                                {{ dataDorama.rating }}
                            </span>
                            <span class="px-1 text-gray-400"> / {{ dataDorama.count_assessments }} </span>
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 flex-row items-center justify-end space-x-4">
                    <RatingButton
                        :is_rating="dataDorama.is_rating"
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
                        :text="`Эпизодов ${dataDorama.episodes_released} / ${dataDorama.episodes_total}`"
                    />
                </div>

                <Rating
                    ref="ratingRef"
                    :doramaId="dataDorama.id"
                    :dataUserForDorama="dataUserForDorama"
                    :isRatingUser="isRatingUser"
                />

                <Favorite
                    ref="favoriteRef"
                    :doramaId="dataDorama.id"
                    :dataUserForDorama="dataUserForDorama"
                    :isFavoriteUser="isFavoriteUser"
                />
            </div>
        </div>

        <div class="w-90% mx-auto mt-2.5 flex flex-row justify-center px-5">
            <div class="w-full max-w-360 min-w-120 overflow-hidden rounded-lg bg-lime-600">

                kek

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
                        class="bg-blackSimple my-1.5 cursor-pointer rounded-md px-3 py-2 hover:bg-gray-100 hover:text-black"
                    >
                        <div class="flex flex-row">
                            <FavoriteSvg
                                v-if="isFavoriteEpisode(dataEpisode.number)"
                                classes="size-6 stroke-red-500 hover:fill-red-500 fill-red-500"
                                @click="changeFavoriteEpisode(dataEpisode.number)"
                            />

                            <CheckSvg
                                v-if="isCheckedEpisode(dataEpisode.number)"
                                classes="size-6 stroke-lime-500 fill-lime-500 hover:stroke-rose-500 hover:fill-rose-500"
                                @click="changeFavoriteEpisode(dataEpisode.number)"
                            />

                            <FavoriteSvg
                                v-if="isUncheckedEpisode(dataEpisode.number)"
                                classes="size-6 stroke-red-500 hover:fill-red-500 fill-transparent"
                                @click="changeFavoriteEpisode(dataEpisode.number)"
                            />

                            <div class="ml-2 truncate">
                                {{ dataEpisode.number + '. ' + dataEpisode.title_ru }}
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-else
                    class="flex h-full w-full items-center justify-center text-2xl text-violet-400"
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
