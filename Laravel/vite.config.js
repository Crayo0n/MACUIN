import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/macuin.css', 'resources/css/login.css'],
            refresh: true,
        }),
    ],
});