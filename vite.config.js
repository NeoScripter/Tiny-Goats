import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/ts/app.ts'],
            refresh: true,
        }),
    ],
    server: {
        proxy: {
            '/images': 'http://goats.test/',
        },
    },
});
