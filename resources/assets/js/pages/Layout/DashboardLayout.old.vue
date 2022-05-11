<template>
  <div class="wrapper">
    <notifications></notifications>

    <side-bar>
      <!-- <mobile-menu slot="content"></mobile-menu> -->
      <sidebar-link to="/dashboard">
        <md-icon>dashboard</md-icon>
        <p>Dashboard</p>
      </sidebar-link>
      <sidebar-link v-show="this.$store.state.role.ClientList !=0" to="/clients">
        <md-icon>supervised_user_circle</md-icon>
        <p>Clients</p>
      </sidebar-link>
      <sidebar-link to="/facilitators">
        <md-icon>person</md-icon>
        <p>Facilitator Management</p>
      </sidebar-link>
      <sidebar-link to="/aptemplates">
        <md-icon>class</md-icon>
        <p>Action Plan Templates</p>
      </sidebar-link>
      <sidebar-link to="/reports">
        <!-- <i class="fas fa-file-contract"></i> -->
        <md-icon>file_copy</md-icon>
        <p>Reports</p>
      </sidebar-link>
      <!-- <sidebar-link to="/roles">
        <md-icon>ballot</md-icon>
        <p>User Roles</p>
      </sidebar-link> -->
      <sidebar-link v-if="canViewPermission" to="/dropdowns">
        <!-- <md-icon>ballot</md-icon> -->
        <i class="far fa-caret-square-down"></i>
        <p>Dropdowns</p>
      </sidebar-link>
      <sidebar-link v-if="canViewPermission" to="/permissions">
        <md-icon>ballot</md-icon>
        <p>User Permissions</p>
      </sidebar-link>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content></dashboard-content>

      <!-- <content-footer v-if="!$route.meta.hideFooter"></content-footer> -->
    </div>
  </div>
</template>
<style lang="scss">
</style>
<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
// import MobileMenu from './MobileMenu.vue'

export default {
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter
    // MobileMenu
  },
  created() {
    this.$store.dispatch("getRolePermission");
  },
  methods: {},
  computed: {
    canViewPermission() {
      if (this.$store.state.user.role === "Admin") {
        return true;
      } else if (
        this.$store.state.user.permission.permissions != null ||
        this.$store.state.user.permission.permissions >= 1) {
        return true;
      }
      return false;
    }
  }
};
</script>
