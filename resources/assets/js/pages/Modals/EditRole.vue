<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Edit Role</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
         <form method="post" @submit.prevent="onSubmit()" id="PermissionUpdate">

            <p v-for="Perm in Object.keys(this.perms)"> 
              <label>
               <select  v-model="$parent.role[Perm]" >
                  <option  selected value ='none'>none</option>
                  <option  value ='read'>read</option>
                  <option  value ='write'>write</option>
                  <option  value ='destroy'>destroy</option>
                </select>
               <span>{{Perm}}</span>
              </label>
            </p>
            <p > 
              <label>
               <input type="number" v-model="$parent.role.Scope"/>
               <span>Scope</span>
              </label>
            </p>
          </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" style="justify-content: space-between;" type="submit" form="PermissionUpdate">Save Role</button>
           <button v-show="deleteRole" class="button is-danger" @click="destroyRole()">Delete Role</button>
        </footer>
      </div>
    </div>

  </transition>
</template>

<script>
  import Forms from '../../Forms'
export default {
  name: 'editrole',

 

  data() {
    return {    
            perms : {"ClientList":1,"ApTemplateList":0,"ApTemplate":0,"ClientControl":0,"Report":0,"Roles":0},
      addMeetingForm: new Forms({
        client_id: '',
        noc: '',
        job_title: '',
        field: '',
        experience_years: '',
        country: ''
      })
    }
  },
  computed: {
    deleteRole () {
      return ['destroy'].indexOf(this.$store.state.role.Roles) > -1;
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    destroyRole() {
       console.log(this.$parent)
     axios
     .post('api/role/delete' ,  this.$parent.role)
     .then(resp => 
      {
       this.close();
      })

    },
    onSubmit() {
      
     axios
     .post('api/role/edit' ,  this.$parent.role )
     .then(resp => 
      {
     // this.close();
      })

    }
  }
}

</script>