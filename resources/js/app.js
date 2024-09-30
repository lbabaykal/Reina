import './bootstrap';
import '../css/app.css';



import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();



import { createApp } from 'vue';
import { createPinia } from 'pinia'
import App from './App.vue';
import router from './router.js';

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.mount('#app')

