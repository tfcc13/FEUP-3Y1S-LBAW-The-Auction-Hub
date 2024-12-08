import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.postcss',
                'resources/js/app.js',
                'resources/js/auction.js',
            ],
            refresh: true,
        }),
    ],
});
