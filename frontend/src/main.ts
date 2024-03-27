import '@/Assets/Css/style.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import i18n from '@/Services/Translations/index.ts';
import App from './App.vue';
import router from '@/Router';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(i18n);

app.mount('#app');
