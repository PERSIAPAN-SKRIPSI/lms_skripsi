import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/frontend.css',
                'resources/js/frontend/frontend.js',
            ],
            refresh: [
                'resources/views/**',
                'routes/**',
                'app/Http/Controllers/**',
                'app/View/Components/**',
            ],
        }),
    ],
    server: {
        hmr: {
            overlay: false,
        },
        watch: {
            usePolling: false,
            interval: 100,
        },
    },
    optimizeDeps: {
        include: ['axios', 'lodash'],
    },
    build: {
        manifest: true,
        commonjsOptions: {
            transformMixedEsModules: true,
        },
        minify: process.env.NODE_ENV === 'production',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios', 'lodash'],
                },
            },
        },
    },
});
