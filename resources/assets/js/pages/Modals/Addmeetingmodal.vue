<template>
  <modal>
    <template v-if="meetingEdit" slot="header">Edit Meeting</template>
    <template v-else slot="header">Add Meeting</template>
    <template slot="header-button">
      <button class="delete" aria-label="close" @click="close"></button>
    </template>
    <form
      method="post"
      @submit.prevent="saveMeeting()"
      id="addMeetingForm"
      @input="form.errors.clear($event.target.name)"
    >
      <div class="md-layout">
        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="programName">Program Name</label>
              <select
                class="select md-menu md-select"
                v-model="form.programName"
                name="programName"
                id="programName"
              >
                <option
                  v-for="(programName, index) in programNames.items"
                  :key="index"
                  :value="programName.item"
                >
                  {{ programName.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('programName')"
            v-text="form.errors.get('programName')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="serviceProvided">Service Provided</label>
              <select
                class="select md-menu md-select"
                v-model="form.serviceProvided"
                name="serviceProvided"
                id="serviceProvided"
              >
                <option
                  v-for="(serviceProvided, index) in servicesProvided.items"
                  :key="index"
                  :value="serviceProvided.item"
                >
                  {{ serviceProvided.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('serviceProvided')"
            v-text="form.errors.get('serviceProvided')"
          ></span>
        </div>

        <!-- Edited by Faseh  -->


        <!-- End Edit  -->

        <div class="md-layout-item md-small-size-100 md-size-50">
          <label>Meeting Date</label>
          <datepicker
            :bootstrap-styling="true"
            v-model="form.date"
            format="YYYY-MM-DD"
            id="date"
            @input="form.errors.clear('date')"
          ></datepicker>

          <span
            class="help is-danger"
            v-if="form.errors.has('date')"
            v-text="form.errors.get('date')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="duration">Meeting Duration (hh:mm)</label>

              <select
                class="select md-menu md-select"
                v-model="form.duration"
                name="duration"
                id="duration"
              >
                <option>00:15</option>
                <option>00:30</option>
                <option>00:45</option>
                <option>01:00</option>
                <option>01:15</option>
                <option>01:30</option>
                <option>01:45</option>
                <option>02:00</option>
                <option>02:15</option>
                <option>02:30</option>
                <option>02:45</option>
                <option>03:00</option>
                <option>03:00</option>
                <option>03:15</option>
                <option>03:30</option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('duration')"
            v-text="form.errors.get('duration')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="type">Meeting Type</label>
              <select
                class="select md-menu md-select"
                v-model="form.type"
                name="type"
                id="type"
              >
                <option
                  v-for="(type, index) in meetingTypes.items"
                  :key="index"
                  :value="type.item"
                >
                  {{ type.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('type')"
            v-text="form.errors.get('type')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="status">Meeting Status</label>
              <select
                class="select md-menu md-select"
                v-model="form.status"
                name="status"
                id="status"
                @input="form.errors.clear($event.target.name)"
              >
                <option
                  v-for="(status, index) in meetingStatuses.items"
                  :key="index"
                  :value="status.item"
                >
                  {{ status.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('status')"
            v-text="form.errors.get('status')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="serviceDelivery">Service Delivery Method</label>
              <select
                class="select md-menu md-select"
                v-model="form.serviceDelivery"
                name="serviceDelivery"
                id="serviceDelivery"
              >
                <option
                  v-for="(serviceDelivery, index) in serviceDeliveries.items"
                  :key="index"
                  :value="serviceDelivery.item"
                >
                  {{ serviceDelivery.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('serviceDelivery')"
            v-text="form.errors.get('serviceDelivery')"
          ></span>
        </div>

        <div v-if="form.serviceDelivery=='Video Portal'" class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value ">
              <label for="meetingLink">Meeting Link</label>
              <md-input
                type="text"
                v-model="form.meetingLink"
                name="meetingLink"
                id="meetingLink"
              >
              </md-input>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('meetingLink')"
            v-text="form.errors.get('meetingLink')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="location">Meeting Location</label>
              <select
                class="select md-menu md-select"
                v-model="form.location"
                name="location"
                id="location"
              >
                <option
                  v-for="(location, index) in locations.items"
                  :key="index"
                  :value="location.item"
                >
                  {{ location.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('location')"
            v-text="form.errors.get('location')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="funder">Funder</label>
              <select
                class="select md-menu md-select"
                v-model="form.funder"
                name="funder"
                id="funder"
              >
                <option
                  v-for="(funder, index) in funders.items"
                  :key="index"
                  :value="funder.item"
                >
                  {{ funder.item }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('funder')"
            v-text="form.errors.get('funder')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-50">
          <md-field>
            <div class="md-field md-theme-default md-has-value">
              <label for="facilitator">Facilitator</label>
              <select
                class="select md-menu md-select"
                v-model="form.staff_id"
                name="staff_id"
                id="facilitator"
              >
                <option
                  v-for="(facilitator, index) in facilitators"
                  :key="index"
                  :value="facilitator.id"
                >
                  {{
                    facilitator.user.firstName + " " + facilitator.user.lastName
                  }}
                </option>
              </select>
            </div>
          </md-field>
          <span
            class="help is-danger"
            v-if="form.errors.has('staff_id')"
            v-text="form.errors.get('staff_id')"
          ></span>
        </div>

        <div class="md-layout-item md-small-size-100 md-size-100">
          <md-field>
            <label>Notes</label>
            <md-textarea v-model="form.notes" name="notes"></md-textarea>
            <span
              class="help is-danger"
              v-if="form.errors.has('notes')"
              v-text="form.errors.get('notes')"
            ></span>
          </md-field>
        </div>
      </div>
    </form>

    <template slot="footer">
      <button
        class="button is-success"
        type="submit"
        form="addMeetingForm"
        :disabled="saveDisabled"
      >
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
import Form from "../../Forms";
import Datepicker from "@hokify/vuejs-datepicker";
import moment from "moment";

export default {
  name: "AddMeetingModal",

  props: {
    client_id: "",
    meetingEdit: "",
  },

  components: {
    Datepicker,
  },

  created() {},

  mounted() {
    if (this.meetingEdit) {
      this.form.editForm(this.form, this.meetingEdit);
    }
  },

  computed: {
    programNames() {
      let programNames = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Program Name";
      });
      return programNames;
    },
    servicesProvided() {
      let servicesProvided = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Meeting Service Provided";
      });
      return servicesProvided;
    },
    meetingTypes() {
      let meetingTypes = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Meeting Type";
      });
      return meetingTypes;
    },

    meetingStatuses() {
      let meetingStatuses = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Meeting Status";
      });
      return meetingStatuses;
    },

    serviceDeliveries() {
      let serviceDeliveries = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Service Delivery Method";
      });
      return serviceDeliveries;
    },

    locations() {
      let locations = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Location";
      });
      return locations;
    },

    funders() {
      let funders = this.$store.state.dropdowns.find(function (el) {
        return el.name === "Funder";
      });
      return funders;
    },
    facilitators() {
      return this.$store.getters.facilitators;
    },
  },

  data() {
    return {
      form: new Form({
        client_id: this.client_id,
        programName: "",
        serviceProvided: "",
        meetingLink: "",
        type: "",
        date: "",
        status: "",
        serviceDelivery: "",
        location: "",
        funder: "",
        staff_id: "",
        notes: "",
        duration: "",
      }),
      saveDisabled: false,
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    saveMeeting() {
      this.saveDisabled = true;
      if (this.meetingEdit) {
        this.form
          .put("api/meeting/" + this.meetingEdit.id)
          .then((response) => {
            this.$store.dispatch("confirmSuccess", "Meeting Saved.");
            this.saveDisabled = false;
            this.close();
          })
          .catch((errors) => {
            this.saveDisabled = false;
            console.log(errors);
          });
      } else {
        this.form
          .post("api/meeting")
          .then((response) => {
            this.$store.dispatch("confirmSuccess", "Meeting Saved.");
            this.saveDisabled = false;
            this.$store.state.meetings.push(response);
            this.close();
          })
          .catch((errors) => {
            this.saveDisabled = false;
            console.log(errors);
          });
      }
    },
  },
};
</script>
