<template>
    <modal>
        <template v-if="workshopEdit" slot="header">Edit Group Activity</template>
        <template v-else slot="header">Add Group Activity</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>

        <form method="post" @submit.prevent="saveWorkshop()" id="addWorkshopForm" @input="form.errors.clear($event.target.name)">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="programName">Program Name</label>
                            <select class="select md-menu md-select" v-model="form.programName" name="programName" id="programName">
                                <option v-for="(programName, index) in programNames.items" :key="index" :value="programName.item">
                                    {{ programName.item }} </option>
                            </select>
                        </div>
                    </md-field>
                     <span class="help is-danger" v-if="form.errors.has('programName')"
                        v-text="form.errors.get('programName')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="type">Group Activity Type</label>
                            <select class="select md-menu md-select" v-model="form.type" name="type" id="type">
                                <option v-for="(type, index) in workshopTypes.items" :key="index" :value="type.item">
                                    {{ type.item }} </option>
                            </select>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="description">Group Activity Description</label>
                            <select class="select md-menu md-select" v-model="form.description" name="description" id="description">
                                <option v-for="(description, index) in descriptions.items" :key="index" :value="description.item">
                                    {{ description.item }} </option>
                            </select>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Activity Duration (hh:mm)</label>                         

                        <md-input v-model="form.duration" name="duration" type="text" />    
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('duration')"
                        v-text="form.errors.get('duration')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-datepicker v-model="form.start_date" md-immediately @input="form.errors.clear('start_date')">
                        <label>Start Date</label>
                        <span class="md-helper-text">Format: DD-MM-YYYY</span>
                    </md-datepicker>
                     <span class="help is-danger" v-if="form.errors.has('start_date')"
                        v-text="form.errors.get('start_date')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-datepicker v-model="form.end_date" md-immediately @input="form.errors.clear('end_date')">
                        <label>End Date</label>
                        <span class="md-helper-text">Format: DD-MM-YYYY</span>
                    </md-datepicker>
                     <span class="help is-danger" v-if="form.errors.has('end_date')"
                        v-text="form.errors.get('end_date')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="location">Workshop Location</label>
                            <select class="select md-menu md-select" v-model="form.location"
                                name="location" id="location">
                                <option v-for="(location, index) in locations.items" :key="index" :value="location.item">
                                    {{ location.item }} </option>
                            </select>
                        </div>
                    </md-field>
                     <span class="help is-danger" v-if="form.errors.has('location')"
                        v-text="form.errors.get('location')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="funder">Funder</label>
                            <select class="select md-menu md-select" v-model="form.funder"
                                name="funder" id="funder">
                                <option v-for="(funder, index) in funders.items" :key="index" :value="funder.item">
                                    {{ funder.item }} </option>
                            </select>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="facilitator">Facilitator</label>
                            <select class="select md-menu md-select" v-model="form.staff_id"
                                name="staff_id" id="facilitator">
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
                        <label>Notes</label>
                        <md-textarea v-model="form.notes" name="notes"></md-textarea>
                        <span class="help is-danger" v-if="form.errors.has('notes')"
                            v-text="form.errors.get('notes')"></span>
                    </md-field>
                </div>

            </div>
          </form>

          <template slot="footer">
            <button class="button is-success" type="submit" form="addWorkshopForm">
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

export default {
  name: 'AddWorkshopModal',

  props: {
        client_id: '',
        workshopEdit: '',
    },

  created() {},

  mounted() {
        if (this.workshopEdit) {
            this.form.editForm(this.form, this.workshopEdit)
        }
    },
  
  computed: {
    programNames() {
        let programNames = this.$store.state.dropdowns.find(function (el) {
            return el.name === "Program Name"
        })
        return programNames
    },
    workshopTypes() {
            let workshopTypes = this.$store.state.dropdowns.find(function (el) {
                return el.name === "Group Activity Type"
            })
            return workshopTypes
        },
    descriptions() {
            let descriptions = this.$store.state.dropdowns.find(function (el) {
                return el.name === "Group Activity Description"
            })
            return descriptions
        },

        locations() {
            let locations = this.$store.state.dropdowns.find(function (el) {
                return el.name === "Location"
            })
            return locations
        },

        funders() {
            let funders = this.$store.state.dropdowns.find(function (el) {
                return el.name === "Funder"
            })
            return funders
        },

        facilitators() {
            let facilitators = this.$store.state.staffList.filter(function (el) {
                return el.position === "AQIS Facilitator"
            })
            return facilitators
        },

  },

  data() {
    return {
      form: new Form({
        client_id: this.client_id,
        programName: '',
        type: '',
        description: '',
        start_date: null,
        end_date: null,
        location: '',
        funder: '',
        staff_id: '',
        notes: '',
        duration: '',
      }),
    }
  },

  methods: {
    close() {
      this.$emit('close');
    },

    saveWorkshop () {
      if (this.workshopEdit) {
        this.form.put('api/workshop/' + this.workshopEdit.id)
        .then( response => {
          this.close()
        })
        .catch( errors => {
          console.log(errors)
        })
      } else {
      this.form.post('/api/workshop')
      .then (response => {
        this.$store.state.workshops.push(response)
        this.close()
      })
      .catch( errors=> {
        console.log(errors)
      })
      }
    },
  }
}

</script>