// assets/app.js
import { createApp } from 'vue';
import App from './vue/controllers/App.vue';
import router from './vue/controllers/router';


import '../public/bootstrap/dist/css/bootstrap.css';

import 'bootstrap';


import '../assets/styles/app.css';

createApp(App).use(router).mount('#app');
