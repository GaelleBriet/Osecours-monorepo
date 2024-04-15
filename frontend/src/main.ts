import '@/Assets/Icons/css/icons-osecours.css';
import '@formkit/themes/genesis';
import '@formkit/pro/genesis';
import '@/Assets/Css/style.css';
import 'floating-vue/dist/style.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { plugin } from '@formkit/vue';
import FloatingVue from 'floating-vue';
import i18n from '@/Services/Translations/index.ts';
import router from '@/Router';
import formkitConfig from '../formkit.config.js';
import App from './App.vue';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(i18n);
app.use(FloatingVue);
app.use(plugin, formkitConfig);

app.mount('#app');
