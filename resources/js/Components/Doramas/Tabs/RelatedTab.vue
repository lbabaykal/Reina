<script>
import { push } from 'notivue';
import CardRelation from '../../Cards/CardRelation.vue';
import CardRelationLoading from '../../Cards/CardRelationLoading.vue';
import TabNotData from '../../Tabs/TabNotData.vue';
import TabLoading from '../../Tabs/TabLoading.vue';

export default {
    name: 'RelatedTab',
    components: { TabLoading, TabNotData, CardRelation, CardRelationLoading },
    props: {
        slug: String,
    },
    data() {
        return {
            dataRelations: {},
            dataLoading: false,
        };
    },
    methods: {
        getRelationsData() {
            this.dataLoading = false;
            axios
                .get(`/api/doramas/${this.slug}/relations`)
                .then((response) => {
                    this.dataRelations = response.data.data;
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
        this.getRelationsData();
    },
};
</script>

<template>
    <div
        v-if="dataLoading && issetArrayOrObject(dataRelations)"
        class="flex w-full flex-wrap justify-center gap-5 text-black dark:text-white"
    >
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
    </div>

    <TabNotData
        v-else-if="dataLoading && !issetArrayOrObject(dataRelations)"
        title="Связанные франшизы не найдены"
    />

    <div
        v-else
        class="flex w-full flex-wrap justify-center gap-5 text-black dark:text-white"
    >
        <CardRelationLoading
            v-for="n in 8"
            :key="n"
        />
    </div>
</template>
