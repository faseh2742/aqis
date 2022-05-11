<template>
  <div class="content">
    <AddPermissionModal v-if="showPermissionModal" @close="closeModal('permissionModal')"></AddPermissionModal>
    <EditPermissionModal v-if="showEditPermissionModal" :permission_id="permission_id" @close="closeModal('editPermissionModal')"></EditPermissionModal>
    <div class="md-layout">
      <md-progress-spinner v-if="loading" class="md-progress-spinner-centre" md-mode="indeterminate"></md-progress-spinner>
      <div class="md-layout-item md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">User Permissions</h3>
            <p class="titleCategory">Customized permissions for users.</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
                <div v-if="canWrite()" class="panel-block">
                  <p>
                    <a class="button is-link is-active" @click="openModal('permissionModal')">
                      <span>Add Permission</span>
                      <span class="icon is-small">
                        <i class="fas fa-user-plus"></i>
                      </span>
                    </a>
                  </p>
                </div>
                <div class="panel-block">
                  <p class="control has-icons-left">
                    <input class="input is-small" type="text" name="string" placeholder="search" v-model="search" @keyup="searchPermission">
                    <span class="icon is-small is-left">
                      <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                  </p>
                </div>
                <div class="panel-block">

                  <md-table v-model="permissions" class="md-layout-item md-medium-size-100 md-size-100">
                      <md-table-row slot="md-table-row" slot-scope="{ item }">
                          <md-table-cell md-label="Name"> {{ item.user.firstName + " " + item.user.LastName }} </md-table-cell>
                          <md-table-cell md-label="E-mail Address"> {{ item.user.email }} </md-table-cell>
                          <md-table-cell md-label="Actions">
                              <md-button class="md-just-icon md-success" @click="openModal('editPermissionModal', item.id)">
                                  <md-icon>edit</md-icon>
                              </md-button>
                              <md-button class="md-just-icon md-danger">
                                  <md-icon>close</md-icon>
                              </md-button>
                          </md-table-cell>
                      </md-table-row>
                  </md-table>


                </div>
                <div class="panel-block paginate" align="right">
                      <pagination
                        :firstPage= "firstPage"
                        :previousPage= "previousPage"
                        :currentPage= "currentPage"
                        :nextPage= "nextPage"
                        :lastPage= "lastPage"
                        :totalPages= "totalPages"
                        :maxVisibleButtons= "3"
                        :url= "postUrl"
                        @pageChanged="onPageChange($event)"
                      ></pagination>
                </div>
              </nav>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>

  import AddPermissionModal from './Modals/AddPermissionModal.vue'
  import EditPermissionModal from './Modals/EditPermissionModal.vue'
  import Pagination from './pagination.vue'

export default {
  // beforeCreate() {
  //   this.loading = true
  // },
  created() {
    this.fetchData()
    .then (response => {
      this.loading = false
    })

  },
  components: { 
    AddPermissionModal,
    EditPermissionModal,
    Pagination,
  },
  data () {
    return {
      loading: true,
      permissions: [],
      permission_id: '',
      showPermissionModal: false,
      showEditPermissionModal: false,
      search: '',
      clientsPerPage: [],
      firstPage: '',
      previousPage: '',
      currentPage: '',
      nextPage: '',
      lastPage: '',
      totalPages: '',
      postUrl: '/api/permission',
    }
  },
  computed: {
  },
  methods: {
    canWrite() {
      if (this.$store.state.user.role === 'Admin') {
        return true
      } else if (this.$store.state.user.permission.permissions >=2) {
        return true
      } else {
        return false
      }
    },
    canDelete() {
      if (this.$store.state.user.role === 'Admin') {
        return true
      } else if (this.$store.state.user.permission.permissions == 3) {
        return true
      } else {
        return false
      }
    },
    getPermissions () {
      return axios.get('/api/permission')
    },
    fetchData () {
      return axios.all([this.getPermissions()])
      .then (response => {
        if (response != null) {
          this.permissions = response[0].data.data
          console.log(this.permissions)
          this.firstPage= response[0].data.first_page_url
          this.previousPage= response[0].data.prev_page_url
          this.currentPage= response[0].data.current_page
          this.nextPage= response[0].data.next_page_url
          this.lastPage= response[0].data.last_page_url
          this.totalPages= response[0].data.last_page
        }
      })

    },
    openModal (name, id) {
      switch (name) {
        case 'permissionModal':
        this.showPermissionModal = true
        break;
        case 'editPermissionModal':
        this.permission_id= id
        this.showEditPermissionModal = true
        break;
      }
    },
    closeModal (name) {
      switch (name) {
        case 'permissionModal':
        this.showPermissionModal = false
        this.fetchData()
        break;
        case 'editPermissionModal':
        this.showEditPermissionModal = false
        this.fetchData()
        break;
      }
    },
    deletePermission (index, id) {
      axios.delete('/api/permission/' + id)
      this.$store.state.permissions.splice(index, 1)

    },
    onPageChange (value) {
      this.$store.dispatch('getPermissions', value)
      .then (response => {
        this.firstPage= response[0].data.first_page_url
        this.previousPage= response[0].data.prev_page_url
        this.currentPage= response[0].data.current_page
        this.nextPage= response[0].data.next_page_url
        this.lastPage= response[0].data.last_page_url
        this.totalPages= response[0].data.last_page
      })
    },
    searchPermission () {
      if (this.search != "") {
        this.$store.dispatch('searchPermissions', this.search)
        .then(response => {
          this.$store.commit('SET_PERMISSIONS', response)
          })
      } else {
        this.fetchData()
      }

    }
  },
}

</script>