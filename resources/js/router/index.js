import { createRouter, createWebHistory } from 'vue-router'

import EventsIndex from '../components/events/EventsIndex.vue'
import EventsCreate from '../components/events/EventsCreate.vue'

const routes = [
    {
        path: '/',
        name: 'events.index',
        component: EventsIndex
    },
    {
        path: '/events/create',
        name: 'events.create',
        component: EventsCreate
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
