import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        host: '0.0.0.0',
        // host: '2rxx6d-31-23-76-51.ru.tuna.am',
        port: 5173,
        // https: {
        //     cert: '/etc/ssl/certs/reina.online/Certificate.crt',
        //     key: '/etc/ssl/private/reina.online/PrivateKey.key',
        // },
        hmr: {
            host: 'reina.online',
            // host: '2rxx6d-31-23-76-51.ru.tuna.am',
            port: 5173,
        },
        cors: true
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
});
