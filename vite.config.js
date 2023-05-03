import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({ // laravel plugin
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        vue({ // vue plugin
            template: {
                base: null,
                includeAbsolute: false,
            },
        }),
    ],

    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.es.js'), // use ziggy for routing
        },
    },
})
