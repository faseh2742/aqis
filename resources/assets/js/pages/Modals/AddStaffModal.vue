<template>
    <modal>
        <template v-if="staffEdit" slot="header">Edit Staff</template>
        <template v-else slot="header">Add Staff</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <form method="post" @submit.prevent="saveFacilitator()" @keydown="form.errors.clear($event.target.name)"
            id="addFacilitator">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>First Name</label>
                        <md-input v-model="form.user.firstName" type="text" name="user.firstName"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('user.firstName')"
                            v-text="form.errors.get('user.firstName')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Last Name</label>
                        <md-input v-model="form.user.lastName" type="text" name="user.lastName"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('user.lastName')"
                            v-text="form.errors.get('user.lastName')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Username</label>
                        <md-input @focus="generateUsername()" v-model="form.user.username" type="text" name="username"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('user.username')"
                            v-text="form.errors.get('user.username')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>E-mail Address</label>
                        <md-input v-model="form.user.email" type="email" name="user.email"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('user.email')"
                            v-text="form.errors.get('user.email')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Password</label>
                        <md-input v-model="form.user.password" type="password" name="user.password"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('user.password')"
                            v-text="form.errors.get('user.password')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Primary Phone Number</label>
                        <md-input v-model="form.phonePrimary" type="tel" name="phonePrimary"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('phonePrimary')"
                            v-text="form.errors.get('phonePrimary')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label> Emergency Phone Number</label>
                        <md-input v-model="form.phoneEmerg" type="tel" name="phoneEmerg"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('phoneEmerg')"
                            v-text="form.errors.get('phoneEmerg')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label> Emergency Contact</label>
                        <md-input v-model="form.contactEmerg"  type="text" name="contactEmerg"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('contactEmerg')"
                            v-text="form.errors.get('contactEmerg')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Personal Phone Number</label>
                        <md-input v-model="form.phonePersonal" type="tel" name="phonePersonal"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('phonePersonal')"
                            v-text="form.errors.get('phonePersonal')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="position">Position</label>
                            <select class="select md-menu md-select" v-model="form.position" name="position"
                                id="position">
                                <option selected disabled>Please select the position</option>
                                <option>AQIS Facilitator</option>
                                <option>Administrative Assistant</option>
                                <option>Program Manager</option>
                            </select>
                              <span class="help is-danger" v-if="form.errors.has('position')"
                            v-text="form.errors.get('position')"></span>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="gender">Gender</label>
                            <select class="select md-menu md-select" v-model="form.gender" name="gender" id="gender">
                                <option v-for="(gender, index) in genders.items" :key="index" :value="gender.item">
                                    {{ gender.item }} </option>
                            </select>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Street address</label>
                        <md-input v-model="form.streetAddress" type="text" name="streetAddress"></md-input>
                        <span class="help is-danger" v-if="form.errors.has('streetAddress')"
                            v-text="form.errors.get('streetAddress')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>City</label>
<!--                        <md-input v-model="form.city" type="text" name="city"></md-input>-->
                        <city-list v-model="form.city" name="city">
                        </city-list>
                        <span class="help is-danger" v-if="form.errors.has('city')"
                            v-text="form.errors.get('city')"></span>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="province">Province</label>
                            <select class="select md-menu md-select" v-model="form.province" name="province"
                                id="province">
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
                        <md-input v-model="form.postalCode" type="text" name="postalCode"></md-input>
                        <span class="md-helper-text">Format: A1A 1A1</span>
                        <span class="help is-danger" v-if="form.errors.has('postalCode')"
                            v-text="form.errors.get('postalCode')"></span>
                    </md-field>
                </div>

                <div v-if="staffEdit" class="md-layout-item md-small-size-100 md-size-100">
                    <label for="active">Active: &nbsp;</label>
                    <md-radio name="active" v-model="form.user.active" :value="0"> No </md-radio>
                    <md-radio name="active" v-model="form.user.active" :value="1" class="md-primary"> Yes </md-radio>
                </div>

            </div>
        </form>
        <template slot="footer">
            <button class="button is-success" type="submit" form="addFacilitator" :disabled="saveDisabled">
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
import CityList from "../CityList";

export default {
    name: 'addFacilitator',

    props: {
        staffEdit: '',
    },

    created() {
      if (this.staffEdit) {
            this.form.editForm(this.form, this.staffEdit)
        }
    },
  

    computed: {
        genders() {
            let genders = this.$store.state.dropdowns.find(function (el) {
                return el.name === "Gender"
            })
            return genders
        },

    },

    data() {
        return {
            saveDisabled: false,
            form: new Form({
              user:{
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                username: '',
              },
                phonePrimary: '',
                phoneEmerg: '',
                position: '',
                gender: '',
                streetAddress: '',
                city: '',
                province: '',
                postalCode: '',
                phonePersonal: '',
                contactEmerg: '',
            }),

        }
    },

    components: {
        CityList
    },

    methods: {
        close() {
            this.$emit('close')
            this.form.reset()
        },
        saveFacilitator() {
            this.saveDisabled = true
            if (this.staffEdit) {
                this.form.put('api/staff/' + this.staffEdit.id)
                    .then(response => {
                        this.saveDisabled = false
                      //  this.$store.state.facilitators.push(response)
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            } else {
                this.form.post('/api/register/staff')
                    .then(response => {
                        this.saveDisabled = false
                       // this.$store.state.facilitators.push(response)
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            }
        },
        generateUsername() {

            if( this.form.user.firstName == "" && this.form.user.lastName == ""){
                return;
            }
            let firstName = this.form.user.firstName.split(" ")
            let lastName = this.form.user.lastName.split(" ")
            let username = firstName[0] + '.' + lastName[0]
            this.form.user.username = username.toLowerCase()
        },
    }
}

</script>
