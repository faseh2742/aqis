<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Edit Permission</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        
        <!-- <md-progress-spinner v-show="loading" class="md-progress-spinner-centre" md-mode="indeterminate"></md-progress-spinner> -->
        <section class="modal-card-body">
          <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>
          <form method="post" @submit.prevent="savePermission()" id="editPermissionForm">

                        <md-field>
                          <label>Staff Name</label>
                          <md-input v-if="user" v-model="user.name" type="text" disabled></md-input>
                        </md-field>

                        <label>
                            <b>Clients</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="clients" id="clients" v-model="form.clients">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Facilitators</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="facilitators" id="facilitators" v-model="form.facilitators">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Action Plan Templates</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="aptemplates" id="aptemplates" v-model="form.aptemplates">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Reports</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="reports" id="reports" v-model="form.reports">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Dropdowns</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="dropdowns" id="dropdowns" v-model="form.dropdowns">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>User Permissions</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="permissions" id="permissions" v-model="form.permissions">
                                <option selected disabled>Please select a permission.</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                    </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" type="submit" form="editPermissionForm">
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
import Form from '../../Forms'

export default {
  name: "EditPermissionModal",

  props: {
      permission_id: '',
  },

  created() {
    this.fetchData()
    .then (response => {
      this.loading = false
    })
  },

  computed: {
  },

  data() {
    return {
      loading: true,
      user: {},
      form: new Form({
        user_id: '',
        clients: '',
        facilitators: '',
        aptemplates: '',
        reports: '',
        dropdowns: '',
        permissions: '',
      }),
    }
  },

  components: {},

  methods: {
    close() {
      this.$emit("close")
    },
    getPermission(id) {
      return axios.get("/api/permission/" + id);
    },
    fetchData() {
      return axios.all([this.getPermission(this.permission_id)])
      .then(response => {
        this.user = response[0].data.user[0]
        for (let field in response[0].data) {
          this.form[field] = response[0].data[field]
          }
      })
    },
    savePermission() {
      this.form.put('/api/permission/' + this.permission_id)
      .then (response => {
        this.close()
      })
      .catch (error => {
        console.log(error)
      })
    }
  }
}
</script>