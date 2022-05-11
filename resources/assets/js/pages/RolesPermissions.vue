<template>
  <div class="content">
    <add-permission-modal
      v-if="showPermissionModal"
      :permissionEdit="permissionEdit"
      @close="closeModal('permissionModal')"
    ></add-permission-modal>
    <div class="md-layout">
      <div class="md-progress-spinner-centre">
        <md-progress-spinner v-if="loading" md-mode="indeterminate"></md-progress-spinner>
      </div>
      <div class="md-layout-item md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">User Roles & Permissions</h3>
            <p class="titleCategory">Manage User roles & permissions.</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
              <div v-show="$root.canWrite('permissions')" class="panel-block">
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
                  <input
                    class="input is-small"
                    type="text"
                    name="string"
                    placeholder="search"
                    v-model="search"
                    @keyup="searchPermission"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-search" aria-hidden="true"></i>
                  </span>
                </p>
              </div>

              <div class="panel-block">
                <!-- <md-table
                  v-model="permissions"
                  class="md-layout-item md-medium-size-100 md-size-100"
                >
                  <md-table-row slot="md-table-row" slot-scope="{ item }">
                    <md-table-cell
                      md-label="Name"
                    >{{ item.user.firstName + " " + item.user.lastName }}</md-table-cell>
                    <md-table-cell md-label="E-mail Address">{{ item.user.email }}</md-table-cell>
                    <md-table-cell md-label="Actions">
                      <md-button
                        class="md-just-icon md-success"
                        @click="openModal('editPermissionModal', item.id)"
                      >
                        <md-icon>edit</md-icon>
                      </md-button>
                      <md-button
                        class="md-just-icon md-danger"
                        @click="deletePermission(index, item.id)"
                      >
                        <md-icon>close</md-icon>
                      </md-button>
                    </md-table-cell>
                  </md-table-row>
                </md-table>-->

                <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                  <tr>
                    <th>Name</th>
                    <th>E-mail Address</th>
                    <th v-show="$root.canWrite('permissions')" class="is-narrow">Edit</th>
                    <th v-show="$root.canDelete('permissions')" class="is-narrow">Delete</th>
                  </tr>
                  <tr v-for="(permission, index) in permissions" :key="index"  >
                    <td  v-if="permission.user"
                     
                    >{{ permission.user.firstName + " " + permission.user.lastName }}</td>
                    <td v-if="permission.user">{{ permission.user.email }}</td>
                    <td v-show="$root.canWrite('permissions') && permission.user ">
                      <button
                        class="button is-success"
                        @click="openModal('editPermissionModal', permission)"
                      >
                        <span>
                          <i class="fas fa-pencil-alt"></i>
                        </span>
                      </button>
                    </td>
                    <td v-show="$root.canDelete('permissions')&& permission.user" >
                      <button
                        class="button is-danger"
                        @click="deletePermission(index, permission.id)"
                      >
                        <span>
                          <i class="far fa-trash-alt"></i>
                        </span>
                      </button>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="panel-block paginate" align="right">
                <pagination
                  :firstPage="firstPage"
                  :previousPage="previousPage"
                  :currentPage="currentPage"
                  :nextPage="nextPage"
                  :lastPage="lastPage"
                  :totalPages="totalPages"
                  :maxVisibleButtons="3"
                  :url="postUrl"
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
import AddPermissionModal from "./Modals/AddPermissionModal.vue";
import EditPermissionModal from "./Modals/EditPermissionModal.vue";
import Pagination from "./pagination.vue";

export default {
  created() {
    this.fetchData().then(response => {
      this.loading = false;
    });
  },
  components: {
    AddPermissionModal,
    Pagination
  },
  data() {
    return {
      loading: true,
      permissions: [],
      permissionEdit: "",
      showPermissionModal: false,
      showEditPermissionModal: false,
      search: "",
      clientsPerPage: [],
      firstPage: "",
      previousPage: "",
      currentPage: "",
      nextPage: "",
      lastPage: "",
      totalPages: "",
      postUrl: "/api/permission"
    };
  },
  computed: {},
  methods: {
    getPermissions() {
      return axios.get("/api/permission");
    },
    fetchData() {
      return axios.all([this.getPermissions()]).then(response => {
        if (response != null) {
          this.permissions = response[0].data.data;
          this.firstPage = response[0].data.first_page_url;
          this.previousPage = response[0].data.prev_page_url;
          this.currentPage = response[0].data.current_page;
          this.nextPage = response[0].data.next_page_url;
          this.lastPage = response[0].data.last_page_url;
          this.totalPages = response[0].data.last_page;
        }
      });
    },
    openModal(name, item) {
      switch (name) {
        case "permissionModal":
          this.showPermissionModal = true;
          break;
        case "editPermissionModal":
          this.permissionEdit = item;
          this.showPermissionModal = true;
          break;
      }
    },
    closeModal(name) {
      switch (name) {
        case "permissionModal":
          this.showPermissionModal = false;
          this.permissionEdit = "";
          this.fetchData();
          break;
      }
    },
    deletePermission(index, id) {
      let payload = {
        url: "/api/permission/",
        id: id,
        confirmtxt: "Permission has been deleted."
      };
      this.$store.dispatch("deleteRecord", payload).then(response => {
        if (response) {
          this.permissions.splice(index, 1);
        }
      });
    },
    onPageChange(value) {
      this.$store.dispatch("getPermissions", value).then(response => {
        this.firstPage = response[0].data.first_page_url;
        this.previousPage = response[0].data.prev_page_url;
        this.currentPage = response[0].data.current_page;
        this.nextPage = response[0].data.next_page_url;
        this.lastPage = response[0].data.last_page_url;
        this.totalPages = response[0].data.last_page;
      });
    },
    searchPermission() {
      if (this.search != "") {
        this.$store
          .dispatch("searchPermissions", this.search)
          .then(response => {
            this.permissions = response.data.data;

            this.firstPage = response.data.first_page_url;
            this.previousPage = response.data.prev_page_url;
            this.currentPage = response.data.current_page;
            this.nextPage = response.data.next_page_url;
            this.lastPage = response.data.last_page_url;
            this.totalPages = response.data.last_page;
          });
      } else {
        this.fetchData();
      }
    }
  }
};
</script>