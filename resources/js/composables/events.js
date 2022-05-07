import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useEvents() {
    const event = ref([])
    const events = ref([])
    const users = ref([])

    const errors = ref('')
    const router = useRouter()

    const getEvents = async (dateWeek = '') => {
        const response = await axios.get('/api/events?dateWeek=' + dateWeek)
        events.value = response.data.data
    }
    const getMembers = async (curEvent = '') => {
        const response = await axios.get('/api/events/users?event=' + curEvent)
        users.value = response.data.users
    }
    const getEvent = async (id) => {
        const response = await axios.get(`/api/events/${id}`)
        event.value = response.data.data
    }

    const storeEvent = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/events', data)
            await router.push({ name: 'events.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }

    }

    const updateEvent = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/events/${id}`, event.value)
            await router.push({ name: 'events.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const destroyEvent = async (id) => {
        await axios.delete(`/api/events/${id}`)
    }

    return {
        errors,
        event,
        events,
        users,
        getEvent,
        getEvents,
        getMembers,
        storeEvent,
        updateEvent,
        destroyEvent,
    }
}
