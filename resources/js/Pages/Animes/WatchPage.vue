<script>
import StarSvg from '../../Components/Svg/StarSvg.vue';
import Rating from '../../Components/Animes/Modals/Rating.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import FavoriteSvg from '../../Components/Svg/FavoriteSvg.vue';
import Favorite from '../../Components/Animes/Modals/Favorite.vue';
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
                    push.error(error.response.data);
                });
        },
        async changeFavoriteEpisode(episode_id) {
            if (episode_id === this.dataUserForAnime.favorite.episode_id) {
                await axios
                    .delete(`/api/animes/${this.dataAnime.id}/forget-episode`)
                    .then((response) => {
                        this.dataUserForAnime.favorite.episode_id = 0;
                        push.success(response.data);
                    })
                    .catch((error) => {
                        push.error(error.response.data);
                    });
            } else {
                await axios
                    .post(`/api/animes/${this.dataAnime.id}/remember-episode`, { folder_id: this.dataUserForAnime.favorite.folder_id, episode_id: episode_id })
                    .then((response) => {
                        this.dataUserForAnime.favorite = response.data.favorite;
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
            return this.dataAnime.episodes_total !== 1;
        },
        isRatingUser() {
            return this.dataUserForAnime.rating !== 0;
        },
        isFavoriteUser() {
            return this.dataUserForAnime.favorite.folder_id !== 0;
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
                episode => episode.id === this.dataUserForAnime.favorite.episode_id
            );
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

                    <div class="flex items-center text-white select-none space-x-4">
                        <div class="flex shrink-0 font-bold">
                            {{ dataAnime.types.title_ru }}
                        </div>

                        <div class=" text-lg font-bold text-red-500">
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

        <div class="w-90% mx-auto mt-4 flex flex-row justify-center">
            <div class="aspect-[16/9] max-h-[100vh] w-full max-w-[70vw] overflow-hidden rounded-lg">
                <iframe
                    class="h-full w-full"
                    src="https://www.youtube.com/embed/XxI85Kd2YHs"
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
                        class="flex h-full w-full items-center justify-center text-2xl text-red-400"
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
                            <div class="flex flex-row justify-between">
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
                        class="flex h-full w-full items-center justify-center text-2xl text-red-400"
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
