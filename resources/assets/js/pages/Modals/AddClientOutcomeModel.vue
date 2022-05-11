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
                id="addOutcomeForm"
              >
                <div class="md-layout">
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Outcome Name</label>
                      <md-input
                        v-if="form.user"
                        v-model="form.name"
                        type="text"
                        name="name"
                      ></md-input>
                      <span
                        class="help is-danger"
                        v-if="form.errors.has('name')"
                        v-text="form.errors.get('name')"
                      ></span>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label></label>
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
                      <!-- <span class="help is-danger" v-if="form.errors.has('email')"
                                                v-text="form.errors.get('email')"></span> -->
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

                    <label for="doa">Date of arrival</label>
                    <datepicker
                      :bootstrap-styling="true"
                      :typeable="true"
                      v-model="form.doa"
                      :format="dateFormatter"
                      id="doa"
                    ></datepicker>
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

import Datepicker from "@hokify/vuejs-datepicker";
import moment from "moment";

export default {
  name: 'Testmodal',

//   props: {
//     client_id: "",
//     editing: "",
//   },

  mounted() {
    this.getClient();
    this.fetchData();

  },

  data() {
    return {

      saveDisabled: false,


      form: new Form({
        user: {},
        client_id:this.props.client_id,
        status:'',
        category_id:0,
        outcome:'',
        notes: "",

      }),
    };
  },

  components: {

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

    fetchData() {
      axios
        .all([

        ])
        .then((response) => {
          console.log("Data ", response);
          this.immigrationStatuses = response[0].data.items;


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
