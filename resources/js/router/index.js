import { createRouter, createWebHistory } from 'vue-router'

import EventsIndex from '../components/events/EventsIndex.vue'
import EventsCreate from '../components/events/EventsCreate.vue'
import EventsEdit from '../components/events/EventsEdit.vue'

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
    {
        path: '/events/:id/edit',
        name: 'events.edit',
        component: EventsEdit,
        props: true
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
