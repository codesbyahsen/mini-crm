import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/dashlite.min.css', 'resources/js/jquery.js', 'resources/js/bundle.js', 'resources/js/scripts.js', 'resources/js/custom.js', 'resources/js/datatable-btns.js'],
            refresh: true,
        }),
    ],
});
