import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/jquery.min.js' , 'resources/js/app.js', 'resources/css/dashlite.min.css', 'resources/js/bundle.js', 'resources/js/scripts.js', 'resources/js/custom.js', 'resources/js/datatable-btns.js'],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['jquery', 'datatables.net']
    },
});
