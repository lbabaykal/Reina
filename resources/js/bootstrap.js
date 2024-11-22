import axios from 'axios';
import { useAuthStore } from "./Stores/authStore.js";
import router from './router.js'


window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

// Request
axios.interceptors.request.use((config) => {
    return config
}, (error) => {
    return Promise.reject(error)
})

// Response
axios.interceptors.response.use((response) => {
    return response
}, (error) => {
    if (error.response.status === 401 || error.response.status === 419) {
        useAuthStore().destroyUser();
        router.push({name: 'login'});
    }

    return Promise.reject(error)
})
