<script>
export default {
    name: "Description",
    props: {
        dataDorama: {
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
                    {id: 1, title: 'Информация'},
                    {id: 2, title: 'Описание'},
                    {id: 3, title: 'Связанное'},
                    {id: 4, title: 'Актеры и съемочная группа'},
                ],
                activeTab: 1,
            },
        }
    },
}
</script>

<template>
    <div class="w-10/12 m-auto">
        <ul class="flex flex-wrap font-bold text-xl text-center">
            <li v-for="tab in dataTabs.tabs" :key="tab.id" class="me-2">
                <button type="button"
                        @click="dataTabs.activeTab = tab.id"
                        class="inline-block p-4 border-b-2 tracking-wide"
                        :class="{
                            'text-violet-500 hover:text-violet-600 border-violet-500': dataTabs.activeTab === tab.id,
                            'text-gray-400 hover:text-white border-gray-400 hover:border-white': dataTabs.activeTab !== tab.id
                        }"
                >
                    {{ tab.title }}
                </button>
            </li>
        </ul>

        <div class="mt-2 p-4">
            <div v-show="dataTabs.activeTab === 1">
                <div class="flex flex-row">
                    <dl class="w-6/12 text-white text-lg">
                        <div class="flex flex-col py-2">
                            <dt class="text-gray-400 text-xl">Оригинальное название</dt>
                            <dd>
                                {{ dataDorama.title_org }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-2">
                            <dt class="text-gray-400 text-xl">Английское название</dt>
                            <dd>
                                {{ dataDorama.title_en }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-2">
                            <dt class="text-gray-400 text-xl">Страна</dt>
                            <dd>
                                <span v-for="(dataDoramaCountries, index) in dataDorama.countries">
                                    <router-link :to="{ name: 'doramas.index', query: { countries: dataDoramaCountries.slug } }"
                                                 class="underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                                    >
                                        {{ dataDoramaCountries.title_ru }}
                                    </router-link>
                                    <span v-if="index !== dataDorama.countries.length - 1"
                                          class="text-violet-500 text-xs"
                                    >
                                        &#9679;
                                    </span>
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col py-2">
                            <dt class="mb-1 text-gray-400 text-xl">Премьера</dt>
                            <dd>{{ dataDorama.release }} г.</dd>
                        </div>
                    </dl>

                    <dl class="w-6/12 text-white text-lg">
                        <div class="flex flex-col py-2">
                            <dt class="text-gray-400 text-xl">Тип</dt>
                            <dd>
                                <router-link :to="{ name: 'doramas.index', query: { types: dataDorama.types.slug } }"
                                             class="underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                                >
                                    {{ dataDorama.types.title_ru }}
                                </router-link>
                            </dd>
                        </div>

                        <div class="flex flex-col py-2" v-if="dataDorama.genres.length > 0">
                            <dt class="text-gray-400 text-xl">Жанр</dt>
                            <dd>
                                <span v-for="(dataDoramaGenre, index) in dataDorama.genres">
                                    <router-link :to="{ name: 'doramas.index', query: { genres: dataDoramaGenre.slug } }"
                                                 class="underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                                    >
                                        {{ dataDoramaGenre.title_ru }}
                                    </router-link>
                                    <span v-if="index !== dataDorama.genres.length - 1" class="mx-1.5 text-violet-500">|</span>
                                </span>
                            </dd>
                        </div>

                        <div class="flex flex-col py-2" v-if="dataDorama.studios.length > 0">
                            <dt class="text-gray-400 text-xl">Студия</dt>
                            <dd>
                                <span v-for="(dataDoramaStudio, index) in dataDorama.studios">
                                        <router-link
                                            :to="{ name: 'doramas.index', query: { studios: dataDoramaStudio.slug } }"
                                            class="underline decoration-1 underline-offset-4 hover:decoration-violet-500 hover:text-violet-500 tracking-wide"
                                        >
                                            {{ dataDoramaStudio.title }}
                                        </router-link>
                                    <span v-if="index !== dataDorama.studios.length - 1"
                                          class="text-violet-500 text-xs"
                                    >
                                        &#9679;
                                    </span>
                                </span>
                            </dd>
                        </div>

                        <div class="flex flex-col py-2">
                            <dt class="mb-1 text-gray-400 text-xl">Продолжительность</dt>
                            <dd>
                                <span v-if="dataDorama.episodes_total > 1">
                                    {{ dataDorama.episodes_released }} / {{ dataDorama.episodes_total }},
                                </span>
                                ~ {{ dataDorama.duration }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div v-show="dataTabs.activeTab === 2"
                 class="min-h-40"
            >
                <div class="text-justify text-lg indent-8">
                    {{ dataDorama.description }}
                </div>
            </div>
            <div v-show="dataTabs.activeTab === 3"
                 class="min-h-40"
            >
                Связанное
            </div>
            <div v-show="dataTabs.activeTab === 4"
                 class="min-h-40"
            >
                Актеры и съемочная группа
            </div>
        </div>
    </div>
</template>
