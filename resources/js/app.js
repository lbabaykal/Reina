import './bootstrap';
import '../css/app.css';
import 'notivue/notification.css';
import 'notivue/animations.css';
import 'notivue/notification-progress.css'

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { createNotivue } from 'notivue';

import App from './App.vue';
import router from './router.js';

const app = createApp(App);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const notivue = createNotivue({
    position: 'bottom-center',
    limit: 6,
    notifications: {
        global: {
            duration: 4000,
        }
    }
});

app.use(pinia);
app.use(router);
app.use(notivue)
app.mount('#app');
