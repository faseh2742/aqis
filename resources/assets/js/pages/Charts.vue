<template>
  <div>
        <div v-if="ClientReg">
          <h1 class="control has-icons-left"><b>Client Registrition from {{start.toString().substring(0,10)}} to {{end.toString().substring(0,10)}} </b></h1>
          
            <ChartCard type="Bar" :data="this.$store.state.chartData.ClientReg"></ChartCard>
          
        </div>
         <div v-if="ClientMeetings">
          <h1 class="control has-icons-left"><b>Client Meetings from {{start.toString().substring(0,10)}} to {{end.toString().substring(0,10)}} </b></h1>
          
            <ChartCard type="Line" :data="this.$store.state.chartData.ClientMeet"></ChartCard>
          

        </div>
        <div v-if="DeptMeetings">
          <h1 class="control has-icons-left"><b>Department Meetings from {{start.toString().substring(0,10)}} to {{end.toString().substring(0,10)}} </b></h1>
          
            <ChartCard type="Bar" :data="this.$store.state.chartData.DeptMeetings"></ChartCard>
          

        </div>
   </div>
</template>

<script>
 
  import ChartCard from './ChartCard.vue'

export default {
	name:'Charts',
  beforeMount() {
  	this.end = new Date();
    let x = new Date();             
    this.start = new Date(x.setMonth(x.getMonth()-1))
    	let self = this;
			this.$store.dispatch('getChartData', {"url":"ClientReg"}).then(response => { self.ClientReg = true });
      this.$store.dispatch('getChartData', {"url":"ClientMeet"}).then(response => 
        { 
          self.ClientMeetings = true;
      });
        this.$store.dispatch('getChartData', {"url":"DeptMeetings"}).then(response => 
        { 
          self.DeptMeetings = true;
      });


  },
  components: {
    ChartCard:ChartCard,
  },
  data () {
    return {
      end:null,
      start:null,
      ClientReg:false,
      ClientMeetings:false,
      FacilMeetings:false,
      DeptMeetings: false,
          }
  },
 

  
}

</script>