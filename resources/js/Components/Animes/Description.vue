<script>
export default {
    name: 'Description',
    props: {
        dataAnime: {
            id: Number,
            slug: String,
            poster: String,
            cover: String,
            title_org: String,
            title_ru: String,
            title_en: String,
            types: [Array, Object],
            genres: [Array, Object],
            studios: [Array, Object],
            countries: [Array, Object],
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
        isEpisodes: Boolean,
    },
    data() {
        return {
            dataTabs: {
                tabs: [
                    { id: 1, title: 'Информация' },
                    { id: 2, title: 'Описание' },
                    { id: 3, title: 'Персонажи' },
                    { id: 4, title: 'Связанное' },
                    { id: 5, title: 'Актеры и съемочная группа' },
                ],
                activeTab: 1,
            },
        };
    },
};
</script>

<template>
    <div class="m-auto w-10/12">
        <ul class="flex flex-wrap text-center text-xl font-bold">
            <li
                v-for="tab in dataTabs.tabs"
                :key="tab.id"
                class="mr-2"
            >
                <button
                    type="button"
                    @click="dataTabs.activeTab = tab.id"
                    class="inline-block cursor-pointer border-b-2 p-4 tracking-wide"
                    :class="{
                        'border-red-500 text-red-500 hover:text-red-600': dataTabs.activeTab === tab.id,
                        'border-gray-400 text-gray-400 hover:border-white hover:text-white': dataTabs.activeTab !== tab.id,
                    }"
                >
                    {{ tab.title }}
                </button>
            </li>
        </ul>

        <div class="mt-2 p-4">
            <div v-show="dataTabs.activeTab === 1">
                <div class="flex flex-row">
                    <dl class="w-6/12 text-lg text-white">
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

                    <dl class="w-6/12 text-lg text-white">
                        <div class="flex flex-col py-2">
                            <dt class="text-xl text-gray-400">Тип</dt>
                            <dd>
                                <router-link
                                    :to="{ name: 'animes.index', query: { types: dataAnime.types.slug } }"
                                    class="tracking-wide underline decoration-1 underline-offset-4 hover:text-red-500 hover:decoration-red-500"
                                >
                                    {{ dataAnime.types.title_ru }}
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
            </div>
            <div
                v-show="dataTabs.activeTab === 2"
                class="min-h-40"
            >
                <div class="text-justify indent-8 text-lg">
                    {{ dataAnime.description }}
                </div>
            </div>
            <div
                v-show="dataTabs.activeTab === 3"
                class="min-h-40"
            >
                Персонажи
            </div>
            <div
                v-show="dataTabs.activeTab === 4"
                class="min-h-40"
            >
                Связанное
            </div>
            <div
                v-show="dataTabs.activeTab === 5"
                class="min-h-40"
            >
                Актеры и съемочная группа
            </div>
        </div>
    </div>
</template>
