<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Add Role</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
         <form method="post" @submit.prevent="onSubmit()" id="NewPermission">
         	<p > 
              <label>
              	<span>Email</span>
                <select required v-model="role.email" >
                  <option  v-for="user in this.$parent.users" >{{user.email}}</option>
                </select>
              </label>
            </p>
            <p v-for="Perm in Object.keys(this.perms)"> 
              <label>
               <select required v-model="role[Perm]" >
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
               <input type="number" v-model="role.Scope"/>
               <span>Scope</span>
              </label>
            </p>
          </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" type="submit" form="NewPermission">Save Role</button>
          <button class="button" @click="close">Cancel</button>
        </footer>
      </div>
    </div>

  </transition>
</template>

<script>
  import Forms from '../../Forms'
export default {
  name: 'addrole',

 

  data() {
    return {

      perms : {"ClientList":1,"ApTemplateList":0,"ApTemplate":0,"ClientControl":0,"Report":0,"Roles":0},
    	role :{},
    }
  },

  methods: {
    close() {
      this.$emit('close');
    },
    onSubmit() {
       
     axios
     .post('api/role/new',  this.role )
     .then(resp => 
      {
       this.close()
      })

    }
  }
}

</script>