<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p v-if="permissionEdit" class="modal-card-title">Edit Permission</p>
                    <p v-else class="modal-card-title">Add Permission</p>
                    <button class="delete" aria-label="close" @click="close"></button>
                </header>
                <section class="modal-card-body">


                    <form method="post" @submit.prevent="savePermission()" id="addPermissionForm" @input="form.errors.clear($event.target.name)">

                        <label><b>Staff Name</b></label><br>
                        <div v-if="permissionEdit">
                            {{ permissionEdit.user.firstName + " " + permissionEdit.user.lastName }}
                        </div>
                        <div v-else class="control select">
                            <select name="user_id" id="user" v-model="form.user_id">
                                <option selected disabled>Please select a user.</option>
                                <option v-for="user in users" :key="user.id" :value="user.id"> {{ user.firstName + " " + user.lastName }} </option>
                            </select>
                        </div>
                        <span class="help is-danger" v-if="form.errors.has('user_id')"
                        v-text="form.errors.get('user_id')"></span>
                        <br>

                        <label>
                            <b>Clients</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="clients" id="clients" v-model="form.clients">
                                <option selected disabled>Please select a permission.</option>
                                <option value="0">None</option>
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
                                <option value="0">None</option>
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
                                <option value="0">None</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Schedules</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="schedules" id="schedules" v-model="form.schedules">
                                <option selected disabled>Please select a permission.</option>
                                <option value="0">None</option>
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
                                <option value="0">None</option>
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
                                <option value="0">None</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Languages</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="languages" id="languages" v-model="form.languages">
                                <option selected disabled>Please select a permission.</option>
                                <option value="0">None</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Outcomes</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="outcomes" id="outcomes" v-model="form.outcomes">
                                <option selected disabled>Please select a permission.</option>
                                <option value="0">None</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                        <label>
                            <b>Referrals</b>
                        </label>
                        <br>
                        <div class="control select">
                            <select name="referrals" id="referrals" v-model="form.referrals">
                                <option selected disabled>Please select a permission.</option>
                                <option value="0">None</option>
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
                                <option value="0">None</option>
                                <option value="1">Read</option>
                                <option value="2">Write</option>
                                <option value="3">Delete</option>
                            </select>
                        </div>
                        <br>

                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" type="submit" form="addPermissionForm" :disabled="saveDisabled">
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

export default {
  name: "AddPermissionModal",

  props: {
      permissionEdit: ''
  },

  created() {
    if (this.permissionEdit) {
        this.form.editForm(this.form, this.permissionEdit)
    }
     this.fetchData()
  },

  computed: {
  },

  data() {
    return {
        saveDisabled: false,
      users: [],
      form: new Form({
        user_id: '',
        clients: 0,
        facilitators: 0,
        aptemplates: 0,
          schedules: 0,
        reports: 0,
        dropdowns: 0,
        languages: 0,
        permissions: 0,
        outcomes: 0,
        referrals: 0,
      }),
    };
  },
  components: {},

  methods: {
    close() {
      this.$emit("close");
    },
     fetchData() {
      axios.all([this.getPermissionUsers()])
        .then (response => {
          this.users = response[0].data
        })
    },

    getPermissionUsers() {
      return axios.get('/api/user/getPermissionUsers')
    },

    savePermission() {
        this.saveDisabled = true
        if(this.permissionEdit) {
            this.form.put('/api/permission/' + this.permissionEdit.id)
            .then(response => {
                this.close()
                this.saveDisabled = false
            })
            .catch(errors => {
                console.log(errors)
                this.saveDisabled = false
            })
        } else {
            this.form.post('/api/permission')
            .then (response => {
                this.close()
                this.saveDisabled = false
            })
            .catch (error => {
                console.log(error)
                this.saveDisabled = false
            })
        }
    },
  }
};
</script>
