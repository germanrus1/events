<template>
    <div class="container">
        <div class="row text-center">
            <div class="offset-1 col-11 date-row date-row--header">
                <div class="date-col date-col-bg" v-for="n in weeks">
                    {{n}}<br>01.01.2022
                </div>
            </div>
        </div>
        <div class="row"><div class="col-12" style="width: 98%;"><hr></div></div>
        <div class="row">
            <div class="col-1">
                <div class="row" v-for="(index) in 25">
                    <div class="bg-info date-row_time align-items-center">{{index < 10 ? '0'+index-1 : index-1}}:00</div>
                    <div class="date-row_time">{{index < 10 ? '0'+index-1 : index-1}}:30</div>
                </div>
            </div>

            <div class="col-11 date-row">
                <div class="date-col date-col-bg " v-for="(index) in weeks">
                    <div class="event-card" style="margin-top: 100px; height: 120px">
                        <div class="event-card--name">
                            <router-link :to="{ name: 'events.edit', params: { id: index } }">Изменить</router-link>
                        </div>
                        <div class="event-card--description">Встреча всех любителей пива, обсуждение хорошего пива</div>
                        <div class="event-card--time">
                            <div style="width: 45%">
                                13:30
                            </div>
                            <div style="width: 10%"> — </div>
                            <div style="width: 45%">
                                14:30
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex place-content-end mb-4">
        <div class="px-4 py-2 text-white bg-gray-800 hover:bg-gray-800 cursor-pointer">
            <router-link :to="{ name: 'events.create' }" class="text-sm font-medium">Добавить событие</router-link>
        </div>
    </div>
    <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
        <table class="min-w-full border divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Name</span>
                </th>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Description</span>
                </th>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Start</span>
                </th>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">End</span>
                </th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in events" :key="item.id">
                <tr class="bg-white">
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.name }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.description }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.event_start }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.event_end }}
                    </td>

                    <td class="px-6 py-4 text-sm text-center leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'events.edit', params: { id: item.id } }"
                                     class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Изменить</router-link>
                        <button @click="deleteEvent(item.id)"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Удалить</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import useEvents from '../../composables/events'
import { onMounted } from 'vue';

export default {
    setup() {
        const { events, getEvents, destroyEvent } = useEvents()

        const deleteEvent = async (id) => {
            if (!window.confirm('Вы уверены, что хотите удалить?')) {
                return
            }

            await destroyEvent(id)
            await getEvents()
        }

        const weeks = [
            'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'
        ]

        const showModal = false

        onMounted(getEvents)

        return {
            events,
            deleteEvent,
            weeks,
        }
    }
}
</script>

<style>
    .date-row {
        display: flex;
    }
    .date-row--header {
        height: 72px;
        display: flex;
        align-content: center;
    }
    .date-col-bg {
        color: #2e5464;
        border: solid 3px;
        border-top: 0;
        border-bottom: 0;
        background-color: #67c2e9;
    }
    .date-col-bg:last-child {
        border-right: 0;
    }
    .date-col-bg:first-child {
        border-left: 0;
    }
    .date-col {
        width: 14%;
        text-align: center;
        position: relative;
        display: flex;
        justify-content: center;
    }
    .date-row_time {
        height: 60px;
    }
    .event-card {
        width: 96%;
        margin: auto;
        background-color: #fefff1;
        top: 0;
        position: absolute;
        border-radius: 3px;
    }
    .event-card--name {
        text-align: center;
        font-size: 12px;
        font-weight: bold;
    }
    .event-card--description {
        font-size: 10px;
        text-align: left;
        padding: 0 2px;
    }
    .event-card--time {
        font-size: 12px;
        font-weight: bold;
        justify-content: space-between;
        display: flex;
        position: absolute;
        width: 100%;
        bottom: 0;
    }
</style>
