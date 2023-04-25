import path from 'path';
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/images',
                    dest: '.././'
                },
                {
                    src: 'resources/favicon',
                    dest: '.././'
                },
                {
                    src: 'node_modules/cryptocurrency-icons/svg',
                    dest: '.././cryptocurrency-icons'
                }
            ]
        })
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }
});
