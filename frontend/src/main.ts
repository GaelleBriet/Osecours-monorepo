import '@/Assets/Css/style.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import i18n from '@/Services/Translations/index.ts';
import PrimeVue from 'primevue/config';
import App from './App.vue';
import router from '@/Router';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(i18n);
app.use(PrimeVue, {
	unstyled: true,
});

app.mount('#app');
