<script>
import InformationTab from './Tabs/InformationTab.vue';
import DescriptionTab from './Tabs/DescriptionTab.vue';
import RelatedTab from './Tabs/RelatedTab.vue';
import StaffTab from './Tabs/StaffTab.vue';

export default {
    name: 'Tabs',
    components: { StaffTab, RelatedTab, DescriptionTab, InformationTab },
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
                    { id: 3, title: 'Связанное' },
                    { id: 4, title: 'Актеры и съемочная группа' },
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

        <div class="flex min-h-80 flex-col px-5 py-3">
            <InformationTab
                v-show="dataTabs.activeTab === 1"
                :dataDorama="dataDorama"
                :isEpisodes="isEpisodes"
            />

            <DescriptionTab
                v-show="dataTabs.activeTab === 2"
                :description="dataDorama.description"
            />

            <keep-alive>
                <RelatedTab
                    v-if="dataTabs.activeTab === 3"
                    :slug="dataDorama.slug"
                />
            </keep-alive>

            <keep-alive>
                <StaffTab
                    v-if="dataTabs.activeTab === 4"
                    :slug="dataDorama.slug"
                />
            </keep-alive>
        </div>
    </div>
</template>
