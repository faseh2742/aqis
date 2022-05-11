<template>
	<div class="columns">
  <div class="column ">
    
  </div>
  <div class="column is-four-fifths ">
  
  	<h1 class="title is-1"> Client Registration Report</h1>
 
 <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                    <tr>
                      <th>Client ID</th>
                      <th>Name</th>
                      <th>E-mail Address</th>
                      <th>Phone Number</th>
                    </tr>
                    <tr v-for="client in clients" :key="client.id">
                      <td>{{ client.client_id }}</td>
                      <td>{{ client.first_name + " " + client.last_name }}</td>
                      <td>{{ client.email }}</td>
                      <td>{{ client.phone_primary }}</td>
                    </tr>
                  </table>
              </div>
                   <div class="column">
   
  </div>
</div>

</template>


<script>
export default {

  computed: {
   clients () {
      return this.$store.state.reportResponse
    },
  },
  
}

</script>
