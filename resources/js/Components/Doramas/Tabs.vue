<script>
import InformationTab from './Tabs/InformationTab.vue';
import DescriptionTab from './Tabs/DescriptionTab.vue';
import CharactersTab from './Tabs/CharactersTab.vue';
import RelatedTab from './Tabs/RelatedTab.vue';
import CreatorsTab from './Tabs/CreatorsTab.vue';
import { push } from 'notivue';

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
            dataPersons: {
                id: Number,
                slug: String,
                full_name_org: String,
                full_name_ru: String,
                full_name_en: String,
                photo: String,
                role: String,
            },
            dataPersonsLoading: false,
        };
    },
    methods: {
        getPersonsData() {
            this.dataPersonsLoading = false;
            axios
                .get(`/api/doramas/${this.dataDorama.slug}/persons`)
                .then((response) => {
                    this.dataPersons = response.data.data;

                    this.dataPersonsLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        issetArray(array) {
            return Array.isArray(array) && array.length > 0;
        },
    },
    computed: {
        filteredTabs() {
            return this.dataTabs.tabs.filter((tab) => {
                if (tab.id === 3 && !this.issetArray(this.dataPersons)) {
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
    mounted() {
        this.getPersonsData();
    },
};
</script>

<template>
    <div class="w-90% m-auto my-3 rounded-lg bg-white select-none dark:bg-black">
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
                        'border-red-500 text-red-500': dataTabs.activeTab === tab.id,
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

            <CharactersTab
                v-if="dataTabs.activeTab === 3"
                :dataPersons="dataPersons"
            />

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
