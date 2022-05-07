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
                <div class="mt-1">
                    <Multiselect
                        mode="tags"
                        :createTag="true"
                        tag-position="bottom"
                        v-model="event.users"
                        @click="test(event.users)"
                        :options="users"
                    />
                </div>
            </div>
            <div>
                <div class="row flex justify-center mt-3">
                    <Datepicker class="col-3"
                                id="event_start"
                                v-model="event.event_start"
                                :value="event.event_start"
                                placeholder="Выберите начало события"
                                textInput
                                @click="test(event)"
                                :format="'yyyy-MM-dd HH:mm'"
                    />

                    <Datepicker class="offset-1 col-3"
                                id="event_end"
                                v-model="event.event_end"
                                :value="event.event_end"
                                placeholder="Выберите конец события"
                                textInput
                                :format="'yyyy-MM-dd HH:mm'"
                    />
                </div>
            </div>
        </div>

        <div class="row flex justify-center mt-5">
            <button type="submit"
                    class="btn btn-primary col-2">
                Сохранить
            </button>
        </div>
    </form>
</template>

<script>
import useEvents from '../../composables/Events'
import { onMounted } from 'vue';
import Datepicker from "@vuepic/vue-datepicker";
import moment from 'moment';
import Multiselect from "@vueform/multiselect";

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },
    components: { Datepicker, Multiselect },
    setup(props) {
        const { errors, event, users, updateEvent, getMembers, getEvent  } = useEvents()
        onMounted(() => {
            getEvent(props.id)
            getMembers(props.id)
        })
        const saveEvent = async () => {
            await updateEvent(props.id)
            await getMembers(props.id)
        }
        const test = (event) => {
            console.log('test', event.event_start)
        }
        return {
            errors,
            event,
            users,
            saveEvent,
            getMembers,
            test,
        }
    }
}
</script>
