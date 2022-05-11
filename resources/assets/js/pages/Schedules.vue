<template>
    <div class="content">
        <add-group-activity-modal
            v-if="showGroupActivityModal"
            @close="showGroupActivityModal=false"
            :activity-edit="activityEdit"
            @update="updateEvents"
        >
        </add-group-activity-modal>

        <add-registration-modal
            v-if="showRegistrationModal"
            @close="showRegistrationModal=false"
            :event="eventSelected"
            @remove="removeEvent"
            @update="rerenderEvents"
        >

        </add-registration-modal>
        <div class="md-layout">
            <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>

            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="green">
                        <h3 class="title">Schedules</h3>
                        <p class="titleCategory">Manage event scheduling</p>
                    </md-card-header>
                    <md-card-content>
                        <nav class="panel">
                            <div v-show="$root.canWrite('schedules')" class="panel-block">
                                <p>
                                    <a class="button is-link is-active" @click="openActivityModal">
                                        <span>Add Group Activity</span>
                                        <span class="icon is-small">
                        <i class="fas fa-users"></i>
                      </span>
                                    </a>
                                </p>
                            </div>

                            <div class="panel-block">
                                <calendar
                                    v-if="calendar.events != null"
                                    :default-view="calendar.defaultView"
                                    :editable="calendar.editable"
                                    :weekends="calendar.weekends"
                                    :events="calendar.events"
                                    :header="calendar.header"
                                    ref="calendar"
                                    @dateClick="dateClicked"
                                    @eventClick="eventClick"
                                >

                                </calendar>
                            </div>

                        </nav>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import calendar from '../components/Calendar.vue'
    import AddGroupActivityModal from "./Modals/AddGroupActivityModal";
    import { mapFields } from 'vuex-map-fields';
    import AddRegistrationModal from "./Modals/AddRegistrationModal";


    export default {

        name: 'Schedules',

        created() {
            this.fetchData()
        },

        mounted() {
        },

        components: {
            calendar, AddGroupActivityModal, AddRegistrationModal
        },

        data() {
            return {
                loading: false,
                moment: moment,
                showGroupActivityModal: false,
                showRegistrationModal: false,
                activityEdit: '',
                eventSelected: '',
                currentView: '',

                calendar: {
                    defaultView: "dayGridMonth",
                    editable: true,
                    weekends: true,
                    events: null,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    businessHours: {
                        daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Friday

                        startTime: '08:30', // a start time (8:30am in this example)
                        endTime: '16:30', // an end time (4:30pm in this example)
                    }
                },
            }
        },

        computed: {
            ...mapFields(['dropdowns']),
        },

        methods: {
            fetchData() {
                axios.get('/api/scheduleEvents')
                .then(response => {
                    this.calendar.events = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            updateEvents(e) {
                this.$refs.calendar.addEvent(e)
            },
            rerenderEvents () {
                this.fetchData()
                this.$refs.calendar.rerenderEvents()
            },
            removeEvent(id) {
                this.$refs.calendar.removeEvent(id)
            },
            getView() {
                this.currentView = this.$refs.calendar.getView()

            },
            openActivityModal() {
                this.showGroupActivityModal = true
            },
            dateClicked() {
                console.log(this.$refs.calendar.getView())
            },
            eventClick: function (event) {
                axios.get('/api/scheduleEvents/' + event.id)
                    .then(response => {
                        this.eventSelected = response.data
                        this.showRegistrationModal = true
                    })
            },

        },
    }

</script>
