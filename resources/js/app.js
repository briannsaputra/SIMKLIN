import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import DefaultLayout from './Layouts/DefaultLayout.vue';

import Echo from 'laravel-echo';

// Pastikan Anda telah menginstal dan mengimpor Ziggy dengan benar
import { route } from 'ziggy-js'; 

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

// [Fix for nested dynamic import error]
// Menggunakan import.meta.glob() untuk memetakan semua file .vue di bawah Pages 
// secara rekursif. Ini mengatasi batasan impor dinamis dengan variabel jalur bersarang.
const pages = import.meta.glob('./Pages/**/*.vue');


createInertiaApp({
    // Ganti fungsi resolve untuk menggunakan objek 'pages' yang telah dipetakan
    resolve: (name) => {
        const path = `./Pages/${name}.vue`;
        const resolvePage = pages[path];

        if (!resolvePage) {
            // Log error jika halaman tidak ditemukan
            console.error(`Inertia Page not found for name: ${name} (Path: ${path})`);
            return Promise.reject(new Error(`Inertia Page not found: ${path}`));
        }

        // Panggil fungsi module yang dikembalikan oleh glob dan tangani layout
        return resolvePage().then(module => {
            const page = module.default;
            if (!page.layout) {
                page.layout = DefaultLayout;
            }
            return page;
        });
    },

    setup({ el, App, props, plugin }) {
        // Simpan instance aplikasi Vue yang dibuat ke dalam variabel vueApp
        const vueApp = createApp({ render: () => h(App, props) });

        // Gunakan plugin Inertia
        vueApp.use(plugin);

        // Tambahkan properti global $route (dari Ziggy) ke instance aplikasi
        // Ini memungkinkan Anda menggunakan route() di template Vue, misalnya <a :href="$route('home')">
        vueApp.config.globalProperties.$route = route;

        // Muat aplikasi Vue ke elemen DOM
        vueApp.mount(el);
    },
});


