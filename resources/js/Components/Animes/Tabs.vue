<script>
import InformationTab from './Tabs/InformationTab.vue';
import DescriptionTab from './Tabs/DescriptionTab.vue';
import CharactersTab from './Tabs/CharactersTab.vue';
import RelatedTab from './Tabs/RelatedTab.vue';
import StaffTab from './Tabs/StaffTab.vue';

export default {
    name: 'Tabs',
    components: { StaffTab, RelatedTab, CharactersTab, DescriptionTab, InformationTab },
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
};
</script>

<template>
    <div class="w-80% m-auto my-3 rounded-lg bg-white select-none dark:bg-black">
        <ul class="box-border flex justify-center border-b border-gray-300 text-center text-lg font-semibold dark:border-gray-700">
            <li
                v-for="tab in dataTabs.tabs"
                :key="tab.id"
                class="mr-2"
            >
                <button
                    type="button"
                    @click="dataTabs.activeTab = tab.id"
                    class="inline-block cursor-pointer border-b-2 px-3 py-2 tracking-wide disabled:text-amber-400"
                    :class="{
                        'border-red-500 text-red-500': dataTabs.activeTab === tab.id,
                        'border-white text-black hover:border-black dark:border-black dark:text-white dark:hover:border-white': dataTabs.activeTab !== tab.id,
                    }"
                >
                    {{ tab.title }}
                </button>
            </li>
        </ul>

        <div class="min-h-80 px-5 py-3 flex flex-col">
            <InformationTab
                v-show="dataTabs.activeTab === 1"
                :dataAnime="dataAnime"
                :isEpisodes="isEpisodes"
            />

            <DescriptionTab
                v-show="dataTabs.activeTab === 2"
                :description="dataAnime.description"
            />

            <keep-alive>
                <CharactersTab
                    v-if="dataTabs.activeTab === 3"
                    :slug="dataAnime.slug"
                />
            </keep-alive>

            <keep-alive>
                <RelatedTab
                    v-if="dataTabs.activeTab === 4"
                    :slug="dataAnime.slug"
                />
            </keep-alive>

            <keep-alive>
                <StaffTab
                    v-if="dataTabs.activeTab === 5"
                    :slug="dataAnime.slug"
                />
            </keep-alive>
        </div>
    </div>
</template>
