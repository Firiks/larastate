import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import { ZiggyVue } from 'ziggy'

// create inertia app
createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue') // import all pages
        const page = await pages[`./Pages/${name}.vue`]() // get the page, must use await
        page.default.layout = page.default.layout || MainLayout // set the layout

        return page // return the page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue) // use ziggy for routing
            .mount(el)
    },
})
