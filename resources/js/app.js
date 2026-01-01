import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    id: 'app',
    resolve: name => {
        const pages = import.meta.glob('./Page/**/*.vue', { eager: true })
        return pages[`./Page/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})