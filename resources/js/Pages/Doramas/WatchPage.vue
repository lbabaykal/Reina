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
import BackSvg from '../../Components/Svg/BackSvg.vue';
import MicrophoneSvg from '../../Components/Svg/MicrophoneSvg.vue';

export default {
    name: 'WatchPage',
    components: { MicrophoneSvg, BackSvg, CheckSvg, EpisodesButton, RatingButton, FavoriteButton, Favorite, FavoriteSvg, LoadingSvg, Rating, StarSvg },
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
                    episode_id: 0,
                },
            },
            dataEpisodes: [],
            dataLoading: false,
            episodesMenu: false,
            selectedEpisode: null,
        };
    },
    methods: {
        async getDoramaData() {
            this.dataLoading = false;
            await axios
                .get(`/api/doramas/${this.slug}/watch`)
                .then((response) => {
                    this.dataDorama = response.data.dataDorama;
                    this.dataUserForDorama = response.data.dataUserForDorama;
                    this.dataEpisodes = response.data.dataEpisodes || [];
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        async changeFavoriteEpisode(episode_id) {
            if (episode_id === this.dataUserForDorama.favorite.episode_id) {
                await axios
                    .delete(`/api/doramas/${this.dataDorama.id}/forget-episode`)
                    .then((response) => {
                        this.dataUserForDorama.favorite.episode_id = 0;
                        push.success(response.data);
                    })
                    .catch((error) => {
                        push.error(error.response.data);
                    });
            } else {
                await axios
                    .post(`/api/doramas/${this.dataDorama.id}/remember-episode`, { folder_id: this.dataUserForDorama.favorite.folder_id, episode_id: episode_id })
                    .then((response) => {
                        this.dataUserForDorama.favorite = response.data.favorite;
                        push.success(response.data);
                    })
                    .catch((error) => {
                        push.error(error.response.data);
                    });
            }
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
        selectEpisode(dataEpisode) {
            this.selectedEpisode = dataEpisode;
        },
        backToEpisodes() {
            this.selectedEpisode = null;
        },
        selectTeam(voice) {
            alert(`Выбран перевод команды: ${voice}`);
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
            return (index) => index === this.favoriteEpisodeIndex;
        },
        isCheckedEpisode() {
            return (index) => index < this.favoriteEpisodeIndex;
        },
        isUncheckedEpisode() {
            return (index) => index > this.favoriteEpisodeIndex;
        },
        favoriteEpisodeIndex() {
            return this.dataEpisodes.findIndex(
                episode => episode.id === this.dataUserForDorama.favorite.episode_id
            );
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

        <div class="w-90% mx-auto mt-4 flex flex-row justify-center">
            <div class="aspect-[16/9] max-h-[100vh] w-full max-w-[70vw] overflow-hidden rounded-lg">
                <iframe
                    class="h-full w-full"
                    src="https://www.youtube.com/embed/dPTmdZn3uw4"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                ></iframe>
            </div>

            <div
                v-if="episodesMenu"
                class="bg-whiteSimple dark:bg-blackSimple relative ml-4 aspect-9/1 w-90 shrink-0 overflow-hidden rounded-lg text-black select-none dark:text-white"
            >
                <div
                    v-if="selectedEpisode"
                    class="bg-whiteSimple dark:bg-blackSimple absolute z-10 h-full w-full"
                >
                    <div class="flex flex-row items-center justify-between px-3 py-1.5">
                        <div class="text-xl font-semibold w-full text-center">Команды</div>

                        <BackSvg
                            classes="size-8"
                            class="dark:bg-blackActive bg-whiteFon hover:bg-blackActive dark:hover:bg-whiteSimple rounded-md fill-black hover:fill-white dark:fill-white dark:hover:fill-black"
                            @click="backToEpisodes"
                        />
                    </div>

                    <ul
                        v-if="selectedEpisode.hasOwnProperty('voices') && selectedEpisode.voices.length !== 0"
                        class="h-full space-y-2 overflow-y-scroll"
                    >
                        <li
                            v-for="voice in selectedEpisode.voices"
                            @click="selectTeam(voice)"
                            class="dark:bg-blackActive bg-whiteActive dark:hover:bg-whiteActive hover:bg-blackActive m-2.5 cursor-pointer rounded-md px-3 py-2 hover:text-white dark:hover:text-black"
                        >
                            <div class="truncate px-2.5 py-1">
                                {{ voice }}
                            </div>
                        </li>
                    </ul>

                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-2xl text-violet-400"
                    >
                        Пусто
                    </div>
                </div>

                <div class="flex h-full w-full flex-col">
                    <div class="flex flex-row items-center px-3 py-2 text-xl font-semibold justify-center">Эпизоды</div>

                    <ul
                        v-if="dataEpisodes.length !== 0"
                        class="h-full space-y-2 overflow-y-scroll"
                    >
                        <li
                            v-for="(dataEpisode, index) in dataEpisodes"
                            class="dark:bg-blackActive bg-whiteActive dark:hover:bg-whiteActive hover:bg-blackActive m-2.5 cursor-pointer rounded-md px-3 py-2 text-base hover:text-white dark:hover:text-black"
                        >
                            <div class="flex flex-row">
                                <FavoriteSvg
                                    v-if="isFavoriteEpisode(index)"
                                    classes="size-6 stroke-red-500 hover:fill-red-500 fill-red-500"
                                    @click.stop="changeFavoriteEpisode(dataEpisode.id)"
                                />
                                <CheckSvg
                                    v-if="isCheckedEpisode(index)"
                                    classes="size-6 stroke-lime-500 fill-lime-500 hover:stroke-rose-500 hover:fill-rose-500"
                                    @click.stop="changeFavoriteEpisode(dataEpisode.id)"
                                />
                                <FavoriteSvg
                                    v-if="isUncheckedEpisode(index)"
                                    classes="size-6 stroke-red-500 hover:fill-red-500 fill-transparent"
                                    @click.stop="changeFavoriteEpisode(dataEpisode.id)"
                                />
                                <div class="mx-2.5 w-full truncate">
                                    {{ (index + 1) + '. ' + dataEpisode.title_ru }}
                                </div>
                                <MicrophoneSvg
                                    classes="size-6 hover:fill-sky-400 hover:text-sky-400"
                                    @click="selectEpisode(dataEpisode)"
                                />
                            </div>
                        </li>
                    </ul>

                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-2xl text-violet-400"
                    >
                        Пусто
                    </div>
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
