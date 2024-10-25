import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: true,  // Listen on all network interfaces
        hmr: {
            host: '192.168.29.139',  // Set to your desired host
        },
    },
});
