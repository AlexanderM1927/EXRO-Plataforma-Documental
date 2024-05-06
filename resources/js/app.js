import './bootstrap';
import "../css/app.css";
import 'bootstrap';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import VueSweetalert2 from 'vue-sweetalert2';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

createInertiaApp({
  title: (title) => `${title}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
        .use(plugin)
        .use(VueSweetalert2)
        .use(LaravelPermissionToVueJS)
        .mount(el);
  },
});
