import axios from 'axios';
import router from "@/router.js";
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

// Перехватчик запроса
axios.interceptors.request.use((config) => {
    return config
}, (error) => {
    return Promise.reject(error)
})

// Перехватчик ответа
axios.interceptors.response.use((response) => {
    return response
}, (error) => {
    if (error.response.status === 401 || error.response.status === 419) {
        window.location.href = 'https://www.auth.reina.online/login';
    }

    return Promise.reject(error)
})
