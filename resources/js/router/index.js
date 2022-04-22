import { createRouter, createWebHistory } from 'vue-router'

import EventsIndex from '../components/events/EventsIndex.vue'

const routes = [
    {
        path: '/',
        name: 'events.index',
        component: EventsIndex
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
