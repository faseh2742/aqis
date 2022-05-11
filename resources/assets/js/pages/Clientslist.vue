<template>
    <div class="content">
        <AddClientModal :client_id="client_id" v-if="showClientModal" @close="closeModal('clientModal')"></AddClientModal>
        <AddUserModal v-if="showUserModal" @close="closeModal('userModal')" @next="nextForm"></AddUserModal>
        <div class="md-layout">
            <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>
            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="green">
                        <h3 class="title">Clients List</h3>
                        <p class="titleCategory">List of current clients</p>
                    </md-card-header>
                    <md-card-content>
                        <nav class="panel">
                            <div v-show="$root.canWrite('clients')" class="panel-block">
                                <p>
                                    <a class="button is-link is-active" @click="openModal('userModal')">
                                        <span>Add Client</span>
                                        <span class="icon is-small">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div class="panel-block">
                                <p class="control has-icons-left">
                                    <input class="input is-small" type="text" name="string" placeholder="search"
                                        v-model="search" @keyup="searchClient">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="panel-block">
                                <!-- <div class="container is-fluid"> -->

                                <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                                    <tr>
                                        <th>Welcome Centre ID</th>
                                        <th>Name</th>
                                        <th>E-mail Address</th>
                                        <th>Phone Number</th>

                                    </tr>
                                     <tr v-if="noData"><td colspan="4">No Data Found</td></tr>
                                    <tr v-else v-for="client in clients" :key="client.id">
                                        <td>
                                            <router-link :to="/clients/+client.id">{{ client.wc_id }}</router-link>
                                        </td>
                                        <td>
                                            <router-link :to="/clients/+client.id">
                                                {{ client.user.firstName + " " + client.user.lastName }}</router-link>
                                        </td>
                                        <td>
                                            <router-link :to="/clients/+client.id">{{ client.user.email }}</router-link>
                                        </td>
                                        <td>
                                            <router-link :to="/clients/+client.id">{{ phoneFormater.FormatPhone(client.phonePrimary) }}
                                            </router-link>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-block paginate" align="right">
                                <pagination :firstPage="firstPage" :previousPage="previousPage"
                                    :currentPage="currentPage" :nextPage="nextPage" :lastPage="lastPage"
                                    :totalPages="totalPages" :maxVisibleButtons="3" :url="postUrl"
                                    @pageChanged="onPageChange($event)"></pagination>
                            </div>
                        </nav>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
  import AddClientModal from './Modals/AddClientModal.vue'
  import AddUserModal from './Modals/AddUserModal.vue'
  import Pagination from './pagination.vue'
  import PhoneFormater from '../phoneNumberFormat'

export default {
  created() {
    if( this.$store.state.clientsLastPage ){
      this.onPageChange(this.$store.state.clientsLastPage);
      this.loading = false;
    } else {
      this.fetchData()
      .then (response => {
        console.log('first')
        this.loading = false
      })
    }
  },
  components: {
    AddClientModal,
    AddUserModal,
    Pagination,
  },
  data () {
    return {
      loading: true,
      client_id: '',
      search: '',
      clientsPerPage: [],
      firstPage: '',
      previousPage: '',
      currentPage: '',
      nextPage: '',
      lastPage: '',
      totalPages: '',
      postUrl: '/api/clients',
      showUserModal: false,
      showClientModal: false,
      noData:false,
      phoneFormater: new PhoneFormater(),
    }
  },
  computed: {
    clients () {
      return this.$store.state.clients
    },
    clientsLastPage () {
      return this.$store.state.clientsLastPage
    }
  },
  methods: {
    fetchData () {
      return this.$store.dispatch('getClients', this.postUrl)
      .then (response => {
        console.log(response);
        this.firstPage= response.first_page_url
        this.previousPage= response.prev_page_url
        this.currentPage= response.current_page
        this.nextPage= response.next_page_url
        this.lastPage= response.last_page_url
        this.totalPages= response.last_page
      })

    },
    nextForm: function(id) {
      this.client_id = id
      this.showUserModal = false
      this.showClientModal = true
    },
    openModal (name) {

      switch (name) {
        case 'clientModal':
        this.$store.commit('OPEN_CLIENT_MODAL');
        break;
        case 'userModal':
        this.showUserModal = true;
        break;
      }
    },
    closeModal (name) {

          this.postUrl=this.currentPage
      switch (name) {
        case 'clientModal':
        this.showClientModal = false;
        this.fetchData()
        break;
        case 'userModal':
        this.showUserModal = false
        this.fetchData()
        break;
      }
    },
    onPageChange (value) {
      this.$store.dispatch('getClients', value)
      .then (response => {
        console.log('test');
        this.firstPage= response.first_page_url
        this.previousPage= response.prev_page_url
        this.currentPage= response.current_page
        this.nextPage= response.next_page_url
        this.lastPage= response.last_page_url
        this.totalPages= response.last_page
      })
      this.$store.commit('SET_CLIENT_LAST_PAGE', value);
    },
    searchClient () {
      if (this.search != "") {
        this.$store.dispatch('clientModule/searchClient', this.search)
        .then(response => {
            console.log(response.data)
            
            if(response.data.length <= 0 ){
                  this.noData=true
             }
             else{
                 this.noData=false
                  this.$store.commit('SET_CLIENTS', response.data)
             }

            this.firstPage= response.first_page_url
            this.previousPage= response.prev_page_url
            this.currentPage= response.current_page
            this.nextPage= response.next_page_url
            this.lastPage= response.last_page_url
            this.totalPages= response.last_page



          })
      } else {
        this.noData=false
        this.fetchData()
      }

    }
  }
}

</script>
