<template>
    <div class="content">

        <div class="login-background">


            <div class="login-content">

                <div class="md-layout text-center">
                    <div class="md-progress-spinner-centre">
                        <md-progress-spinner v-if="loading" md-mode="indeterminate">
                        </md-progress-spinner>
                    </div>
                    <div class="md-layout-item md-size-33 md-medium-size-50 md-small-size-70 md-xsmall-size-100">
                            <form @keydown="form.errors.clear($event.target.name)">
                        <login-card header-color="green">
                            <h4 slot="title" class="title">Log in</h4>
                                <md-field class="md-form-group" slot="inputs">
                                    <md-icon>person</md-icon>
                                    <label>Username...</label>
                                    <md-input v-model="form.username" type="text" name="username"></md-input>
                                    <span class="help is-danger" v-if="form.errors.has('username')"
                                                v-text="form.errors.get('username')"></span>
                                </md-field>
                                <md-field class="md-form-group" slot="inputs">
                                    <md-icon>lock_outline</md-icon>
                                    <label>Password...</label>
                                    <md-input v-model="form.password" @keyup.enter="login()" type="password" name="password"></md-input>
                                    <span class="help is-danger" v-if="form.errors.has('password')"
                                                v-text="form.errors.get('password')"></span>
                                </md-field>
                                <span class="help is-danger" slot="inputs" v-if="form.errors.has()"
                                                v-text="form.errors.get()"></span>
                                <md-button @click="login()" slot="footer" class="md-simple md-success md-lg">
                                    Lets Go
                                </md-button>
                        </login-card>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Form from '../Forms.js'
import LoginCard from "../components/Cards/LoginCard.vue"

export default {
    components: {
        LoginCard
    },

    data() {
        return {
            form: new Form({
                username: '',
                password: '',
            }),
            loading: false,
        }
    },
    methods: {

        login() {
            this.loading = true
            return this.$store.dispatch('login', this.form).then(response => {
                this.loading = false
                this.$router.push('/dashboard')
            }).catch(error => {
                this.loading = false
            })
        },

    },

    computed: {

    },

}
</script>

<style scoped>
.login-background {
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(1, 1, 1, 0.50); /* Black w/ opacity */
}
.login-content {
    /* background-color: #fefefe; */
    margin: 15% auto; /* 10% from the top and centered */
    /* padding: 20px; */
    border: 0px solid #888;
    /* display:inline-block; */
    /* width: 35%; Could be more or less, depending on screen size */
}

</style>
