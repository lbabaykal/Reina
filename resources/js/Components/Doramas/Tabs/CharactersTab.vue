<script>
import CardPerson from '../CardPerson.vue';

export default {
    name: 'CharactersTab',
    components: { CardPerson },
    props: {
        dataPersons: Array,
    },
    data() {
        return {};
    },
    methods: {},
    computed: {
        mainPersons() {
            return this.dataPersons.filter((person) => person.role === 'MAIN');
        },
        secondaryPersons() {
            return this.dataPersons.filter((person) => person.role === 'SECONDARY');
        },
        episodicPersons() {
            return this.dataPersons.filter((person) => person.role === 'EPISODIC');
        },
    },
};
</script>

<template>
    <div class="">
        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-violet-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Главные герои</span>
                <span class="text-2xl text-violet-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardPerson
                    v-for="dataPerson in mainPersons"
                    :slug="dataPerson.slug"
                    :photo="dataPerson.photo"
                    :full_name_ru="dataPerson.full_name_ru"
                />
            </div>
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-violet-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Второстепенные герои</span>
                <span class="text-2xl text-violet-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardPerson
                    v-for="dataPerson in secondaryPersons"
                    :slug="dataPerson.slug"
                    :photo="dataPerson.photo"
                    :full_name_ru="dataPerson.full_name_ru"
                />
            </div>
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center py-2 text-center text-xl font-semibold text-white">
                <span class="text-2xl text-violet-500">❮</span>
                <span class="px-3 text-xl text-black dark:text-white">Эпизодические герои</span>
                <span class="text-2xl text-violet-500">❯</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2.5">
                <CardPerson
                    v-for="dataPerson in episodicPersons"
                    :slug="dataPerson.slug"
                    :photo="dataPerson.photo"
                    :full_name_ru="dataPerson.full_name_ru"
                />
            </div>
        </div>
    </div>
</template>
