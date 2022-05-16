<template>
    <div class="container">
        <div class="row text-center">
            <div class="row flex justify-center m-2">
                <Datepicker class="col-3"
                            v-model="dateWeek"
                            :value="dateWeek"
                            @update:modelValue="handleDateWeek"
                            @closed=""
                            placeholder="Выберите дату"
                            textInput
                            :format="'yyyy-MM-dd, ' + moment(dateWeek).locale('ru').format('dddd')"
                />
            </div>
            <div class="col-1 p-1">
                <router-link :to="{ name: 'events.create' }" class="btn btn-success">Добавить событие</router-link>
            </div>
            <div class="col-11 date-row date-row--header fw-bolder">
                <div class="date-col date-col-bg" v-for="n in 7">
                    {{moment(dateWeek).add((n-4), 'day').locale('ru').format('dddd')}}<br>{{ moment(dateWeek).add((n-4), 'day').format("YYYY-MM-DD") }}
                </div>
            </div>
        </div>
        <div class="row"><div class="col-12" style="width: 98%;"><hr></div></div>
        <div class="row">
            <div class="col-1 fw-bolder">
                <div class="row" v-for="(index) in 25">
                    <div class="bg-info date-row_time align-items-center">{{index < 10 ? '0'+index-1 : index-1}}:00</div>
                    <div class="date-row_time">{{index < 10 ? '0'+index-1 : index-1}}:30</div>
                </div>
            </div>

            <div class="col-11 date-row">
                <div class="date-col date-col-bg " v-for="(n) in 7">
                    <div class="event-card"
                        v-for="event in events['w_' + moment(dateWeek).add((n-4), 'day').isoWeekday()]"
                        :style="{
                            top: (event.event_start - moment(moment(dateWeek).format('YYYY-MM-DD') + ' 00:00').add((n-4), 'day').format('X')) / 30 + 'px',
                            height: (event.event_end - event.event_start) / 30 + 'px',
                        }
                    ">
                        {{moment(dateWeek).format('YYYY-MM-DD')}}
                        <div class="event-card--name">
                            <router-link :to="{ name: 'events.edit', params: { id: event.id } }">{{ event.name }}</router-link>
                        </div>
                        <div class="event-card--description">{{ event.description }}</div>
                        <div class="event-card--time">
                            <div style="width: 45%">
                                {{moment.unix(event.event_start).format('HH:MM')}}
                            </div>
                            <div style="width: 10%"> — </div>
                            <div style="width: 45%">
                                {{moment.unix(event.event_end).format('HH:MM')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row flex justify-center mt-3">
        <div class="col-2 btn btn-success">
            <router-link :to="{ name: 'events.create' }" class="text-sm font-medium text-white">Добавить событие</router-link>
        </div>
    </div>
</template>

<script>
import useEvents from '../../composables/events';
import { onMounted } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { ref } from 'vue';
import moment from 'moment';
import Identicon from 'identicon.js'

export default {
    components: { Datepicker, Identicon },
    setup() {
        const { events, getEvents, destroyEvent } = useEvents()
        const deleteEvent = async (id) => {
            if (!window.confirm('Вы уверены, что хотите удалить?')) {
                return
            }

            await destroyEvent(id)
            await getEvents()
        }
        const getWeekDayName = (w) => {
            return weeks[getWeekDayNum(w)];
        }
        const getHashCode = (str = '') => {
            return (str + 'd3b07384d113edec49eaa6238ad5ff00').substr(0, 15);
        }
        const getWeekDayNum = (w) => {
            w = moment(dateWeek).isoWeekday() + w;
            if (w < 0) return 7+w
            else if (w > 6) return w-7
            else return w
        }
        const dateWeek = ref();
        const handleDateWeek = (date) => {
            getEvents(moment(date).format("YYYY-MM-DD"));
        }

        const weeks = [
            'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'
        ]

        // add avatar
        let avatarElement = document.getElementById('userAvatar');
        if (!avatarElement.innerHTML) {
            let dataAvatar = new Identicon(getHashCode(avatarElement.dataset.name), 420).toString();
            avatarElement.innerHTML = '<img style="height: 40px; object-fit: cover;" src="data:image/png;base64,' + dataAvatar + '">';

        }

        onMounted(getEvents)

        return {
            events,
            deleteEvent,
            weeks,
            dateWeek,
            handleDateWeek,
            moment,
            getWeekDayName,
            getWeekDayNum,
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
