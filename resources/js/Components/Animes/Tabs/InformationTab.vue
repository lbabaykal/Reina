<script>
export default {
    name: 'InformationTab',
    props: {
        dataAnime: {
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
            description: String,
            rating: Number,
            count_assessments: Number,
            is_comment: Boolean,
            is_rating: Boolean,
        },
        isEpisodes: Boolean,
    },
};
</script>

<template>
    <div class="flex flex-row">
        <dl class="w-6/12 text-lg text-black dark:text-white">
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Оригинальное название</dt>
                <dd>
                    {{ dataAnime.title_org }}
                </dd>
            </div>
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Английское название</dt>
                <dd>
                    {{ dataAnime.title_en }}
                </dd>
            </div>
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Страна</dt>
                <dd>
                    <span
                        v-if="dataAnime.countries.length > 0"
                        v-for="(dataAnimeCountries, index) in dataAnime.countries"
                    >
                        <router-link
                            :to="{ name: 'animes.index', query: { countries: dataAnimeCountries.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataAnimeCountries.title_ru }}
                        </router-link>
                        <span
                            v-if="index !== dataAnime.countries.length - 1"
                            class="text-xs text-red-500"
                        >
                            &#9679;
                        </span>
                    </span>
                    <span v-else> — </span>
                </dd>
            </div>
            <div class="flex flex-col py-2">
                <dt class="mb-1 text-xl text-gray-400">Премьера</dt>
                <dd>{{ dataAnime.release }} г.</dd>
            </div>
        </dl>

        <dl class="w-6/12 text-lg text-black dark:text-white">
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Тип</dt>
                <dd>
                    <router-link
                        :to="{ name: 'animes.index', query: { types: dataAnime.type.slug } }"
                        class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                    >
                        {{ dataAnime.type.title_ru }}
                    </router-link>
                </dd>
            </div>

            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Жанр</dt>
                <dd>
                    <span
                        v-if="dataAnime.genres.length > 0"
                        v-for="(dataAnimeGenre, index) in dataAnime.genres"
                    >
                        <router-link
                            :to="{ name: 'animes.index', query: { genres: dataAnimeGenre.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataAnimeGenre.title_ru }}
                        </router-link>
                        <span
                            v-if="index !== dataAnime.genres.length - 1"
                            class="mx-1.5 text-red-500"
                            >|</span
                        >
                    </span>
                    <span v-else> — </span>
                </dd>
            </div>

            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Студия</dt>
                <dd>
                    <span
                        v-if="dataAnime.studios.length > 0"
                        v-for="(dataAnimeStudio, index) in dataAnime.studios"
                    >
                        <router-link
                            :to="{ name: 'animes.index', query: { studios: dataAnimeStudio.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataAnimeStudio.title }}
                        </router-link>
                        <span
                            v-if="index !== dataAnime.studios.length - 1"
                            class="text-xs text-red-500"
                        >
                            &#9679;
                        </span>
                    </span>
                    <span v-else> — </span>
                </dd>
            </div>

            <div class="flex flex-col py-2">
                <dt class="mb-1 text-xl text-gray-400">Продолжительность</dt>
                <dd>
                    <span v-if="isEpisodes"> {{ dataAnime.episodes_released }} / {{ dataAnime.episodes_total }}, </span>
                    ~ {{ dataAnime.duration }}
                </dd>
            </div>
        </dl>
    </div>
</template>
