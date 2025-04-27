<script>
import { push } from 'notivue';
import CardRelation from '../../CardRelation.vue';
import CardRelationLoading from '../../CardRelationLoading.vue';

export default {
    name: 'RelatedTab',
    components: { CardRelation, CardRelationLoading },
    props: {
        slug: String,
    },
    data() {
        return {
            dataRelations: {
                id: Number,
                slug: String,
                poster: String,
                type: {
                    id: Number,
                    slug: String,
                    title_ru: String,
                    title_en: String,
                },
                title_ru: String,
                release: String,
                rating: Number,
                relation_type: String,
            },
            dataLoading: false,
        };
    },
    methods: {
        getRelationsData() {
            this.dataLoading = false;
            axios
                .get(`/api/animes/${this.slug}/relations`)
                .then((response) => {
                    this.dataRelations = response.data.data;

                    this.dataLoading = true;
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
    },
    mounted() {
        this.getRelationsData();
    },
};
</script>

<template>
    <div class="text-black dark:text-white grid w-full grid-flow-row grid-cols-5 place-items-center gap-3">
        <CardRelation
            v-if="dataLoading"
            v-for="dataRelation in dataRelations"
            :id="dataRelation.id"
            :slug="dataRelation.slug"
            :type="dataRelation.type"
            :poster="dataRelation.poster"
            :title_ru="dataRelation.title_ru"
            :release="dataRelation.release"
            :rating="dataRelation.rating"
            :relation_type="dataRelation.relation_type"
        />

        <CardRelationLoading
            v-if="!dataLoading"
            v-for="n in 10"
            :key="n"
        />
    </div>
</template>
