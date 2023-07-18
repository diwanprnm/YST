import { createApp } from 'vue';
import router from './router/index.js';
import store from './store/index.js';
import App from './App.vue';
import axios from "../js/plugins/axios.js";
import { createPinia } from 'pinia';

import './bootstrap';
import '../sass/app.scss';
import 'bootstrap/dist/css/bootstrap.css';
import 'jquery/dist/jquery.min';
import 'popper.js/dist/popper.min';
import '../../node_modules/overlayscrollbars/styles/overlayscrollbars.min.css';
import '../../node_modules/adminlte/dist/css/adminlte.min.css';





const app = createApp(App)
const pinia = createPinia();

app.use(router)
app.use(pinia)
app.use(store)
app.provide('axios', axios)
app.mount('#app')