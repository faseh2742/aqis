<template>
	<div >
	
		<chartist
    :type="chartType"
    :data="chartData"
    :options="chartOptions"
     >

</chartist>

        </div>

    </div>
</template>
<script>
	export default {
		name:'ChartCard', 

		 beforeCreate() {
   			//  this.end = new Date();
			// 	let x = new Date();				
			// 	this.start = new Date(x.setMonth(x.getMonth()-1))
			// 	console.log(this.end);
			// 	console.log(this.start);
			// this.$store.dispatch('getClientChartData', {"start":this.start, "end":this.end});
              
  },
  props: {
  // title: String,
  // start: Number,
  // end: Number,
  type: String,
  data: Object,
},
  created(){
   
   //let x = this.$store.state.chartData;
   
  
  },
  computed:{
	chartData: function() {

          return this.data;
        },
    chartType() {
    	return this.type;
    }
  },
	data () {
 	   return {
 	   
      chartOptions: {
           lineSmooth: false
      },
		  start:null,
      end:null,
      clientStatus:'all',
     	all:[],
     	Citizen:[],
     	Immigrant:[],
     	Refugee:[],

    }
  },
		methods:{
			fetchdata(){
				
			},


		}
	}
</script>