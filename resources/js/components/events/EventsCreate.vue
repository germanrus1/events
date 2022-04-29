<template>
    <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
        {{ errors }}
    </div>

    <form class="space-y-6" @submit.prevent="saveEvent">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.name">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <div class="mt-1">
                    <textarea type="text" name="description" id="description"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.description">
                    </textarea>
                </div>
            </div>

            <div>
                <div class="row flex justify-center mt-3">
                    <Datepicker class="col-3"
                                id="event_start"
                                v-model="form.event_start"
                                :value="form.event_start"
                                placeholder="Выберите начало события"
                                textInput
                                :format="'yyyy-MM-dd HH:mm'"
                    />

                    <Datepicker class="offset-1 col-3"
                                id="event_end"
                                v-model="form.event_end"
                                :value="form.event_end"
                                placeholder="Выберите конец события"
                                textInput
                                :format="'yyyy-MM-dd HH:mm'"
                    />
                </div>
            </div>
        </div>
        <div class="row flex justify-center mt-5">
            <button type="submit"
                    class="btn btn-success col-2">
                Добавить
            </button>
        </div>
    </form>
</template>

<script>
import useEvents from '../../composables/events';
import { reactive, ref } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import moment from 'moment';

export default {
    components: { Datepicker },
    setup() {
        const form = reactive({
            name: '',
            description: '',
            event_start: '',
            event_end: ''
        })

        const { errors, storeEvent } = useEvents()

        const saveEvent = async () => {
            await storeEvent({ ...form })
        }
        return {
            form,
            errors,
            saveEvent,
        }
    }
}
</script>
