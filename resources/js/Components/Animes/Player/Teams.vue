<script>
import BackSvg from '../../Svg/BackSvg.vue';
import Empty from './Empty.vue';
import { useMediaPlayerStore } from '../../../Stores/MediaPlayerStore.js';
import MicrophoneSvg from '../../Svg/MicrophoneSvg.vue';

export default {
    name: 'Teams',
    components: { MicrophoneSvg, Empty, BackSvg },
    data() {
        return {
            mediaPlayerStore: useMediaPlayerStore,
            episodeTypeMap: {
                VOICEOVER: 'Озвучка',
                DUBBING: 'Дубляж',
                SUBTITLES: 'Субтитры',
            },
        };
    },
    methods: {
        selectTeam(teamId) {
            this.mediaPlayerStore.selectTeam(teamId);
        },
        isSelectedTeam(teamId) {
            return this.mediaPlayerStore.selectedTeam === teamId;
        },
        nameAndTypeTeam(dataTeam) {
            return `${this.episodeTypeMap[dataTeam.type]} – ${dataTeam.name}`;
        },
    },
};
</script>

<template>
    <div v-if="mediaPlayerStore.teamMenu">
        <ul class="h-full space-y-2 overflow-y-scroll">
            <li
                v-for="dataTeam in this.mediaPlayerStore.dataTeams"
                class="dark:bg-blackSimple bg-whiteActive dark:hover:bg-whiteActive hover:bg-blackActive m-2.5 cursor-pointer rounded-md px-3 py-2 text-base hover:text-white dark:hover:text-black"
                :class="isSelectedTeam(dataTeam.id) ? '!bg-black !text-white dark:!bg-white dark:!text-black' : ''"
                @click="selectTeam(dataTeam.id)"
            >
                <div class="truncate">
                    {{ nameAndTypeTeam(dataTeam) }}
                </div>
            </li>
        </ul>
    </div>
</template>
