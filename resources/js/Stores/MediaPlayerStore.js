import { reactive } from 'vue';
import { push } from 'notivue';

export const useMediaPlayerStore = reactive({
    slug: String,
    dataMediaPlayerLoading: false,
    /**
     * @var array<int, array{
     *     id: int,
     *     name_org: string,
     *     name_ru: string,
     *     name_en: string,
     *     release_date: string,
     *     teams: array{
     *         id: int,
     *         title_ru: string,
     *         slug: string,
     *         link: string
     *     }
     * }>
     */
    dataEpisodes: [],
    /**
     * @var array<int, array{
     *     id: int,
     *     name_ru: string,
     *     slug: string,
     *     link: string
     * }>
     */
    dataTeams: [],
    selectedEpisode: null,
    selectedTeam: null,
    teamMenu: false,

    async getAnimeEpisodesData(slug) {
        this.slug = slug;
        this.dataMediaPlayerLoading = false;
        await axios
            .get(`/api/animes/${this.slug}/episodes`)
            .then((response) => {
                this.dataEpisodes = response.data.data;
                this.dataMediaPlayerLoading = true;

                if (this.selectedEpisode === null && this.dataEpisodes.length > 0) {
                    this.selectedEpisode = this.dataEpisodes[0].id;
                    this.dataTeams = this.dataEpisodes[0].teams;
                    this.selectedTeam = this.dataTeams[0].id;
                }
            })
            .catch((error) => {
                push.error(error.response.data);
            });
    },

    async getDoramaEpisodesData(slug) {
        this.slug = slug;
        this.dataMediaPlayerLoading = false;
        await axios
            .get(`/api/doramas/${this.slug}/episodes`)
            .then((response) => {
                this.dataEpisodes = response.data.data;
                this.dataMediaPlayerLoading = true;

                if (this.selectedEpisode === null && this.dataEpisodes.length > 0) {
                    this.selectedEpisode = this.dataEpisodes[0].id;
                    this.dataTeams = this.dataEpisodes[0].teams;
                    this.selectedTeam = this.dataTeams[0].id;
                }
            })
            .catch((error) => {
                push.error(error.response.data);
            });
    },
    selectEpisode(episodeId) {
        this.selectedEpisode = episodeId;
        const episode = this.dataEpisodes.find((ep) => ep.id === episodeId);
        if (episode) {
            this.dataTeams = episode.teams;
        }
    },
    selectTeam(teamId) {
        this.selectedTeam = teamId;
    },
    toggleTeamsMenu() {
        this.teamMenu = !this.teamMenu;
    },
});
