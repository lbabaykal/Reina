<script>
import CheckSvg from '../../Svg/CheckSvg.vue';
import FavoriteSvg from '../../Svg/FavoriteSvg.vue';
import MicrophoneSvg from '../../Svg/MicrophoneSvg.vue';
import Teams from './Teams.vue';
import Empty from './Empty.vue';
import { useMediaPlayerStore } from '../../../Stores/MediaPlayerStore.js';
import { useFavoriteDoramaStore } from '../../../Stores/favoriteDoramaStore.js';

export default {
    name: 'Episodes',
    components: { Empty, Voices: Teams, MicrophoneSvg, FavoriteSvg, CheckSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            favoriteDoramaStore: useFavoriteDoramaStore,
            mediaPlayerStore: useMediaPlayerStore,
        };
    },
    methods: {
        rememberEpisode(episodeId) {
            this.favoriteDoramaStore.rememberEpisode(episodeId);
        },
        selectEpisode(episodeId) {
            this.mediaPlayerStore.selectEpisode(episodeId);
        },
        isSelectedEpisode(episodeId) {
            return this.mediaPlayerStore.selectedEpisode === episodeId;
        },
    },
    computed: {
        isFavoriteEpisode() {
            return (index) => index === this.favoriteEpisodeIndex;
        },
        isCheckedEpisode() {
            return (index) => index < this.favoriteEpisodeIndex;
        },
        isUncheckedEpisode() {
            return (index) => index > this.favoriteEpisodeIndex;
        },
        favoriteEpisodeIndex() {
            return this.mediaPlayerStore.dataEpisodes.findIndex((episode) => episode.id === this.favoriteDoramaStore.dataFavorite.episode_id);
        },
        isDataEpisodes() {
            return Array.isArray(this.mediaPlayerStore.dataEpisodes) && this.mediaPlayerStore.dataEpisodes.length > 0;
        },
    },
    mounted() {},
};
</script>

<template>
    <div v-if="!mediaPlayerStore.teamMenu">
        <ul
            v-if="isDataEpisodes"
            class="h-full space-y-2 overflow-y-scroll"
        >
            <li
                v-for="(dataEpisode, index) in this.mediaPlayerStore.dataEpisodes"
                class="dark:bg-blackSimple bg-whiteActive dark:hover:bg-whiteActive hover:bg-blackActive m-2.5 cursor-pointer rounded-md px-3 py-2 text-base hover:text-white dark:hover:text-black"
                :class="isSelectedEpisode(dataEpisode.id) ? '!bg-black !text-white dark:!bg-white dark:!text-black' : ''"
                @click="selectEpisode(dataEpisode.id)"
            >
                <div class="flex flex-row justify-between">
                    <div class="flex flex-row">
                        <FavoriteSvg
                            v-if="isFavoriteEpisode(index)"
                            classes="size-6 stroke-red-500 hover:fill-red-500 fill-red-500"
                            @click="rememberEpisode(dataEpisode.id)"
                        />
                        <CheckSvg
                            v-if="isCheckedEpisode(index)"
                            classes="size-6 stroke-lime-500 fill-lime-500 hover:stroke-rose-500 hover:fill-rose-500"
                            @click="rememberEpisode(dataEpisode.id)"
                        />
                        <FavoriteSvg
                            v-if="isUncheckedEpisode(index)"
                            classes="size-6 stroke-red-500 hover:fill-red-500 fill-transparent"
                            @click="rememberEpisode(dataEpisode.id)"
                        />
                    </div>
                    <div class="ml-2.5 w-full truncate">
                        {{ index + 1 + '. ' + dataEpisode.name_ru }}
                    </div>
                </div>
            </li>
        </ul>

        <Empty v-else />
    </div>
</template>
