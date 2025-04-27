<script>
export default {
    name: 'InformationTab',
    props: {
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
                    {{ dataDorama.title_org }}
                </dd>
            </div>
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Английское название</dt>
                <dd>
                    {{ dataDorama.title_en }}
                </dd>
            </div>
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Страна</dt>
                <dd>
                    <span
                        v-if="dataDorama.countries.length > 0"
                        v-for="(dataDoramaCountries, index) in dataDorama.countries"
                    >
                        <router-link
                            :to="{ name: 'doramas.index', query: { countries: dataDoramaCountries.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataDoramaCountries.title_ru }}
                        </router-link>
                        <span
                            v-if="index !== dataDorama.countries.length - 1"
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
                <dd>{{ dataDorama.release }} г.</dd>
            </div>
        </dl>

        <dl class="w-6/12 text-lg text-black dark:text-white">
            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Тип</dt>
                <dd>
                    <router-link
                        :to="{ name: 'doramas.index', query: { types: dataDorama.type.slug } }"
                        class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                    >
                        {{ dataDorama.type.title_ru }}
                    </router-link>
                </dd>
            </div>

            <div class="flex flex-col py-2">
                <dt class="text-xl text-gray-400">Жанр</dt>
                <dd>
                    <span
                        v-if="dataDorama.genres.length > 0"
                        v-for="(dataDoramaGenre, index) in dataDorama.genres"
                    >
                        <router-link
                            :to="{ name: 'doramas.index', query: { genres: dataDoramaGenre.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataDoramaGenre.title_ru }}
                        </router-link>
                        <span
                            v-if="index !== dataDorama.genres.length - 1"
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
                        v-if="dataDorama.studios.length > 0"
                        v-for="(dataDoramaStudio, index) in dataDorama.studios"
                    >
                        <router-link
                            :to="{ name: 'doramas.index', query: { studios: dataDoramaStudio.slug } }"
                            class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                        >
                            {{ dataDoramaStudio.title }}
                        </router-link>
                        <span
                            v-if="index !== dataDorama.studios.length - 1"
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
                    <span v-if="isEpisodes"> {{ dataDorama.episodes_released }} / {{ dataDorama.episodes_total }}, </span>
                    ~ {{ dataDorama.duration }}
                </dd>
            </div>
        </dl>
    </div>
</template>
