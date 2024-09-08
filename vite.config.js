import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/scss/main.scss', 'resources/js/cadastroScript.js', 'resources/js/loginScript.js', 'resources/js/dashboard.js'],
            refresh: true,
        }),
    ],
});
