require('./bootstrap');
require('alpinejs');
require('bootstrap');

import { createApp } from 'vue';
import router from './router';
import 'bootstrap/dist/js/bootstrap.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';

import EventsIndex from './components/events/EventsIndex.vue';

createApp({
    components: {
        EventsIndex
    }
}).use(router).mount('#app')
