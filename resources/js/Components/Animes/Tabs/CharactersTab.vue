<script>
import CardCharacter from '../CardCharacter.vue';

export default {
    name: 'CharactersTab',
    components: { CardCharacter },
    props: {
        dataCharacters: Array,
    },
    data() {
        return {};
    },
    methods: {},
    computed: {
        mainCharacters() {
            return this.dataCharacters.filter((character) => character.role === 'MAIN');
        },
        secondaryCharacters() {
            return this.dataCharacters.filter((character) => character.role === 'SECONDARY');
        },
        episodicCharacters() {
            return this.dataCharacters.filter((character) => character.role === 'EPISODIC');
        },
    },
};
</script>

<template>
    <div class="">
        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Главные герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in mainCharacters"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Второстепенные герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in secondaryCharacters"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-red-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Эпизодические герои</span>
                <span class="text-2xl text-red-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardCharacter
                    v-for="dataCharacter in episodicCharacters"
                    :slug="dataCharacter.slug"
                    :photo="dataCharacter.photo"
                    :full_name_ru="dataCharacter.full_name_ru"
                />
            </div>
        </div>
    </div>
</template>
