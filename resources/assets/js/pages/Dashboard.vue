<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">AQIS Database</h3>
            <p class="titleCategory">Welcome to AQIS Database</p>
          </md-card-header>
          <md-card-content>
           <!-- <Charts v-show="this.$store.state.role.group == 'Admin'"></Charts> -->
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
let convert = require('xml-js')
import Charts from './Charts.vue'
export default{
  components: {
    Charts:Charts,
  },
  props: {
    dataBackgroundColor: {
      type: String,
      default: ''
    }
  },
  created() { 
   
    }
}
</script>