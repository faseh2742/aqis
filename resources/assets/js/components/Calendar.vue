<template>

    <div>
<!--        <div>-->
<!--            <a @click="previous" class="button is-success is-active"><</a>-->
<!--            <a @click="next" class="button is-success is-active">></a>-->
<!--            <a @click="today" class="button is-success is-active">Today</a>-->
<!--        </div>-->
        <FullCalendar
            ref="fullCalendar"
            :defaultView="defaultView"
            :editable="editable"
            :plugins='calendarOptions.plugins'
            :events="calendarEvents"
            :header="header"
            :weekends="weekends"
            :businessHours="businessHours"
            @dateClick="$emit('dateClick')"
            @eventClick="eventClick"
        />
    </div>

</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import moment from 'moment'

    export default {
        name: "Calendar",

        props: [
            'events',
            'weekends',
            'defaultView',
            'editable',
            'header',
            'businessHours',
        ],

        mounted() {
            this.getView()
        },

        components: {
            FullCalendar,
        },

        watch: {
        },

        data() {
            return {
                calendarOptions: {
                    plugins: [
                        dayGridPlugin,
                        timeGridPlugin,
                        interactionPlugin // needed for dateClick
                    ],
                },
                currentView: '',
                calendarEvents: this.events
            }
        },

        methods: {
            eventClick(eventClickInfo) {
                this.$emit('eventClick', eventClickInfo.event)
            },
            getView() {
                let calendarApi = this.$refs.fullCalendar.getApi()
            },
            previous() {
                let calendarApi = this.$refs.fullCalendar.getApi()
                return calendarApi.prev()
            },
            next() {
                let calendarApi = this.$refs.fullCalendar.getApi()
                return calendarApi.next()
            },
            today() {
                let calendarApi = this.$refs.fullCalendar.getApi()
                return calendarApi.today()
            },
            rerenderEvents() {
                let calendarApi = this.$refs.fullCalendar.getApi()
                return calendarApi.rerenderEvents()
            },
            onNext() {
                let calendarApi = this.$refs.fullCalendar.getApi()

                calendarApi.on('next', function(info) {
                    console.log('here you go ' + info.dateStr);
                });
            },
            addEvent(eventData) {
                let calendarApi = this.$refs.fullCalendar.getApi()
                return calendarApi.addEvent(eventData)
            },
            removeEvent(id) {
                let calendarApi = this.$refs.fullCalendar.getApi()
                let event = calendarApi.getEventById(id)
                event.remove()
            }
        },
    }
</script>

<style scoped>

</style>
