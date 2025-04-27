<script>
import StarSvg from '../../Components/Svg/StarSvg.vue';
import Rating from '../../Components/Doramas/Modals/Rating.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import FavoriteSvg from '../../Components/Svg/FavoriteSvg.vue';
import Favorite from '../../Components/Doramas/Modals/Favorite.vue';
import EpisodesButton from '../../Components/ui/Buttons/EpisodesButton.vue';
import CheckSvg from '../../Components/Svg/CheckSvg.vue';
import { push } from 'notivue';
import BackSvg from '../../Components/Svg/BackSvg.vue';
import MicrophoneSvg from '../../Components/Svg/MicrophoneSvg.vue';
import MediaPlayer from '../../Components/Doramas/Player/MediaPlayer.vue';

export default {
    name: 'WatchPage',
    components: { MediaPlayer, MicrophoneSvg, BackSvg, CheckSvg, EpisodesButton, Favorite, FavoriteSvg, LoadingSvg, Rating, StarSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            /**
             * @var array{
             *     id: int,
             *     slug: string,
             *     title_org: string,
             *     title_ru: string,
             *     title_en: string,
             *     type: array{
             *         id: int,
             *         slug: string,
             *         title_ru: string,
             *         title_en: string
             *     },
             *     genres: array{
             *         id: int,
             *         slug: string,
             *         title_ru: string,
             *         title_en: string
             *     },
             *     age_rating: string,
             *     episodes_released: int,
             *     episodes_total: int,
             *     rating: float,
             *     count_assessments: int,
             *     is_comment: bool,
             *     is_rating: bool
             *     franchise: array{
             *         id: int,
             *         slug: string,
             *         title_ru: string,
             *         title_en: string
             *     },
             * }
             */
            dataDorama: [],
            dataLoading: false,
            mediaMenu: true,
            selectedEpisode: null,
        };
    },
    methods: {
        async getDoramaData() {
            this.dataLoading = false;
            await axios
                .get(`/api/doramas/${this.slug}/watch`)
                .then((response) => {
                    this.dataDorama = response.data.data;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
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
            <div class="w-80% flex shrink-0 items-center justify-between px-5">
                <div class="flex flex-col">
                    <div class="max-w-100% truncate">
                        <router-link
                            :to="{ name: 'doramas.show', params: { slug: this.slug } }"
                            class="text-2xl transition-all duration-300 hover:text-violet-500"
                        >
                            {{ dataDorama.title_ru }}
                        </router-link>
                    </div>

                    <div class="flex items-center space-x-4 text-white select-none">
                        <div class="flex shrink-0 font-bold">
                            {{ dataDorama.type.title_ru }}
                        </div>

                        <div class="text-lg font-bold text-red-500">
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
                    <Rating :slug="dataDorama.slug" />
                    <Favorite :slug="dataDorama.slug" />
                </div>
            </div>
        </div>

        <MediaPlayer :slug="dataDorama.slug" />

        <div class="mt-5">КОММЕНТАРИИ</div>
    </section>
    <section
        v-else
        class="flex h-screen items-center justify-center"
    >
        <LoadingSvg classes="w-20 fill-violet-500" />
    </section>
</template>
