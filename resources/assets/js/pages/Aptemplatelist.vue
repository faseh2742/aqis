<template>
  <div class="content">
    <AddTemplateModal v-if="showAptemplateModal" @close="closeModal('aptemplateModal')"></AddTemplateModal>
    <div class="md-layout">
      <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Action Plan Templates</h3>
            <p class="titleCategory">Current collection of action plan templates</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
                <div v-show="$root.canWrite('aptemplates')" class="panel-block">
                  <p>
                    <a class="button is-link is-active" @click="openModal('aptemplateModal')">
                      <span>Add Template</span>
                      <span class="icon is-small">
                        <i class="fas fa-plus-square"></i>
                      </span>
                    </a>
                  </p>
                </div>
                <div class="panel-block">
                  <p class="control has-icons-left">
                    <input class="input is-small" type="text" v-model="search" placeholder="search" @keyup="searchAptemplate">
                    <span class="icon is-small is-left">
                      <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                  </p>
                </div>
                <div class="panel-block">
                  <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                    <tr>
                      <th>NOC</th>
                      <th>Category</th>
                      <th>Updated by</th>
                      <th>Last Updated</th>
                    </tr>
                    <tr v-if="noData"><td colspan="4">No Data Found</td></tr>
                    <tr v-else v-for="aptemplate in aptemplates" :key="aptemplate.id">
                        <td v-if="aptemplate.noc"><router-link :to="/aptemplates/+aptemplate.id">{{ aptemplate.noc.code }}</router-link></td>
                        <td v-if="aptemplate.noc"><router-link :to="/aptemplates/+aptemplate.id">{{ aptemplate.noc.title }}</router-link></td>
                        <td><router-link :to="/aptemplates/+aptemplate.id">{{ aptemplate.updated_by? aptemplate.updated_by.firstName + " " + aptemplate.updated_by.lastName: '' }}</router-link></td>
                        <td v-if="aptemplate.noc"><router-link :to="/aptemplates/+aptemplate.id">{{ moment(aptemplate.updated_at).format("MMM Do YYYY") }}</router-link></td>
                    </tr>
                  </table>
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
  import AddTemplateModal from './Modals/Addtemplatemodal.vue'
  import Pagination from './pagination.vue'
  import moment from 'moment'

  let convert = require('xml-js')

export default {

  created() {
    this.$store.commit('aptemplateModule/SET_APTEMPLATE', {})
    this.fetchData()
    .then (response => {
      this.loading = false
    })
  },
  components: {
    AddTemplateModal,
    Pagination,
  },
  data () {
    return {
      loading: true,
      search: '',
      clientsPerPage: [],
      firstPage: '',
      previousPage: '',
      currentPage: '',
      nextPage: '',
      lastPage: '',
      totalPages: '',
      postUrl: '/api/aptemplates',
      moment: moment,
      noData:false,
    }
  },
  computed: {
    aptemplates () {
      return this.$store.state.aptemplates
    },
    showAptemplateModal () {
         this.$store.state.acionTempPage=this.currentPage
      return this.$store.state.showAptemplateModal
    },
    writeToAPTList () {
      return  ['write','destroy'].indexOf(this.$store.state.role.ApTemplateList) > -1;
    },
    nocList () {
      return this.$store.state.nocList
    }
  },
  methods: {
      fillData () {
             this.fetchData ()

      },
    fetchData () {
      return this.$store.dispatch('getAptemplates', this.postUrl)
      .then (response => {
        this.firstPage= response.first_page_url
        this.previousPage= response.prev_page_url
        this.currentPage= response.current_page
        this.nextPage= response.next_page_url
        this.lastPage= response.last_page_url
        this.totalPages= response.last_page
      })
    },
    openModal (name) {

      switch (name) {
        case 'aptemplateModal':

        this.$store.commit('aptemplateModule/SET_APTEMPLATE', {})
        this.$store.commit('OPEN_APTEMPLATE_MODAL');
        break;
      }
    },
    closeModal (name) {

      switch (name) {
        case 'aptemplateModal':
        this.$store.commit('CLOSE_APTEMPLATE_MODAL');
         this.postUrl=this.currentPage
         this.fetchData()

          console.log(this.currentPage)
        break;
      }
    },
    onPageChange (value) {
      this.$store.dispatch('getAptemplates', value)
      .then (response => {
        this.firstPage= response.first_page_url
        this.previousPage= response.prev_page_url
        this.currentPage= response.current_page
        this.nextPage= response.next_page_url
        this.lastPage= response.last_page_url
        this.totalPages= response.last_page
      })
    },

    searchAptemplate () {
         if (this.search != "") {

           axios.post('/api/search/aptemplate', {
             string: this.search
           })
           .then(response => {
             this.$store.commit('SET_APTEMPLATES', response.data.data)
             if(response.data.data==''){
                  this.noData=true
             }
             else{
                 this.noData=false
             }
             })
         }
         else{
               this.fetchData()
         }



    },

  }
}

</script>
