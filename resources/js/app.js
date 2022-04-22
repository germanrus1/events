require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import router from './router'

import EventsIndex from './components/events/EventsIndex.vue';

createApp({
    components: {
        EventsIndex
    }
}).use(router).mount('#app')
