import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        https: {
            cert: '/etc/ssl/certs/reina.online/Certificate.crt',
            key: '/etc/ssl/private/reina.online/PrivateKey.key',
        },
        hmr: {
            host: 'reina.online',
            port: 5173,
        },
        cors: true // Разрешает CORS
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
});
