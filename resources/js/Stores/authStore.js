import {defineStore} from "pinia";
import axios from "axios";
import router from "../router.js";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authAuthenticated: false
    }),
    actions: {
        storeUser(user) {
            this.authUser = user;
            this.authAuthenticated = true;
        },
        destroyUser() {
            this.authUser = null;
            this.authAuthenticated = false;
        },
        logout() {
            axios.post('/api/logout');
            this.destroyUser();
            router.push({name: 'main'});
        },
    },
    getters: {
        isAuthenticated(state) {
            return state.authAuthenticated
        },
        user(state) {
            return state.authUser;
        },
    },
    mutations: {

    },
    persist: true,
})
