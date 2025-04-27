<script>
import { useMediaPlayerStore } from '../../../Stores/MediaPlayerStore.js';

export default {
    name: 'Player',
    data() {
        return {
            mediaPlayerStore: useMediaPlayerStore,
            link: null,
        };
    },
    computed: {
        iframeSrc() {
            return this.link ? `https://www.youtube.com/embed/${this.link}` : null;
        },
    },
    watch: {
        'mediaPlayerStore.dataTeams'(newTeams, oldTeams) {
            const existingTeam = newTeams.find(team => team.id === this.mediaPlayerStore.selectedTeam);

            if (existingTeam) {
                this.link = existingTeam.link;
            } else if (newTeams.length > 0) {
                const firstTeam = newTeams[0];
                this.mediaPlayerStore.selectedTeam = firstTeam.id;
                this.link = firstTeam.link;
            } else {
                this.link = null;
                this.mediaPlayerStore.selectedTeam = null;
            }
        },
        'mediaPlayerStore.selectedTeam'(newVal, oldVal) {
            const team = this.mediaPlayerStore.dataTeams.find((team) => team.id === newVal);
            this.link = team ? team.link : '';
        },
    }
};
</script>

<template>
    <div class="aspect-[16/9] max-h-[100vh] w-full max-w-[70vw] overflow-hidden rounded-lg bg-blue-950">
        <iframe
            v-if="link !== null"
            class="h-full w-full"
            :src="iframeSrc"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen
        ></iframe>

        <div v-else class="h-full w-full">
            Пусто
        </div>
    </div>
</template>
