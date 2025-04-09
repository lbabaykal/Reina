import { defineStore } from 'pinia';
import axios from 'axios';
import router from '../router.js';
import { push } from 'notivue';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        userState: null,
        isAuthenticatedState: false,
        isUserDataLoadedState: false,
    }),
    actions: {
        async getUser() {
            this.isUserDataLoadedState = false;
            await axios
                .get('/api/user-data')
                .then((response) => {
                    if (response.data.authenticated === true) {
                        const authData = {
                            id: response.data.user.id,
                            avatar: response.data.user.avatar,
                            name: response.data.user.name,
                        };

                        this.storeUser(authData);
                    } else {
                        this.destroyUser();
                    }
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.isUserDataLoadedState = true;
                });
        },
        storeUser(user) {
            this.userState = user;
            this.isAuthenticatedState = true;
        },
        destroyUser() {
            this.userState = null;
            this.isAuthenticatedState = false;
        },
        logout() {
            axios.post('/logout');
            this.destroyUser();
            router.push({ name: 'main' });
        },
    },
    getters: {
        isAuthenticated(state) {
            return state.isAuthenticatedState;
        },
        isUserDataLoaded(state) {
            return state.isUserDataLoadedState;
        },
        user(state) {
            return state.userState;
        },
    },
    persist: true,
});
