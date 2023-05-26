require('axios');
require('bootstrap');

import { createApp } from 'vue';
import app from './components/app.vue';

const vueApp = createApp(app);
vueApp.mount('#app');