<template>
    <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
        {{ errors }}
    </div>

    <form class="space-y-6" v-on:submit.prevent="saveEvent">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="event.name">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <div class="mt-1">
                    <input type="text" name="description" id="description"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="event.description">
                </div>
            </div>

            <div>
                <label for="event_start" class="block text-sm font-medium text-gray-700">Начало события</label>
                <div class="mt-1">
                    <input type="text" name="event_start" id="event_start"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="event.event_start">
                </div>
            </div>

            <div>
                <label for="event_start" class="block text-sm font-medium text-gray-700">Конец события</label>
                <div class="mt-1">
                    <input type="text" name="event_start" id="event_start"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="event.event_end">
                </div>
            </div>
        </div>

        <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
            Save
        </button>
    </form>
</template>

<script>
import useEvents from '../../composables/Events'
import { onMounted } from 'vue';

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },

    setup(props) {
        const { errors, event, updateEvent, getEvent } = useEvents()

        onMounted(() => getEvent(props.id))

        const saveEvent = async () => {
            await updateEvent(props.id)
        }

        return {
            errors,
            event,
            saveEvent
        }
    }
}
</script>
