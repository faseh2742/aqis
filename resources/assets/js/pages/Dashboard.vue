<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <!-- <h3 class="title">AQIS Database</h3> -->
            <h3 class="title">ACTIVITY</h3>
            <p class="titleCategory">User Activity</p>
          </md-card-header>
          <md-card-content>
            <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Updated By</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="Activity in Activities" :key="Activity.id">
                    <th scope="row">{{Activity.description}}</th>
                    <td>{{Activity.created_at}}</td>
                    <td>{{Activity.user.username}}</td>

                  </tr>

                </tbody>
              </table>
            </div>
          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Events</h3>
            <p class="titleCategory">Upcoming Events</p>
          </md-card-header>
          <md-card-content>
            <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
            <div>
              <calendar> </calendar>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
    <div class="md-layout">
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Meetings</h3>
            <p class="titleCategory">Upcoming Meetings</p>
          </md-card-header>
          <md-card-content>
            <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Program</th>
                    <th scope="col">Service Delivery</th>
                    <th scope="col">Meeting Link</th>
                    <th scope="col">Date</th>
                    <th scope="col">Email</th>
                  </tr>
                </thead>
                <tbody>
                <tr v-for="Meeting in Meetings" :key="Meeting.id">
                    <th scope="row">{{Meeting.programName}}</th>
                    <td>{{Meeting.serviceDelivery}}</td>
                    <td>{{Meeting.meetingLink}}</td>
                    <td>{{Meeting.date}}</td>
                    <td>{{Meeting.user.username}}</td>

                  </tr>
                </tbody>
              </table>
            </div>
          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">NOC</h3>
            <p class="titleCategory">Top 10 NOCs</p>
          </md-card-header>
          <md-card-content>
            <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
    <div class="md-layout">
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Referrals</h3>
            <p class="titleCategory">Top 10 Referrals</p>
          </md-card-header>
          <md-card-content>
            <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Community</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="Referral in Referrals" :key="Referral.id">
                    <th scope="row">{{Referral.name}}</th>
                    <td>{{Referral.community}}</td>

                  </tr>

                </tbody>
              </table>
            </div>
          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-size-50">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Statistics</h3>
            <p class="titleCategory">Quick Stat</p>
          </md-card-header>
          <md-card-content>
            <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts>
            <div>
              <!-- <Charts></Charts> -->
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
let convert = require("xml-js");
import Charts from "./Charts.vue";
import calendar from '../components/Calendar.vue';
export default {
  components: {
     Charts: Charts,
    calendar,
  },
  props: {
    dataBackgroundColor: {
      type: String,
      default: "",
    },
  },
     data() {
          return {
               Referrals: [],
                Nocs: [],
                Meetings: [],
                Activities: [],
                loading: false,

            }

        },
  created() {
      this.getReferrals();
       this.getMeetings()
        this.getActivities()
         this.getNocs()
  },
  computed() {},
     methods: {
            getReferrals() {
                this.loading = true
                axios.get('/api/getReferrals')
                    .then(response => {
                        this.loading = false
                        this.Referrals = response.data
                        console.log('Referrals', this.Referrals)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
             getNocs() {
                this.loading = true
                axios.get('/api/getNocs')
                    .then(response => {
                        this.loading = false
                        this.Nocs = response.data
                         console.log('Nocs', response.data)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            getMeetings() {
                this.loading = true
                axios.get('/api/getMeetings')
                    .then(response => {
                        this.loading = false
                        this.Meetings = response.data.data
                         console.log('Meetings', response.data.data)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            getActivities() {
                this.loading = true
                axios.get('/api/getActivities')
                    .then(response => {
                        this.loading = false
                        this.Activities = response.data.data
                         console.log('Activities', response.data)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
        }
}
</script>
