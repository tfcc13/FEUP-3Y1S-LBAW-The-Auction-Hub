import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import postcss from './postcss.config.js';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.postcss',
                'resources/js/app.js',
                'resources/js/auction.js',
                'resources/js/components/bid_card.js',
                'resources/js/components/info_card.js',
                'resources/js/components/slider.js',
                'resources/js/components/carousel.js',
            ],
            refresh: true,
        }),
    ],
});
