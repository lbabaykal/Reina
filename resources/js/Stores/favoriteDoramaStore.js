import { reactive } from 'vue';
import { push } from 'notivue';

export const useFavoriteDoramaStore = reactive({
    slug: String,
    dataFavorite: {
        id: null,
        dorama_id: null,
        folder_id: null,
        episode_id: null,
    },
    dataFavoriteLoading: false,

    getDoramaFavorite(slug) {
        this.slug = slug;
        this.dataFavoriteLoading = true;
        axios
            .get(`/api/doramas/${slug}/favorite`)
            .then((response) => {
                if (response.data.data === null) {
                    this.dataFavorite = {
                        id: null,
                        dorama_id: null,
                        folder_id: null,
                        episode_id: null,
                    };
                } else {
                    this.dataFavorite = response.data.data;
                }
            })
            .catch((error) => {
                push.error(error.response.data);
            })
            .finally(() => {
                this.dataFavoriteLoading = false;
            });
    },

    rememberEpisode(episodeId) {
        this.dataFavoriteLoading = true;
        axios
            .post(`/api/doramas/favorite`, {
                slug: this.slug,
                episode_id: episodeId,
            })
            .then((response) => {
                this.dataFavorite = response.data.data;
            })
            .catch((error) => {
                push.error(error.response.data);
            })
            .finally(() => {
                this.dataFavoriteLoading = false;
            });
    },

    resetDataFavorite() {
        this.dataFavorite = {
            id: null,
            dorama_id: null,
            folder_id: null,
            episode_id: null,
        };
    },
});
