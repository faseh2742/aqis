<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p v-if="editing" class="modal-card-title">Edit Client</p>
          <p v-else class="modal-card-title">Add Client</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <template slot="header-button">
          <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <section class="modal-card-body">
          <md-card>
            <md-card-content>
              <form
                method="post"
                @submit.prevent="updateClient(client_id)"
                @keydown="form.errors.clear($event.target.name)"
                id="addClientForm"
              >
                <div class="md-layout">
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>First Name</label>
                      <md-input
                        v-if="form.user"
                        v-model="form.user.firstName"
                        type="text"
                        name="firstName"
                      ></md-input>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('firstName')"
                        v-text="form.errors.get('firstName')"
                      ></span>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Last Name</label>
                      <md-input
                        v-if="form.user"
                        v-model="form.user.lastName"
                        type="text"
                        name="lastName"
                      ></md-input>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('lastName')"
                        v-text="form.errors.get('lastName')"
                      ></span>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Welcome Centre ID</label>
                      <md-input
                        v-model="form.wc_id"
                        type="text"
                        name="wc_id"
                      ></md-input>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('wc_id')"
                        v-text="form.errors.get('wc_id')"
                      ></span>
                    </md-field>
                  </div>
                  <!-- <div class="md-layout-item md-small-size-100 md-size-50">
                                        <md-field>
                                            <label>Username</label>
                                            <md-input v-if="form.user" v-model="form.user.username" type="text"
                                                      name="username"></md-input>
                                            <span class="help is-danger" v-if="form.errors.has('username')"
                                                  v-text="form.errors.get('username')"></span>
                                        </md-field>
                                    </div> -->
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>E-mail</label>
                      <md-input
                        v-if="form.user"
                        v-model="form.user.email"
                        type="text"
                        name="email"
                      ></md-input>
                      <span class="help is-danger" v-if="form.errors.has('email')"
                                                v-text="form.errors.get('email')"></span>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="immigrationStatus"
                          >Immigration Status</label
                        >
                        <select
                          class="select md-menu md-select"
                          v-model="form.immigrationStatus"
                          name="immigrationStatus"
                          id="immigrationStatus"
                        >
                          <option
                            v-for="(status, index) in immigrationStatuses"
                            :key="index"
                            :value="status.item"
                          >
                            {{ status.item }}
                          </option>
                        </select>
                      </div>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <!--                          <md-datepicker v-model="form.dob" md-immediately>-->
                    <!--                          <label>Date of birth</label>-->
                    <!--                          <span class="md-helper-text">Format: DD-MM-YYYY</span>-->
                    <!--                          </md-datepicker>-->
                    <label for="dob">Date of birth</label>
                    <datepicker
                      :bootstrap-styling="true"
                      :typeable="true"
                      v-model="form.dob"
                      :format="dateFormatter"
                      id="dob"
                    ></datepicker>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <!--                          <md-datepicker v-model="form.doa" md-immediately>-->
                    <!--                          <label>Date of arrival</label>-->
                    <!--                          </md-datepicker>-->
                    <label for="doa">Date of arrival</label>
                    <datepicker
                      :bootstrap-styling="true"
                      :typeable="true"
                      v-model="form.doa"
                      :format="dateFormatter"
                      id="doa"
                    ></datepicker>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="gender">Gender</label>
                        <select
                          class="select md-menu md-select"
                          v-model="form.gender"
                          name="gender"
                          id="gender"
                        >
                          <option
                            v-for="(gender, index) in genders"
                            :key="index"
                            :value="gender.item"
                          >
                            {{ gender.item }}
                          </option>
                        </select>
                      </div>
                    </md-field>
                  </div>

                  <div
                    class="md-layout-item md-small-size-100 md-size-50"
                  ></div>

                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                      <label>Street address</label>
                      <md-input
                        v-model="form.streetAddress"
                        type="text"
                        name="streetAddress"
                      ></md-input>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('streetAddress')"
                        v-text="form.errors.get('streetAddress')"
                      ></span>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                      <label>City</label>
                      <city-list v-model="form.city"> </city-list>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('city')"
                        v-text="form.errors.get('city')"
                      ></span>
                        </div>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="province">Province</label>
                        <select
                          class="select md-menu md-select"
                          v-model="form.province"
                          name="province"
                          id="province"
                        >
                          <option value="AB">Alberta</option>
                          <option value="BC">British Columbia</option>
                          <option value="MB">Manitoba</option>
                          <option value="NB">New Brunswick</option>
                          <option value="NL">Newfoundland and Labrador</option>
                          <option value="NS">Nova Scotia</option>
                          <option value="ON">Ontario</option>
                          <option value="PE">Prince Edward Island</option>
                          <option value="QC">Quebec</option>
                          <option value="SK">Saskatchewan</option>
                          <option value="NT">Northwest Territories</option>
                          <option value="NU">Nunavut</option>
                          <option value="YT">Yukon</option>
                        </select>
                      </div>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Postal Code</label>
                      <md-input
                        v-model="form.postalCode"
                        type="text"
                        name="postalCode"
                      ></md-input>
                      <span class="md-helper-text">Format: A1A 1A1</span>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('postalCode')"
                        v-text="form.errors.get('postalCode')"
                      ></span>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Primary Phone</label>
                      <md-input
                        v-model="form.phonePrimary"
                        type="tel"
                        name="phonePrimary"
                      >
                      </md-input>
                      <span class="md-helper-text">Format: 123-456-7890</span>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('phonePrimary')"
                        v-text="form.errors.get('phonePrimary')"
                      ></span>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Secondary Phone</label>
                      <md-input
                        v-model="form.phoneSecondary"
                        type="tel"
                        name="phoneSecondary"
                      >
                      </md-input>
                      <span class="md-helper-text">Format: 123-456-7890</span>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('phoneSecondary')"
                        v-text="form.errors.get('phoneSecondary')"
                      ></span>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="motherTongue">Mother Tongue</label>
                        <LanguageList
                          id="motherTongue"
                          v-model="form.motherTongue"
                        ></LanguageList>
                      </div>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="countryOrigin">Country of Origin</label>
                        <CountryList
                          id="countryOrigin"
                          v-model="form.countryOrigin"
                        ></CountryList>
                      </div>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="engProficiency">English Proficiency</label>
                        <select
                          class="select md-menu md-select"
                          v-model="form.engProficiency"
                          name="engProficiency"
                          id="engProficiency"
                        >
                          <option
                            v-for="(engProficiency, index) in engProficiencies"
                            :key="index"
                            :value="engProficiency.item"
                          >
                            {{ engProficiency.item }}
                          </option>
                        </select>
                      </div>
                    </md-field>
                  </div>

                  <div
                    class="md-layout-item md-small-size-100 md-size-50"
                  ></div>

                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <label for="interpreterNeeded">Interpreter Needed?</label>
                    <md-radio
                      name="interpreterNeeded"
                      v-model="form.interpreterNeeded"
                      :value="0"
                    >
                      No
                    </md-radio>
                    <md-radio
                      name="interpreterNeeded"
                      v-model="form.interpreterNeeded"
                      :value="1"
                      class="md-primary"
                    >
                      Yes
                    </md-radio>
                  </div>

                  <div
                    v-if="form.interpreterNeeded == 1"
                    class="md-layout-item md-small-size-100 md-size-50"
                  >
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="interpreterLanguage"
                          >Interpreter Language</label
                        >

                        <LanguageList :value="form.interpreterLanguage"></LanguageList>
                      </div>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <label for="childcareNeeded">Childcare Needed?</label>
                    <md-radio
                      name="childcareNeeded"
                      v-model="form.childcareNeeded"
                      :value="0"
                    >
                      No
                    </md-radio>
                    <md-radio
                      name="childcareNeeded"
                      v-model="form.childcareNeeded"
                      :value="1"
                      class="md-primary"
                    >
                      Yes
                    </md-radio>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                      <label>Notes</label>
                      <md-textarea v-model="form.notes"></md-textarea>
                    </md-field>
                  </div>
                </div>
              </form>
            </md-card-content>
          </md-card>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button is-success"
            @click="updateClient"
            :disabled="saveDisabled"
          >
            Save changes
          </button>
          <button class="button" @click="close">Cancel</button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
import Form from "../../Forms.js";
import CountryList from "../CountryList";
import LanguageList from "../LanguageList";
import CityList from "../CityList";
import Datepicker from "@hokify/vuejs-datepicker";
import moment from "moment";

export default {
  name: "AddClientModal",

  props: {
    client_id: "",
    editing: "",
  },

  mounted() {
    this.getClient();
    this.fetchData();

  },

  data() {
    return {
      showInterpreterLang: false,
      saveDisabled: false,
      immigrationStatuses: [],
      genders: [],
      engProficiencies: [],
      form: new Form({
        user: {},
        wc_id: "",
        immigrationStatus: "",
        dob: "",
        doa: "",
        gender: "",
        streetAddress: "",
        city: "",
        province: "",
        postalCode: "",
        phonePrimary: "",
        phoneSecondary: "",
        motherTongue: "",
        countryOrigin: "",
        engProficiency: "",
        interpreterNeeded: 0,
        interpreterLanguage: "",
        childcareNeeded: "",
        notes: "",

      }),
    };
  },

  components: {
    CountryList,
    LanguageList,
    CityList,
    Datepicker,
  },

  methods: {

    close() {
      this.$emit("close");
    },
    getClient() {
      return axios
        .get("/api/clients/" + this.client_id)
        .then((response) => {
          this.form.editForm(this.form, response.data);
        })
        .catch((errors) => {
          console.log(errors.response.data);
        });
    },
    getImmigrationStatus() {
      return axios.get("/api/getdropdown/2");
    },
    getGenders() {
      return axios.get("/api/getdropdown/1");
    },
    getEngProficiencies() {
      return axios.get("/api/getdropdown/3");
    },
    fetchData() {
      axios
        .all([
          this.getImmigrationStatus(),
          this.getGenders(),
          this.getEngProficiencies(),

        ])
        .then((response) => {
          console.log("Data ", response);
          this.immigrationStatuses = response[0].data.items;
          this.genders = response[1].data.items;
          this.engProficiencies = response[2].data.items;

        });
    },
    updateClient() {
      this.saveDisabled = true;
      this.form
        .put("/api/clients/" + this.client_id)
        .then((response) => {
          this.$store.dispatch("confirmSuccess", "Client Saved.");
          this.saveDisabled = false;
          this.close();
        })
        .catch((errors) => {
          this.saveDisabled = false;
          console.log(errors);
        });
    },
    dateFormatter(date) {
      return moment(date).format("YYYY-MM-DD");
    },
    fixDate(event) {
      return moment(event).format("YYYY-MM-DD");
    },
  },
};
</script>
