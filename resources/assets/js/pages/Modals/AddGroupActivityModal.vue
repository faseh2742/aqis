<template>
    <modal>
        <template v-if="activityEdit" slot="header">Edit Group Activity</template>
        <template v-else slot="header">Add Group Activity</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <form id="addGroupActivityForm" @submit.prevent="saveActivity" @keydown="form.errors.clear($event.target.name)">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="programName">Program Name</label>
                            <select class="select md-menu md-select"
                                    v-model="form.programName"
                                    name="programName" id="programName" @change="form.errors.clear('programName')">
                                <option v-for="(programName, index) in programNames.items"
                                        :key="index" :value="programName.item">
                                    {{ programName.item }}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger"
                          v-if="form.errors.has('programName')"
                          v-text="form.errors.get('programName')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="type">Group Activity Type</label>
                            <select class="select md-menu md-select"
                                    v-model="form.type"
                                    name="type" id="type" @change="form.errors.clear('type')">
                                <option v-for="(type, index) in types.items" :key="index"
                                        :value="type.item">
                                    {{ type.item }}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('type')"
                          v-text="form.errors.get('type')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="description">Group Activity Description</label>
                            <select class="select md-menu md-select"
                                    v-model="form.description"
                                    name="description" id="description" @change="form.errors.clear('description')">
                                <option v-for="(description, index) in descriptions.items"
                                        :key="index" :value="description.item">
                                    {{ description.item }}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger"
                          v-if="form.errors.has('description')"
                          v-text="form.errors.get('description')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="location">Location</label>
                            <select class="select md-menu md-select"
                                    v-model="form.location"
                                    name="location" id="location" @change="form.errors.clear('location')">
                                <option v-for="(location, index) in locations.items"
                                        :key="index" :value="location.item">
                                    {{ location.item }}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger"
                          v-if="form.errors.has('location')"
                          v-text="form.errors.get('location')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="funder">Funder</label>
                            <select class="select md-menu md-select"
                                    v-model="form.funder"
                                    name="funder" id="funder" @change="form.errors.clear('funder')">
                                <option v-for="(funder, index) in funders.items" :key="index"
                                        :value="funder.item">
                                    {{ funder.item }}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('funder')"
                          v-text="form.errors.get('funder')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="facilitator">Facilitator</label>
                            <select class="select md-menu md-select" v-model="form.staff_id"
                                    name="staff_id" id="facilitator" @change="form.errors.clear('staff_id')">
                                <option v-for="(facilitator, index) in facilitators" :key="index" :value="facilitator.id">
                                    {{ facilitator.user.firstName + ' ' + facilitator.user.lastName }} </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('staff_id')"
                          v-text="form.errors.get('staff_id')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label for="title">Title</label>
                        <md-input v-model="form.event.title" type="text" name="title" id="title" @input="form.errors.clear('event.title')"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('event.title')"
                          v-text="form.errors.get('event.title')"></span>
                </div>
                 <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="serviceDelivery">Service Delivery</label>
                            <select class="select md-menu md-select"
                                    v-model="form.event.serviceDelivery"
                                    name="serviceDelivery" id="serviceDelivery" @change="form.errors.clear('event.serviceDelivery')">
                                <option v-for="(serviceDelivery, index) in serviceDeliveries.items" :key="index"
                                        :value="serviceDelivery.item">
                                    {{serviceDelivery.item}}
                                </option>
                            </select>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('event.serviceDelivery')"
                          v-text="form.errors.get('event.serviceDelivery')"></span>
                </div>
              <div v-if="form.event.serviceDelivery=='Video Portal'" class="md-layout-item md-small-size-50 md-size-100">
                    <md-field>
                        <label for="meetingLink">Meeting Link</label>
                         <md-input v-model="form.event.meetingLink" type="text" name="meetingLink" id="meetingLink" @input="form.errors.clear('event.meetingLink')"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('event.meetingLink')"
                          v-text="form.errors.get('event.meetingLink')"></span>
                </div>
                <div class="md-layout-item md-small-size-50 md-size-100">
                    <md-field>
                        <label for="capacity">Seat Capacity</label>
                        <md-input v-model="form.event.capacity" type="number" name="capacity" id="capacity" @input="form.errors.clear('event.capacity')"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('event.capacity')"
                          v-text="form.errors.get('event.capacity')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label for="startDate">Date</label>
                        <md-input v-model="form.event.startDate" type="date" name="startDate" id="startDate" @input="form.errors.clear('event.startDate')"></md-input>
                    </md-field>
                    <span class="help is-danger"
                          v-if="form.errors.has('event.startDate')"
                          v-text="form.errors.get('event.startDate')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="startTime">Start Time (hh:mm:am/pm)</label>
                        <md-input type="time"
                                  v-model="form.event.startTime"
                                  name="startTime" id="startTime"
                                  @input="form.errors.clear('event.startTime')"
                        />
                        <span class="help is-danger"
                              v-if="form.errors.has('event.startTime')"
                              v-text="form.errors.get('event.startTime')"></span>
                    </md-field>
                </div>

<!--                <div class="md-layout-item md-small-size-100 md-size-50">-->
<!--                    <div class="md-field md-theme-default">-->
<!--                        <label for="endDate">End Date</label>-->
<!--                        <datepicker :bootstrap-styling="true"-->
<!--                                    classes="md-input"-->
<!--                                    :typeable=true-->
<!--                                    v-model="form.event.endDate" :format="dateFormat"-->
<!--                                    id="endDate"-->
<!--                                    @input="form.errors.clear('event.endDate')"></datepicker>-->

<!--                        <span class="help is-danger" v-if="form.errors.has('event.endDate')"-->
<!--                              v-text="form.errors.get('event.endDate')"></span>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="endTime">End Time (hh:mm:am/pm)</label>
                            <md-input type="time"
                                   v-model="form.event.endTime"
                                   name="endTime" id="endTime"
                                      @input="form.errors.clear('event.endTime')"
                            />
                            <span class="help is-danger"
                                  v-if="form.errors.has('event.endTime')"
                                  v-text="form.errors.get('event.endTime')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="backgroundColor">Background Colour</label>
                        <md-input v-model="form.event.backgroundColor" type="color" name="backgroundColor" id="backgroundColor" value="#1fbc30">
                        </md-input>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="borderColor">Border Colour</label>
                        <md-input v-model="form.event.borderColor" type="color" name="borderColor" id="borderColor" value="#ffffff">
                        </md-input>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="textColor">Text Colour</label>
                        <md-input v-model="form.event.textColor" type="color" name="textColor" id="textColor" value="#ffffff">
                        </md-input>
                    </md-field>
                </div>

            </div>
        </form>

        <template slot="footer">
            <button class="button is-success" type="submit" form="addGroupActivityForm" :disabled="saveDisabled">
                <span> Save </span>
                <span class="icon is-small">
                    <i class="far fa-save"></i>
                </span>
            </button>
            <button class="button" @click="close">Cancel</button>
        </template>

    </modal>
</template>

<script>
    import Form from '../../Forms'
    import Datepicker from '@hokify/vuejs-datepicker';
    import moment from 'moment'
    import { mapFields } from 'vuex-map-fields';


    export default {

        name: 'AddGroupActivityModal',

        props: {
            client_id: '',
            activityEdit: '',
        },

        components: {
            Datepicker
        },

        created() {
            this.editCheck()
        },

        computed: {
            ...mapFields([
                'dropdowns', 'staffList'
            ]),
            programNames() {
                let programNames = this.dropdowns.find(function (el) {
                    return el.name === "Program Name"
                })
                return programNames
            },
            types() {
                let workshopTypes = this.dropdowns.find(function (el) {
                    return el.name === "Group Activity Type"
                })
                return workshopTypes
            },
            descriptions() {
                let descriptions = this.dropdowns.find(function (el) {
                    return el.name === "Group Activity Description"
                })
                return descriptions
            },

            locations() {
                let locations = this.dropdowns.find(function (el) {
                    return el.name === "Location"
                })
                return locations
            },

            funders() {
                let funders = this.dropdowns.find(function (el) {
                    return el.name === "Funder"
                })
                return funders
            },
             serviceDeliveries() {
      let serviceDeliveries = this.dropdowns.find(function (el) {
        return el.name === "Service Delivery Method";
      });
      return serviceDeliveries;
    },

            facilitators() {
                let facilitators = this.staffList.filter(function (el) {
                    return el.position === "AQIS Facilitator"
                })
                return facilitators
            },
        },

        data() {
            return {
                form: new Form({
                    'staff_id': '',
                    'programName': '',
                    'type': '',
                    'description': '',
                    'location': '',
                    'funder': '',

                    event: {
                        'title': '',
                        'startDate': '',
                        'startTime': '',
                        // 'endDate': '',
                        'endTime': '',
                        'type': 'groupActivity',
                        'backgroundColor': '#1fbc30',
                        'borderColor': '#ffffff',
                        'textColor': '#ffffff',
                        'meetingLink': '',
                        'capacity': 0,
                        'serviceDelivery':'',
                    },
                }),
                saveDisabled: false,
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },
            moment(date, format) {
                return moment(date).format(format)
            },
            editCheck() {
                if (this.activityEdit) {
                    this.form.staff_id = this.activityEdit.groupActivity.staff_id
                    this.form.programName = this.activityEdit.groupActivity.programName
                    this.form.type = this.activityEdit.groupActivity.type
                    this.form.description = this.activityEdit.groupActivity.description
                    this.form.location = this.activityEdit.groupActivity.location
                    this.form.funder = this.activityEdit.groupActivity.funder


                    this.form.event.title = this.activityEdit.title
                    this.form.event.startDate = this.moment(this.activityEdit.start, "YYYY-MM-DD")
                    this.form.event.startTime = this.moment(this.activityEdit.start,"HH:mm")
                    // this.form.event.endDate = moment(this.activityEdit.endDate).format("YYYY-MM-DD")
                    this.form.event.endTime = this.moment(this.activityEdit.end,"HH:mm")
                    this.form.event.backgroundColor = this.activityEdit.backgroundColor
                    this.form.event.borderColor = this.activityEdit.borderColor
                    this.form.event.textColor = this.activityEdit.textColor
                    this.form.event.meetingLink = this.activityEdit.meetingLink
                    this.form.event.capacity = this.activityEdit.capacity
                    this.form.event.serviceDelivery = this.activityEdit.serviceDelivery


                }
            },
            saveActivity() {
                this.saveDisabled = true
                if (this.activityEdit) {
                    this.form.put('api/groupActivities/' + this.activityEdit.id)
                        .then(response => {
                            console.log("Update Response",response)
                            this.$store.dispatch('confirmSuccess', 'Group Activity Saved.')
                            this.update(response.data)
                            this.close()
                            this.saveDisabled = false
                        })
                        .catch(errors => {
                            this.saveDisabled = false
                            console.log(errors)
                        })
                } else {
                    this.form.post('api/groupActivities')
                        .then(response => {
                             console.log("Save Response",response)
                            this.$store.dispatch('confirmSuccess', 'Group Activity Saved.')
                            this.update(response.data)
                            this.close()
                            this.saveDisabled = false
                        })
                        .catch(errors => {
                            this.saveDisabled = false
                            console.log(errors)
                        })
                }
            },
            update(eventData) {
                this.$emit('update', eventData)
            }
        }
    }

</script>
