<script>
import { push } from 'notivue';
import TabNotData from '../../Tabs/TabNotData.vue';
import TabLoading from '../../Tabs/TabLoading.vue';
import CardCharacterNotData from '../../Cards/CardCharacterNotData.vue';
import CardCharacter from '../../Cards/CardCharacter.vue';

export default {
    name: 'StaffTab',
    components: { CardCharacter, CardCharacterNotData, TabLoading, TabNotData },
    props: {
        slug: String,
    },
    data() {
        return {
            /**
             * @type {{
             *   actors: Array,
             *   directors: Array,
             *   producers: Array,
             *   writers: Array,
             *   operators: Array,
             *   composers: Array,
             *   editors: Array,
             * }}
             */
            dataStaff: {},
            dataLoading: false,
        };
    },
    methods: {
        getStaffData() {
            this.dataLoading = false;
            axios
                .get(`/api/doramas/${this.slug}/staff`)
                .then((response) => {
                    this.dataStaff = response.data.data;
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = true;
                });
        },
        issetArrayOrObject(value) {
            if (Array.isArray(value)) {
                return value.length > 0;
            } else if (value && typeof value === 'object') {
                return Object.keys(value).length > 0;
            }
            return false;
        },
    },
    mounted() {
        this.getStaffData();
    },
};
</script>

<template>
    <div
        v-if="dataLoading && issetArrayOrObject(dataStaff)"
        class=""
    >
        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Актеры</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-if="dataStaff.actors"
                    v-for="dataActor in dataStaff.actors"
                    :slug="dataActor.slug"
                    :photo="dataActor.photo"
                    :full_name_ru="dataActor.full_name_ru"
                />

                <CardCharacterNotData
                    v-else
                    title="Не добавлен"
                />
            </div>
        </div>

        <div class="flex flex-row">
            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Режиссер</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.directors"
                        v-for="dataDirectors in dataStaff.directors"
                        :slug="dataDirectors.slug"
                        :photo="dataDirectors.photo"
                        :full_name_ru="dataDirectors.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>

            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Продюсер</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.producers"
                        v-for="dataProducers in dataStaff.producers"
                        :slug="dataProducers.slug"
                        :photo="dataProducers.photo"
                        :full_name_ru="dataProducers.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>
        </div>

        <div class="flex flex-row">
            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Сценарист</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.writers"
                        v-for="dataWriters in dataStaff.writers"
                        :slug="dataWriters.slug"
                        :photo="dataWriters.photo"
                        :full_name_ru="dataWriters.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>

            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Оператор</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.operators"
                        v-for="dataOperators in dataStaff.operators"
                        :slug="dataOperators.slug"
                        :photo="dataOperators.photo"
                        :full_name_ru="dataOperators.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>
        </div>

        <div class="flex flex-row">
            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Композитор</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.composers"
                        v-for="dataComposers in dataStaff.composers"
                        :slug="dataComposers.slug"
                        :photo="dataComposers.photo"
                        :full_name_ru="dataComposers.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>

            <div class="flex flex-1/2 flex-col">
                <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                    <span class="text-2xl text-red-500">❮</span>
                    <span class="px-3 text-xl text-black dark:text-white">Монтажер</span>
                    <span class="text-2xl text-red-500">❯</span>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <CardCharacter
                        v-if="dataStaff.editors"
                        v-for="dataEditors in dataStaff.editors"
                        :slug="dataEditors.slug"
                        :photo="dataEditors.photo"
                        :full_name_ru="dataEditors.full_name_ru"
                    />

                    <CardCharacterNotData
                        v-else
                        title="Не добавлен"
                    />
                </div>
            </div>
        </div>
    </div>

    <TabNotData
        v-else-if="dataLoading && !issetArrayOrObject(dataStaff)"
        title="Актеры и съемочная группа не заполнены"
    />

    <TabLoading
        v-else
        classes="fill-red-500"
    />
</template>
