import { createApp } from 'vue';
import '@/Assets/Scss/style.css';
import App from './App.vue';
import router from '@/Router';

const app = createApp(App);
app.use(router);
app.mount('#app');
