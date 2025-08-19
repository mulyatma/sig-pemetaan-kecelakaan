import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/css/style.css',
                'resources/css/components.css',
                'resources/js/stisla.js',
                'resources/js/scripts.js',
                'resources/js/custom.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
