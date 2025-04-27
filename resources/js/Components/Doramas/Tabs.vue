<script>
import InformationTab from './Tabs/InformationTab.vue';
import DescriptionTab from './Tabs/DescriptionTab.vue';
import CharactersTab from './Tabs/CharactersTab.vue';
import RelatedTab from './Tabs/RelatedTab.vue';
import CreatorsTab from './Tabs/CreatorsTab.vue';

export default {
    name: 'Tabs',
    components: { CreatorsTab, RelatedTab, CharactersTab, DescriptionTab, InformationTab },
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
            franchise: {
                id: Number,
                slug: String,
                title_ru: String,
                title_en: String,
            },
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
    methods: {
    },
    computed: {
        filteredTabs() {
            return this.dataTabs.tabs.filter((tab) => {
                if (tab.id === 3) {
                    return false;
                }

                if (tab.id === 4 && !this.dataDorama.franchise) {
                    return false;
                }

                if (tab.id === 5) {
                    return false;
                }

                return true;
            });
        },
    },
};
</script>

<template>
    <div
        class="w-90% m-auto my-3 rounded-lg bg-white dark:bg-black"
    >
        <ul class="flex justify-center text-center text-xl font-bold">
            <li
                v-for="tab in filteredTabs"
                :key="tab.id"
                class="mr-2"
            >
                <button
                    type="button"
                    @click="dataTabs.activeTab = tab.id"
                    class="inline-block cursor-pointer border-b-2 px-4 py-2.5 tracking-wide"
                    :class="{
                        'border-red-400 text-red-400 hover:border-red-500 hover:text-red-500': dataTabs.activeTab === tab.id,
                        'border-gray-400 text-gray-400 hover:border-black hover:text-black dark:hover:border-white dark:hover:text-white':
                            dataTabs.activeTab !== tab.id,
                    }"
                >
                    {{ tab.title }}
                </button>
            </li>
        </ul>

        <div class="min-h-80 px-5 py-3">
            <InformationTab
                v-show="dataTabs.activeTab === 1"
                :dataDorama="dataDorama"
                :isEpisodes="isEpisodes"
            />

            <DescriptionTab
                v-show="dataTabs.activeTab === 2"
                :description="dataDorama.description"
            />

            <CharactersTab v-if="dataTabs.activeTab === 3" />

            <keep-alive>
                <RelatedTab
                    v-if="dataTabs.activeTab === 4"
                    :slug="dataDorama.slug"
                />
            </keep-alive>

            <CreatorsTab v-if="dataTabs.activeTab === 5" />
        </div>
    </div>
</template>
