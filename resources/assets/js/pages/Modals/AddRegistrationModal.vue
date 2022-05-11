<template>
    <modal>
        <add-group-activity-modal
            v-if="showGroupActivityModal"
            @close="showGroupActivityModal=false"
            :activity-edit="eventData"
            @update="update"
        >
        </add-group-activity-modal>

        <template slot="header">
            Group Activity Registration
        </template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>

        <div>
            <button class="button is-success" @click="showGroupActivityModal=true" v-if="$root.canWrite('schedules')">
                Edit Event
            </button>
            <button class="button is-danger" @click="deleteEvent(event.id)" v-if="$root.canDelete('schedules')">
                Delete Event
            </button>
        </div>

        <div class="tabs is-boxed">
            <ul>
                <li :class="{ 'is-active': tabSelected === 'registration' }" @click="tabSelected='registration'"><a>Registrations</a></li>
                <li :class="{ 'is-active': tabSelected === 'attendance' }" @click="tabSelected='attendance'"><a>Attendance</a></li>
            </ul>
        </div>

        <div v-if="tabSelected==='registration'">
            <div class="panel-block">
                <p class="control has-icons-left">
                    <input class="input is-small" type="text" name="string" placeholder="search"
                           v-model="searchString" @keyup="searchClient">
                    <span class="icon is-small is-left">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </span>
                </p>
            </div>

            <div v-if="searchResult" class="panel-block">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>WC ID</th>
                        <th>Register</th>
                    </tr>
                    <tr v-for="(client, index) in searchResult">
                        <td>{{client.user.firstName + " " + client.user.lastName}}</td>
                        <td>{{client.wc_id}}</td>
                        <td><button class="button is-info is-small" @click="registerClient(index, client.id)">
                            Register
                        </button></td>
                    </tr>
                </table>
            </div>

            <div class="panel-block">
                <table>
                    <tr style="align-items: center">
                        <th colspan="3">Registered Participants</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>WC ID</th>
                        <th>Unregister</th>
                    </tr>
                    <tr v-for="(client) in registeredClients">
                        <td>{{client.user.firstName + " " + client.user.lastName}}</td>
                        <td>{{client.wc_id}}</td>
                        <td><button class="button is-danger is-small" @click="unregisterClient(client.id)">
                            Un-Register
                        </button></td>
                    </tr>
                </table>
            </div>

        </div>

        <div v-if="tabSelected==='attendance'">

            <div class="panel-block">
                <table>
                    <tr style="align-items: center">
                        <th colspan="3">Attendance</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>WC ID</th>
                        <th style="text-align: center">Attended</th>
                    </tr>
                    <tr v-for="(client) in registeredClients">
                        <td>{{client.user.firstName + " " + client.user.lastName}}</td>
                        <td>{{client.wc_id}}</td>
                        <td style="text-align: center">
                            <input type="checkbox" class="checkbox" :id="client.id" @change="attend(client.id)" :checked="attending(client.id)">

                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </modal>
</template>

<script>
    import moment from 'moment'
    import { mapFields } from 'vuex-map-fields';
    import AddGroupActivityModal from "./AddGroupActivityModal";


    export default {
        name: 'AddRegistrationModal',

        props: {
            client_id: '',
            event: '',
        },

        components: {
            AddGroupActivityModal,
        },

        created() {
            this.fetchData()
        },

        computed: {
            ...mapFields([
                'dropdowns', 'staffList'
            ])
        },

        data() {
            return {
                saveDisabled: false,
                searchString: '',
                searchResult: '',
                registeredClients: '',
                attendingClients: [],
                tabSelected: 'registration',
                showGroupActivityModal: false,
                eventData: '',
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },
            moment: function () {
                return moment();
            },

            getRegistrations() {
                return axios.get('api/groupActivities/registrations/' + this.event.groupActivity_id)
            },

            getAttendances() {
                return  axios.get('api/scheduleEvents/attendances/' + this.event.id)
            },
            getEvent() {
                return axios.get('/api/scheduleEvents/' + this.event.id)
            },

            fetchData() {
                axios.all([this.getRegistrations(), this.getAttendances(), this.getEvent()])
                .then(response => {
                    this.registeredClients = response[0].data
                    this.attendingClients = response[1].data
                    this.eventData = response[2].data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },

            searchClient() {
                if (this.searchString != '') {
                    axios.post('api/search/client/registration', {
                        string: this.searchString,
                        groupActivity_id: this.event.groupActivity_id
                    })
                        .then(response => {
                            this.searchResult = response.data
                        })
                        .catch(errors => {
                            console.log(errors)
                        })
                } else {
                    this.searchResult = ''
                }
            },

            update(eventData) {
                this.$emit('update', eventData)
                this.fetchData()
            },
            remove(eventId) {
                this.$emit('remove', eventId)
            },
            registerClient(index, client_id) {
                this.searchResult.splice(index,1)
                axios.post('api/groupActivities/registerClient', {
                    groupActivity_id: this.event.groupActivity_id,
                    client_id: client_id
                })
                .then(response => {
                    this.fetchData()
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            unregisterClient(client_id) {
                axios.post('api/groupActivities/unregisterClient', {
                    groupActivity_id: this.event.groupActivity_id,
                    client_id: client_id
                })
                .then(response => {
                    this.searchResult = ''
                    this.fetchData()
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            attend(client_id) {
                axios.post('api/scheduleEvents/attend', {
                    event_id: this.event.id,
                    client_id: client_id
                })
                .then(response => {
                    this.fetchData()
                })
            },

            attending(client_id) {
              if (this.attendingClients.find(client => client.id === client_id)) {
                  return true
              }
              return false
            },

            deleteEvent(id) {
                let payload = {
                    url: '/api/scheduleEvents/',
                    id: id,
                    confirmtxt: 'Schedule has been deleted.'
                }
                this.$store.dispatch('deleteRecord', payload)
                .then(response => {
                    this.remove(id)
                    this.close()
                })
            },
        }
    }

</script>
