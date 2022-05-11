<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Registration</h4>
            <p class="category">Enter the required information below to create your account.</p>
          </md-card-header>
          <md-card-content>
            <form method="post" @submit.prevent="onSubmit()" id="loginForm">
              <label><b>Username</b></label><br>
              <div class="control">
                <input class="input" type="text" v-model="newClientForm.username">
              </div><br>
              <label><b>Email</b></label><br>
              <div class="control">
                <input class="input" type="email" v-model="newClientForm.email">
              </div><br>
              <label><b>Password</b></label><br>
              <div class="control">
                <input class="input" type="password" v-model="newClientForm.password">
              </div><br>
              <label><b>Confirm Password</b></label><br>
              <div class="control">
                <input class="input" type="password" v-model="confirm">
              </div><br>
              <button class="button is-success" type="submit">Register</button>
            </form>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import Forms from '../Forms'
export default{

  created() {
    axios.interceptors.request.eject(this.$store.state.interceptors);
  },

  data() {
    return {
      newClientForm: new Forms({

        username: '',
        email: '',
        password: ''
      }),
      confirm: ''
    }
  },

  methods: {
    onSubmit() {
      let url = '/api/clients';
      if (this.newClientForm.password == this.confirm) {
        this.newClientForm.post(url);
        console.log('It worked!');
      }
      else {
        console.log('Make sure passwords match.')
      }
    },
  }
}
</script>