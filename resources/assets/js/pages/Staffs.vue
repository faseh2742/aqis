<template>
  <div class="content">
    <AddStaffModal
      v-if="showStaffModal"
      :staffEdit="staffEdit"
      @close="closeModal('staffModal')"
    ></AddStaffModal>
    <div class="md-layout">
      <div class="md-progress-spinner-centre">
        <md-progress-spinner v-if="loading" md-mode="indeterminate">
        </md-progress-spinner>
      </div>
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h3 class="title">Staff Management</h3>
            <p class="titleCategory">List of AQIS staff members</p>
          </md-card-header>
          <md-card-content>
            <nav class="panel">
              <div v-show="$root.canWrite('facilitators')" class="panel-block">
                <p>
                  <a
                    class="button is-link is-active"
                    @click="openModal('staffModal')"
                  >
                    <span>Add Staff</span>
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
                    @keyup="searchStaff"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-search" aria-hidden="true"></i>
                  </span>
                </p>
              </div>
              <div class="panel-block">
                <table
                  class="table is-bordered is-striped is-hoverable is-fullwidth"
                >
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Primary Phone</th>
                    <th>Position</th>
                    <th>Active</th>
                    <th
                      v-show="$root.canWrite('facilitators')"
                      class="is-narrow"
                    >
                      Edit
                    </th>
                    <th
                      v-show="$root.canDelete('facilitators')"
                      class="is-narrow"
                    >
                      Delete
                    </th>
                  </tr>
                  <tr v-if="noData">
                    <td colspan="7">No Data Found</td>
                  </tr>
                  <tr v-else v-for="(staff, index) in staffs" :key="index">
                    <td v-if="staff.user">{{ staff.user.firstName }}</td>
                    <td v-if="staff.user">{{ staff.user.lastName }}</td>
                    <td>{{ phoneFormater.FormatPhone(staff.phonePrimary) }}</td>
                    <td>{{ staff.position }}</td>
                    <td>
                      <span v-if="staff.user.active == 1">Yes</span>
                      <span class="has-text-danger" v-else>No</span>
                    </td>
                    <td v-show="$root.canWrite('facilitators')">
                      <button
                        class="button is-success"
                        @click="editModal('staffModal', staff)"
                      >
                        <span><i class="fas fa-pencil-alt"></i></span>
                      </button>
                    </td>
                    <td v-show="$root.canDelete('facilitators')">
                      <button
                        class="button is-danger"
                        @click="deleteStaff(index, staff.id)"
                      >
                        <span><i class="far fa-trash-alt"></i></span>
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
                  :url="'/api/staff'"
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
import AddStaffModal from "./Modals/AddStaffModal.vue";
import Pagination from "./pagination.vue";
import PhoneFormater from "../phoneNumberFormat";

export default {
  created() {
    this.fetchData().then((response) => {
      this.loading = false;
    });
  },
  components: {
    AddStaffModal,
    Pagination,
  },
  data() {
    return {
      loading: true,
      search: "",
      staffs: [],
      facilitatorId: "",
      clientsPerPage: [],
      firstPage: "",
      previousPage: "",
      currentPage: "",
      nextPage: "",
      lastPage: "",
      totalPages: "",
      showStaffModal: false,
      staffEdit: "",
      url: "/api/staff",
      noData: false,
      phoneFormater: new PhoneFormater(),
    };
  },
  computed: {},
  methods: {
    canWrite() {
      if (this.$store.state.user.role === "Admin") {
        return true;
      } else if (this.$store.state.user.permission.facilitator >= 2) {
        return true;
      } else {
        return false;
      }
    },
    canDelete() {
      if (this.$store.state.user.role === "Admin") {
        return true;
      } else if (this.$store.state.user.permission.facilitator == 3) {
        return true;
      } else {
        return false;
      }
    },
    getFacilitators(value) {
      return axios.get(value);
    },
    fetchData() {
      return axios.all([this.getFacilitators(this.url)]).then((response) => {
        this.staffs = response[0].data.data;
        this.firstPage = response[0].data.first_page_url;
        this.previousPage = response[0].data.prev_page_url;
        this.currentPage = response[0].data.current_page;
        this.nextPage = response[0].data.next_page_url;
        this.lastPage = response[0].data.last_page_url;
        this.totalPages = response[0].data.last_page;
      });
    },

    openModal(name, id) {
      switch (name) {
        case "staffModal":
          console.log(this.currentPage);
          this.showStaffModal = true;

          break;
      }
    },

    editModal(name, item) {
      switch (name) {
        case "staffModal":
          this.staffEdit = item;

          this.showStaffModal = true;
          break;
      }
    },

    closeModal(name) {
      switch (name) {
        case "staffModal":
          this.staffEdit = "";
          this.showStaffModal = false;
          this.url = this.currentPage;
          this.fetchData();
          break;
      }
    },

    deleteStaff(index, id) {
      let payload = {
        url: "/api/staff/",
        id: id,
        confirmtxt: "Employee has been deleted.",
      };
      this.$store.dispatch("deleteRecord", payload).then((response) => {
        if (response) {
          this.staffs.splice(index, 1);
        }
      });
    },

    onPageChange(value) {
      console.log("staff", value);
      this.getFacilitators(value).then((response) => {
        this.staffs = response.data.data;
        this.firstPage = response.data.first_page_url;
        this.previousPage = response.data.prev_page_url;
        this.currentPage = response.data.current_page;
        this.nextPage = response.data.next_page_url;
        this.lastPage = response.data.last_page_url;
        this.totalPages = response.data.last_page;
      });
    },
    searchStaff() {
      if (this.search != "") {
        return axios
          .post("/api/search/staff", {
            string: this.search,
          })
          .then((response) => {
            if (response.data.data.length <= 0) {
              this.noData = true;
            } else {
              this.noData = false;
              this.staffs = response.data.data;
            }
          });
      } else {
        this.noData = false;
        this.fetchData();
      }
    },
  },
};
</script>
