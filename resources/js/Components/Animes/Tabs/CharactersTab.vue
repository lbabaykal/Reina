<script>
import CardCharacter from '../../Cards/CardCharacter.vue';
import { push } from 'notivue';
import TabLoading from '../../Tabs/TabLoading.vue';
import TabNotData from '../../Tabs/TabNotData.vue';

export default {
    name: 'CharactersTab',
    components: { TabNotData, TabLoading, CardCharacter },
    props: {
        slug: String,
    },
    data() {
        return {
            /**
             * @type {{
             *   mains: Array,
             *   secondaries: Array,
             *   episodics: Array,
             * }}
             */
            dataCharacters: {},
            dataLoading: false,
        };
    },
    methods: {
        getCharactersData() {
            this.dataLoading = false;
            axios
                .get(`/api/animes/${this.slug}/characters`)
                .then((response) => {
                    this.dataCharacters = response.data.data;
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
        this.getCharactersData();
    },
};
</script>

<template>
    <div
        v-if="dataLoading && issetArrayOrObject(dataCharacters)"
        class=""
    >
        <div v-if="dataCharacters.mains" class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Главные герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in dataCharacters.mains"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>

        <div v-if="dataCharacters.secondaries" class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Второстепенные герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in dataCharacters.secondaries"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>

        <div v-if="dataCharacters.episodics" class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Эпизодические герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in dataCharacters.episodics"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>
    </div>

    <TabNotData
        v-else-if="dataLoading && !issetArrayOrObject(dataCharacters)"
        title="Персонажи не заполнены"
    />

    <TabLoading
        v-else
        classes="fill-red-500"
    />
</template>
