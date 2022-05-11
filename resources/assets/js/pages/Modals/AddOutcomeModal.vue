<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Add Outcome</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
          <form method="post" @submit.prevent="saveItem()" id="addOutcomeForm">
            <div class="md-layout">
              <label class="md-layout-item md-size-15 md-form-label">
                Outcome
              </label>
              <div class="md-layout-item">
                <md-field>
                  <md-input v-model="outcome" type="text"></md-input>
                </md-field>
                <span class="help is-danger"></span>
              </div>
            </div>
            <div class="md-layout">
              <label class="md-layout-item md-size-15 md-form-label">
                Status
              </label>
              <div class="md-layout-item">
                <md-field>
                  <select
                    class="select md-menu md-select"
                    v-model="status"
                    id="status"
                  >
                    <option value="Not Complete">Not Complete</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </md-field>
                <span class="help is-danger"></span>
              </div>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-field>
                <label>Notes</label>
                <md-textarea v-model="notes"></md-textarea>
              </md-field>
            </div>
          </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" type="submit" form="addOutcomeForm">
            <span>Save</span>
            <span class="icon is-small">
              <i class="far fa-save"></i>
            </span>
          </button>
          <button class="button" @click="close">Cancel</button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
import Form from "../../Forms.js";
import { mapFields } from "vuex-map-fields";

export default {
  name: "AddOutcomeModal",

  props: ["client_id", "editing"],

  created() {},

  mounted() {
    this.fetchData();
    console.log("Dropdown", this.outcomeStatuses);
  },

  data() {
    return {
      users: [],
      outcomeStatuses: [],

      client_id: this.props.client_id,
      category_id: 1,
      outcome: "",
      status: "",
      notes: "",
    };
  },
  components: {},

  methods: {
    close() {
      this.$emit("close");
    },
    saveItem() {
      let fd = new FormData();
      fd.append("outcome", this.outcome);
      fd.append("status", this.status);
      fd.append("notes", this.notes);
      fd.append("client_id", this.client_id);
      fd.append("category_id", 1);
      return axios
        .post("/api/outcomes", fd)
        .then((response) => {
          this.close();
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getOutcomeStatuses() {
      return axios.get("/api/getdropdown/14");
    },
    fetchData() {
      axios.all([this.getOutcomeStatuses()]).then((response) => {
        console.log("Data ", response[0].data.items);
        this.outcomeStatuses = response[0].data.items;
        console.log("drop", this.outcomeStatuses);
      });
    },
  },
};
</script>
