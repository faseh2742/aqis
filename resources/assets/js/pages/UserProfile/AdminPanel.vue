<template>
  <div class="content">
    <AddTemplateModal v-if="showModal" @close="closeModal" postUrl="/api/aptemplates"></AddTemplateModal>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Admin Panel</h4>
            <p class="category">Current collection of Facillatator privelleges</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
                <div class="panel-block">
                  <p>
                    <a class="button" @click="openModal">Upgrade A Facillatator </a>
                  </p>
                </div>
                <div class="panel-block">
                  <p class="control has-icons-left">
                    <input class="input is-small" type="text" placeholder="search">
                    <span class="icon is-small is-left">
                      <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                  </p>
                </div>
                <div class="panel-block">
                  <table>
                    <tr>
                      <td><h4><b>Property</b></h4></td>
                      <
                    </tr>
                    <tr v-for="permission in permissions" :key="permissions.id">
                      <td>
                        <span>
                          <router-link :to="{path:'/aptemplates/' + permissions.id}"> {{permissions.id}}</router-link>
                        </span>
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
  import AddTemplateModal from './Modals/Addtemplatemodal.vue'
export default {

  mounted() {
    this.fetchData()
  },
  components: {
    AddTemplateModal
  },
  data () {
    return {
      permissions: [],
      showModal: false,
      notifications: {
        topCenter: false
      }
    }
  },
  methods: {
    fetchData () {
      axios.get('/api/aptemplates')
        .then((res) => {
            this.permissions = res.data
        })
        .catch((err) => {
          console.log(err)
        });
    },
    openModal () {
      this.showModal = true;
    },
    closeModal () {
      this.showModal = false;
      this.fetchData();
    }
  }
}

</script>
