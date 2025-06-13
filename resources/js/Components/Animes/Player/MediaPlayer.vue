<script>
import CheckSvg from '../../Svg/CheckSvg.vue';
import BackSvg from '../../Svg/BackSvg.vue';
import FavoriteSvg from '../../Svg/FavoriteSvg.vue';
import MicrophoneSvg from '../../Svg/MicrophoneSvg.vue';
import Episodes from './Episodes.vue';
import Player from './Player.vue';
import Teams from './Teams.vue';
import { useMediaPlayerStore } from '../../../Stores/MediaPlayerStore.js';
import LoadingSvg from '../../Svg/LoadingSvg.vue';

export default {
    name: 'MediaPlayer',
    components: { LoadingSvg, Teams, Player, Episodes, MicrophoneSvg, FavoriteSvg, BackSvg, CheckSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            mediaPlayerStore: useMediaPlayerStore,
            loadingMediaPlayer: true,
        };
    },
    methods: {},
    mounted() {
        this.mediaPlayerStore.getAnimeEpisodesData(this.slug);
    },
    watch: {
        'mediaPlayerStore.selectedEpisode'(newVal, oldVal) {
            const episode = this.mediaPlayerStore.dataEpisodes.find((episode) => episode.id === newVal);

            if (episode && Array.isArray(episode.teams) && episode.teams.length > 0) {
                this.mediaPlayerStore.dataTeams = episode.teams;
            }
        },
    },
};
</script>

<template>
    <div class="w-80% mx-auto mt-4 flex flex-row justify-center">
        <Player />

        <div
            class="bg-white dark:bg-black relative ml-4 aspect-9/1 w-90 shrink-0 overflow-hidden rounded-lg text-black select-none dark:text-white"
        >
            <div class="flex h-full w-full flex-col">
                <div class="flex flex-row items-center justify-evenly">
                    <div
                        @click="this.mediaPlayerStore.toggleTeamsMenu"
                        class="px-3 py-2 text-xl font-semibold"
                    >
                        Эпизоды
                    </div>
                    <div
                        @click="this.mediaPlayerStore.toggleTeamsMenu"
                        class="px-3 py-2 text-xl font-semibold"
                    >
                        Команды
                    </div>
                </div>
                <Episodes />
                <Teams />
            </div>
        </div>
    </div>
</template>
