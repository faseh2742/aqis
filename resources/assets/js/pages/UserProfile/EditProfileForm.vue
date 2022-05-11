<template>
  <form method="put" @keydown="form.errors.clear($event.target.name)">
    <md-card>
      <md-card-header data-background-color="green">
        <h4 class="title">Edit Profile</h4>
        <p class="category">User profile</p>
      </md-card-header>

      <md-card-content>
        <div class="md-layout">
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Username</label>
              <md-input v-model="form.user.username" type="text" disabled></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Email Address</label>
              <md-input v-model="form.user.email" type="email" name="user.email"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('user.email')"
                v-text="form.errors.get('user.email')"
              ></span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>First Name</label>
              <md-input v-model="form.user.firstName" type="text" name="user.firstName"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('user.firstName')"
                v-text="form.errors.get('user.firstName')"
              ></span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Last Name</label>
              <md-input v-model="form.user.lastName" type="text" name="user.lastName"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('user.lastName')"
                v-text="form.errors.get('user.lastName')"
              ></span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Primary Phone</label>
              <md-input v-model="form.phonePrimary" type="tel"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('phonePrimary')"
                v-text="form.errors.get('phonePrimary')"
              ></span>
            </md-field>
          </div>

          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Personal Phone</label>
              <md-input v-model="form.phonePersonal" type="tel"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('phonePersonal')"
                v-text="form.errors.get('phonePersonal')"
              ></span>
            </md-field>
          </div>

          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Emergency Phone</label>
              <md-input v-model="form.phoneEmerg" type="tel"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('phoneEmerg')"
                v-text="form.errors.get('phoneEmerg')"
              ></span>
            </md-field>
          </div>

           <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Emergency Contact</label>
              <md-input v-model="form.contactEmerg" type="text" name="contactEmerg"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('contactEmerg')"
                v-text="form.errors.get('contactEmerg')"
              ></span>
            </md-field>
          </div>

          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Street Address</label>
              <md-input v-model="form.streetAddress" type="text"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('streetAddress')"
                v-text="form.errors.get('streetAddress')"
              ></span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>City</label>
              <md-input v-model="form.city" type="text"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('city')"
                v-text="form.errors.get('city')"
              ></span>
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
              <md-input v-model="form.postalCode" type="text"></md-input>
              <span
                class="help is-danger"
                v-if="form.errors.has('postalCode')"
                v-text="form.errors.get('postalCode')"
              ></span>
            </md-field>
          </div>
           <div class="md-layout-item md-size-100 text-right">
            <md-button class="md-raised md-success" @click="updateUser">Update Profile</md-button>
            <md-button class="md-raised md-success" @click.prevent="togglUpdatePassword">Update Password</md-button>
          </div>
          <div v-if="showUpdatePassword" class="md-layout-item md-small-size-100 md-size-100">
          <!-- <div class="md-layout-item md-small">
            <p class="category">Update Password</p>
          </div> -->
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Current Password</label>
              <md-input
                v-model="form.currentPassword"
                type="password"
                name="currentPassword"
              ></md-input>
            </md-field>
            <span
              class="help is-danger"
              v-if="form.errors.has('currentPassword')"
              v-text="form.errors.get('currentPassword')"
            ></span>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>New Password</label>
              <md-input v-model="form.newPassword" type="password" name="newPassword"></md-input>
            </md-field>
            <span
              class="help is-danger"
              v-if="form.errors.has('newPassword')"
              v-text="form.errors.get('newPassword')"
            ></span>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>Confirm New Password</label>
              <md-input
                v-model="form.newPassword_confirmation"
                type="password"
                name="newPassword_confirmation"
              ></md-input>
            </md-field>
            <span
              class="help is-danger"
              v-if="form.errors.has('newPassword_confirmation')"
              v-text="form.errors.get('newPassword_confirmation')"
            ></span>
          </div>
          <div class="md-layout-item md-size-100 text-right">
            <md-button class="md-raised md-success" @click="updatePassword">Save Password</md-button>
          </div>
          </div>
        </div>
      </md-card-content>
    </md-card>
  </form>
</template>
<script>
import Form from "../../Forms";
import Swal from "sweetalert2";
import { log } from 'util';

export default {
  name: "edit-profile-form",
  props: {},

  created() {
    this.fetchData();
  },
  data() {
    return {
      showUpdatePassword: false,
      form: new Form({
        user: {
          firstName: "",
          lastName: "",
          username: "",
          email: ""
        },
        phonePrimary: "",
        phoneEmerg: "",
        streetAddress: "",
        city: "",
        province: "",
        postalCode: "",
        currentPassword: "",
        newPassword: "",
        newPassword_confirmation: "",
        phonePersonal: "",
        contactEmerg: "",
      }),

      id: ""
    };
  },
  methods: {
    getStaff() {
      return axios.get("/api/user/getAuthenticatedStaff");
    },

    fetchData() {
      axios
        .all([this.getStaff()])
        .then(response => {
          this.id = response[0].data.user["id"];
          for (let field in response[0].data) {
            this.form[field] = response[0].data[field];
          }
        })

        .catch(errors => {
          console.log(errors);
        });
    },

    updateUser() {
      this.form
        .put("api/staff/updateProfile/" + this.id)
        .then(response => {
          this.fetchData();
          Swal.fire({
            title: "Profile Updated!",
            type: "success",
            confirmButtonClass: "md-button md-success",
            buttonsStyling: false
          });
        })
        .catch(errors => {
          console.log(errors);
        });
    },

    updatePassword() {
      this.form
        .put("api/password/update")
        .then(response => {
          console.log(response);
          response = response.data;

          Swal.fire({
            title: "Password Updated!",
            type: "success",
            confirmButtonClass: "md-button md-success",
            buttonsStyling: false
          });
          this.fetchData();
        })
        .catch(errors => {
          console.log(errors);
        });
    },
     togglUpdatePassword() {
      this.showUpdatePassword = !this.showUpdatePassword;
    }
  }
};
</script>
<style>
</style>
