<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Create Client Credentials</p>
                    <button class="delete" aria-label="close" @click="close"></button>
                </header>
                <section class="modal-card-body">
                    <md-card>
                        <md-card-content>
                            <form @keydown="form.errors.clear($event.target.name)">
                                <div class="md-layout">
                                    <div class="md-layout-item md-small-size-100 md-size-50">
                                        <md-field>
                                            <label>First Name</label>
                                            <md-input v-model="form.firstName" type="text" name="firstName"
                                                      id="firstName"></md-input>
                                            <span class="help is-danger" v-if="form.errors.has('firstName')"
                                                  v-text="form.errors.get('firstName')"></span>
                                        </md-field>
                                    </div>
                                    <div class="md-layout-item md-small-size-100 md-size-50">
                                        <md-field>
                                            <label>Last Name</label>
                                            <md-input v-model="form.lastName" type="text" name="lastName"></md-input>
                                            <span class="help is-danger" v-if="form.errors.has('lastName')"
                                                  v-text="form.errors.get('lastName')"></span>
                                        </md-field>
                                    </div>
                                    <!-- <div class="md-layout-item md-small-size-100 md-size-50">
                                        <md-field>
                                            <label>Username</label>
                                            <md-input @focus="generateUsername()" v-model="form.username" type="text"
                                                      name="username">
                                                <span class="help is-danger" v-if="form.errors.has('username')"
                                                      v-text="form.errors.get('username')"></span>
                                            </md-input>
                                        </md-field>
                                    </div> -->
                                    <div class="md-layout-item md-small-size-100 md-size-100">
                                        <md-field>
                                            <label>E-mail Address</label>
                                            <md-input v-model="form.email" type="email" name="email"></md-input>
                                            <span class="help is-danger" v-if="form.errors.has('email')"
                                                  v-text="form.errors.get('email')"></span>
                                        </md-field>
                                    </div>
                                    <!-- <div class="md-layout-item md-small-size-100 md-size-100">
                                        <md-field>
                                            <label>Password</label>
                                            <md-input v-model="form.password" type="password" name="password">
                                            </md-input>
                                            <span class="help is-danger" v-if="form.errors.has('password')"
                                                  v-text="form.errors.get('password')"></span>
                                        </md-field>
                                    </div> -->
                                    <div class="md-layout-item md-small-size-100 md-size-100">
                                        <md-field>
                                            <label>Primary Phone</label>
                                            <md-input v-model="form.phonePrimary" type="tel" name="phonePrimary">
                                            </md-input>
                                            <span class="md-helper-text">Format: 123-456-7890</span>
                                            <span class="help is-danger" v-if="form.errors.has('phonePrimary')"
                                                  v-text="form.errors.get('phonePrimary')"></span>
                                        </md-field>
                                    </div>
                                    <div class="md-layout-item md-small-size-100 md-size-100">
                                        <md-field>
                                            <label>Welcome Centre ID</label>
                                            <md-input v-model="form.wc_id" type="text" name="wc_id"></md-input>
                                            <span class="help is-danger" v-if="form.errors.has('wc_id')"
                                                  v-text="form.errors.get('wc_id')"></span>
                                        </md-field>
                                    </div>
                                </div>
                            </form>
                        </md-card-content>
                    </md-card>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" type="submit" @click="nextForm()" form="addClientCredentialsForm">
                        Next
                    </button>
                    <button class="button is-success" type="submit" @click="finishSubmit()"
                            form="addClientCredentialsForm">Finish
                    </button>
                    <button class="button" @click="close">Cancel</button>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
    import Form from "../../Forms.js"

    export default {
        name: 'AddUserModal',

        props: {},

        mounted() {
            this.initiate()
        },

        components: {},

        data() {
            return {
                form: new Form({
                    firstName: '',
                    lastName: '',
                    wc_id: '',
                    // username: '',
                    email: '',
                    phonePrimary: '',
                    // password: '',
                }),
            }
        },

        methods: {
            close() {
                this.$emit('close')
                this.form.reset()
            },
            initiate() {
                document.getElementById('firstName').focus()
            },
            next(id) {
                this.$emit('next', id);
            },
            // generateUsername() {
            //     let rdmNumber = Math.floor(Math.random() * (999 - 101)) + 101
            //     let firstName = this.form.firstName.split(" ")
            //     let username = firstName[0] + this.form.lastName.charAt(0) + rdmNumber
            //     this.form.username = username.toLowerCase()
            // },
            nextForm() {
                return this.form.post('/api/register')
                    .then(response => {
                        this.next(response.data.id)
                    })
            },
            finishSubmit() {
                return this.form.post('/api/register')
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Client Saved.')
                        this.close()
                    })
                    .catch(error => {
                        console.log(error)
                    })

            },

        }
    }

</script>
