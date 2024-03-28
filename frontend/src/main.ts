import '@formkit/themes/genesis';
import '@formkit/pro/genesis';
import '@/Assets/Css/style.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { plugin } from '@formkit/vue';

import i18n from '@/Services/Translations/index.ts';
import router from '@/Router';
import formkitConfig from '../formkit.config.js';
import App from './App.vue';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(i18n);
app.use(plugin, formkitConfig);

app.mount('#app');
