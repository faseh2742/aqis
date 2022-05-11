<template>
    <modal>
        <aptemplate-search-modal @close="showSearchTemplateModal = false" @import="importAptemplate"
                                 v-if="showSearchTemplateModal"></aptemplate-search-modal>
        <add-clientap-modal :aptemplateEdit="aptemplateEdit" :aptemplateImport="aptemplateImport" :clientapImport="clientapImport"
                            :client_id="meeting.client_id" :clientmeeting_id="meeting.id"
                            :staff_id="meeting.staff_id" @close="closeClientapModal"
                            v-if="showAddClientapModal"></add-clientap-modal>
        <clientap-modal :actionplan="actionplanPassed" @close="showClientapModal = false"
                        v-if="showClientapModal"></clientap-modal>
        <template slot="header">Resources <br>

            <a @click="searchTemplate" class="button is-primary is-active">
                <span>Add from template</span>
                <span class="icon is-small">
                    <i class="fas fa-plus-square"></i>
                </span>
            </a>

            <button class="button is-info is-active" @click="showExistingAps('existingAPModal')">
                <span>Add from existing</span>
                <span class="icon is-small">
                    <i class="fas fa-plus-square"></i>
                </span>
            </button>

        </template>
        <template slot="header-button">
            <button @click="close" aria-label="close" class="delete"></button>
        </template>
        <table class="table">
            <tr>
                <th>Program Name</th>
                <td> {{ meeting.programName }}</td>
                <th>Service Provided</th>
                <td> {{ meeting.serviceProvided }}</td>
            </tr>
            <tr>
                <th>Meeting Type</th>
                <td> {{ meeting.type }}</td>
                <th>Meeting date</th>
                <td> {{ meeting.date }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td> {{ meeting.status }}</td>
                <th>Location</th>
                <td> {{ meeting.location }}</td>
            </tr>
            <tr>
                <th>Funder</th>
                <td> {{ meeting.funder }}</td>
                <th>Facilitator</th>
                <td> {{ meeting.staff.user.firstName + " " + meeting.staff.user.lastName }}</td>
            </tr>
            <tr>
                <th>Meeting Duration (hh:mm)</th>
                <td> {{ meeting.duration }}</td>
                <th></th>
                <td></td>
            </tr>
            <tr>
                <th>Meeting Notes</th>
                <td> {{ meeting.notes }}</td>
                <th></th>
                <td></td>
            </tr>
        </table>
        <h1>
            Resources
        </h1>
        <div class="content">
            <table class="table">
                <tr>
                    <th>Created at</th>
                    <th>NOC</th>
                    <th>Category</th>
                    <th class="is-narrow">Edit</th>
                    <th class="is-narrow">Delete</th>
                </tr>
                <tr :key="index" v-for="(actionplan, index) in meetingAps">
                    <td>
                        <div>{{actionplan.created_at | moment }}</div>
                    </td>
                    <td>
                        <div @click="openClientap(actionplan)"><a> {{ actionplan.noc.code }} </a></div>
                    </td>
                    <td>
                        <div @click="openClientap(actionplan)"><a> {{ actionplan.noc.title }} </a></div>
                    </td>
                    <td>
                        <div align="right">
                            <button @click="editClientap(actionplan)"
                                    class="button is-success">
                                <span><i class="fas fa-pencil-alt"></i></span>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div align="right">
                            <button @click="deleteClientap(index, actionplan.id)"
                                    class="button is-danger">
                                <span><i class="far fa-trash-alt"></i></span>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <template slot="footer">
            <button @click="close" class="button">Close</button>
        </template>
        <app-modal :scrollable="true" height="auto" name="existingAPModal">
            <table class="table">
                <tr>
                    <th>Created at</th>
                    <th>NOC</th>
                    <th>Category</th>
                    <th class="is-narrow">Import</th>
                </tr>
                <tr :key="index" v-for="(actionplan, index) in clientaps">
                    <td>
                        <div>{{actionplan.created_at | moment }}</div>
                    </td>
                    <td>
                        <div @click="openClientap(actionplan)"><a> {{ actionplan.noc.code }} </a></div>
                    </td>
                    <td>
                        <div @click="openClientap(actionplan)"><a> {{ actionplan.noc.title }} </a></div>
                    </td>
                    <td>
                        <div align="right">
                            <button @click="importClientap(actionplan)"
                                    class="button is-success">
                                <span><i class="fas fa-file-import"></i></span>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </app-modal>
    </modal>
</template>

<script>
    import AptemplateSearchModal from '../Modals/AptemplateSearchModal.vue'
    import AddClientapModal from '../Modals/AddClientapModal.vue'
    import ClientapModal from '../Modals/ClientapModal.vue'
    import moment from 'moment'

    export default {
        name: 'meetingResourceModal',

        props: {
            meeting: '',
            client_id: '',
        },

        components: {
            AptemplateSearchModal,
            AddClientapModal,
            ClientapModal,
        },

        created() {
            this.getMeetingAps(this.meeting.id)
        },

        data() {
            return {
                showSearchTemplateModal: false,
                showAddClientapModal: false,
                showClientapModal: false,
                aptemplateImport: '',
                clientapImport: '',
                aptemplateEdit: '',
                meetingAps: [],
                clientaps: [],
                actionplanPassed: '',
            }
        },

        filters: {
            moment: function (date) {
                return moment(date).format('MMMM Do YYYY');
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },
            moment: function () {
                return moment();
            },
            importAptemplate(event) {
                this.aptemplateImport = event
                this.showSearchTemplateModal = false
                this.showAddClientapModal = true
            },

            importClientap(clientap) {
                this.clientapImport = clientap
                this.$modal.hide('existingAPModal')
                this.showAddClientapModal = true
            },

            closeClientapModal() {
                this.aptemplateImport = '',
                this.clientapImport = '',
                this.aptemplateEdit = '',
                this.getMeetingAps(this.meeting.id)
                this.showAddClientapModal = false
            },
            openClientap(actionplan) {
                this.actionplanPassed = actionplan
                this.showClientapModal = true
            },
            searchTemplate() {
                this.showSearchTemplateModal = true
            },
            getMeetingAps(meeting_id) {
                axios.get('/api/meeting/clientaps/' + meeting_id)
                .then(response => {
                    this.meetingAps = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            getClientaps(id) {
                axios.get('/api/clients/getActionPlans/' + id)
                    .then(response => {
                        this.clientaps = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },

            showExistingAps(modalName) {
                this.getClientaps(this.client_id)
                this.$modal.show(modalName)
            },

            editClientap(item) {
                this.aptemplateEdit = item
                this.showAddClientapModal = true
            },
            deleteClientap(index, id) {
                let payload = {
                    url: '/api/clientaps/',
                    id: id,
                    confirmtxt: 'Client action plan has been deleted.'
                }
                this.$store.dispatch('deleteRecord', payload)
                .then(response => {
                    this.meetingAps.splice(index, 1)
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
        },
    }
</script>
