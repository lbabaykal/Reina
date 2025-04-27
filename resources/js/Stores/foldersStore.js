import { defineStore } from 'pinia';
import axios from 'axios';
import { push } from 'notivue';

export const useFoldersStore = defineStore('folders', {
    state: () => ({
        foldersState: null,
        animeFoldersState: null,
        doramaFoldersState: null,
    }),
    actions: {
        async getAnimeFolders() {
            await axios
                .get('/api/animes/folders')
                .then((response) => {
                    this.storeAnimeFolders(response.data.data);
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        async getDoramaFolders() {
            await axios
                .get('/api/doramas/folders')
                .then((response) => {
                    this.storeDoramaFolders(response.data.data);
                })
                .catch((error) => {
                    push.error(error.response.data);
                });
        },
        getFolders() {
            this.getAnimeFolders();
            this.getDoramaFolders();
        },
        storeAnimeFolders(data) {
            this.animeFoldersState = data;
        },
        storeDoramaFolders(data) {
            this.doramaFoldersState = data;
        },
        destroyFolders() {
            localStorage.removeItem('folders');
        },
    },
    getters: {
        animeFolders(state) {
            return state.animeFoldersState;
        },
        doramaFolders(state) {
            return state.doramaFoldersState;
        },
    },
    persist: true,
});
