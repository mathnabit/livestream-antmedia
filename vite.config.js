import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// Import the Vue plugin
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        // Add the Vue plugin
        vue(), 
    ],
    // Add the resolve alias
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
});
