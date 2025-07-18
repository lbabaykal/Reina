<script>
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import Rating from '../../Components/Doramas/Modals/Rating.vue';
import Favorite from '../../Components/Doramas/Modals/Favorite.vue';
import WatchOnlineButton from '../../Components/ui/Buttons/WatchOnlineButton.vue';
import { push } from 'notivue';
import Tabs from '../../Components/Doramas/Tabs.vue';
import CoverImage from '../../Components/Image/CoverImage.vue';

export default {
    name: 'ShowPage',
    components: { CoverImage, Tabs, WatchOnlineButton, Rating, Favorite, LoadingSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            dataDorama: {
                id: Number,
                slug: String,
                poster: String,
                cover: String,
                title_org: String,
                title_ru: String,
                title_en: String,
                type: {
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
                franchise: {
                    id: Number,
                    slug: String,
                    title_ru: String,
                    title_en: String,
                },
            },
            dataLoading: false,
        };
    },
    methods: {
        getDoramaData() {
            this.dataLoading = false;
            axios
                .get(`/api/doramas/${this.slug}`)
                .then((response) => {
                    this.dataDorama = response.data.data;
                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
    },
    computed: {
        isEpisodes() {
            return this.dataDorama.episodes_total !== 1;
        },
    },
    mounted() {
        this.getDoramaData();
    },
    watch: {
        slug() {
            this.getDoramaData();
        },
    },
};
</script>

<template>
    <section v-if="dataLoading">
        <div class="relative flex aspect-16/7 w-full flex-row select-none">
            <div
                class="absolute bottom-24 left-24 z-20 flex max-w-200 min-w-120 flex-col items-center justify-end justify-items-stretch rounded-md bg-black/60 px-5 py-2.5 backdrop-blur-sm"
            >
                <div class="my-1 w-full text-center text-2xl font-bold text-white">
                    {{ dataDorama.title_ru }}
                </div>

                <div class="my-1 flex w-full flex-row items-center justify-center divide-x divide-violet-500 text-lg text-gray-300">
                    <span class="px-3 py-0.5 text-2xl font-bold text-lime-400">{{ dataDorama.rating }}</span>

                    <span
                        v-if="isEpisodes"
                        class="px-3"
                    >
                        {{ dataDorama.episodes_released }} / {{ dataDorama.episodes_total }}
                    </span>
                    <span class="px-3">
                        {{ dataDorama.duration }}
                    </span>

                    <router-link
                        :to="{ name: 'doramas.index', query: { year_from: dataDorama.year, year_to: dataDorama.year } }"
                        class="px-3 tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                    >
                        {{ dataDorama.year }}
                    </router-link>

                    <span class="px-3 text-xl font-bold text-red-500">
                        {{ dataDorama.age_rating }}
                    </span>
                </div>

                <div class="my-1.5 flex w-full flex-row content-center items-center justify-center divide-x divide-violet-500 text-gray-300">
                    <div v-for="(dataDoramaGenre) in dataDorama.genres">
                        <router-link
                            :to="{ name: 'animes.index', query: { genres: dataDoramaGenre.slug } }"
                            class="mx-2 tracking-wide text-nowrap underline decoration-1 underline-offset-4 hover:text-violet-500 hover:decoration-violet-500"
                        >
                            {{ dataDoramaGenre.title_ru }}
                        </router-link>
                    </div>
                </div>

                <div class="my-3 flex w-full flex-row content-center items-center justify-center space-x-3">
                    <router-link :to="{ name: 'doramas.watch', params: { slug: dataDorama.slug } }">
                        <WatchOnlineButton />
                    </router-link>

                    <Rating :slug="dataDorama.slug" />
                    <Favorite :slug="dataDorama.slug" />
                </div>
            </div>

            <CoverImage :cover="dataDorama.cover" />
        </div>

        <Tabs
            :dataDorama="this.dataDorama"
            :isEpisodes="isEpisodes"
        />
    </section>

    <section
        v-else
        class="flex h-screen items-center justify-center"
    >
        <LoadingSvg classes="w-20 fill-violet-500" />
    </section>
</template>
