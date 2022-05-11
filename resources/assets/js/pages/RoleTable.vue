<template>
  <div class="content">
      <addrole v-show="AddRole" @close="closeModal()"></addrole>
      <editrole v-show="EditRole" @close='closeModal()'></editrole>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Role List</h4>
            <p class="category">Current list of Roles</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
                    <div class="panel-block">
                  <p>
                      <a v-show="writeToRole" class="button is-link is-active" @click="addrole()">
                        <span> Add Role</span>
                      <span class="icon is-small">
                        <i class="fas fa-plus-square"></i>
                      </span>
                    </a>
                  </p>
                </div>
                <div class="panel-block">
                  <!-- <div class="container is-fluid"> -->

                      <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                              <tr>
                                  <th v-for="title in properties">{{title}}</th>
                                  
                              </tr>
                              <tr v-for="role in this.$store.state.roleTable" >
                              
                              <td @click="edit(role.id)" v-for="prop in properties">
                                  
                                  <p v-if="(['id','email','group'].indexOf(prop) == -1)">
                                    {{role[prop]}}
                                  </p>
                                  <p v-else > {{role[prop]}}</p>
                                  
                                   
                               
                              </td>  
                              </tr>
                      </table>

                </div>
              </nav>
          </md-card-content>
        </md-card>
      </div>
    </div>

  </div>
</template>

<script>
  import addrole from './Modals/AddRole.vue'
  import editrole from './Modals/EditRole.vue'
export default {
  components: {
    addrole ,
    editrole
  },
  computed: {
    writeToRole () {
      return ['write','destroy'].indexOf(this.$store.state.role.Roles) > -1;
    }, 
    },
  
 data () {
    return {
      properties: ["id","group","email","ClientList","ApTemplateList","ApTemplate","ClientControl","Report","Roles","Scope"],
      roles :{},
      role :{},
      AddRole : false,
      EditRole : false,
      users : [],
      }
    },
    created() {
      this.fetchData();
      axios.get('api/user')
        .then(resp => {
          this.users = resp.data;
      });
    },
 
    methods :{
      edit(num){ 
        if( ['write','destroy'].indexOf(this.$store.state.role.Roles) == -1)
          return null
        this.role = this.$store.state.roleTable.find(x => x.id == num)
        this.EditRole = true },
      addrole(){
        
        this.AddRole = true
      },
      closeModal () {
      location.reload();
      },
      fetchData()  {

      this.roles  = this.$store.dispatch('getRoles')
      
    },
  },

  
}

</script>