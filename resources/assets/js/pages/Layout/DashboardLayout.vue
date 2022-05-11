<template>
  <div
    class="wrapper"
    :class="[
      { 'nav-open': $sidebar.showSidebar },
      { rtl: $route.meta.rtlActive }
    ]"
  >
    <notifications></notifications>

    <side-bar
      :active-color="sidebarBackground"
      :background-image="sidebarBackgroundImage"
      :data-background-color="sidebarBackgroundColor"
    >
      <!-- <mobile-menu></mobile-menu> -->
      <template slot="links">
        <div v-for="(item, index) in menu" :key="index">
          <sidebar-item
            v-show="$root.canRead(item.perm)"
            :link="{ name: item.name, icon: item.icon, faicon: item.faicon, path: item.path }"
          ></sidebar-item>
        </div>
      </template>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <div :class="{ content: !$route.meta.hideContent }" @click="toggleSidebar">
        <zoom-center-transition :duration="200" mode="out-in">
          <!-- your content here -->
          <router-view :key="$route.path"></router-view>
        </zoom-center-transition>

        <!-- <dashboard-content></dashboard-content> -->
      </div>

      <!-- <content-footer v-if="!$route.meta.hideFooter"></content-footer> -->
    </div>
  </div>
</template>

<script>
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";

function hasElement(className) {
  return document.getElementsByClassName(className).length > 0;
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`);
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className);
    }, 100);
  }
}

import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import MobileMenu from "./Extra/MobileMenu.vue";
import FixedPlugin from "../FixedPlugin.vue";
import UserMenu from "./Extra/UserMenu.vue";
import { ZoomCenterTransition } from "vue2-transitions";

export default {
  components: {
    TopNavbar,
    ContentFooter,
    MobileMenu,
    FixedPlugin,
    UserMenu,
    ZoomCenterTransition
  },
  data() {
    return {
      sidebarBackgroundColor: "black",
      sidebarBackground: "green",
      sidebarBackgroundImage: require("../../../img/sidebar-2.jpg"),
      sidebarMini: true,
      sidebarImg: true,
      menu: [
        {
          name: "Dashboard",
          icon: "dashboard",
          path: "/dashboard",
          perm: "dashboard"
        },
        {
          name: "Clients",
          icon: "supervised_user_circle",
          path: "/clients",
          perm: "clients"
        },
        {
          name: "Staff Management",
          icon: "person",
          path: "/staffs",
          perm: "facilitators"
        },
        {
          name: "Action Plan Templates",
          icon: "class",
          path: "/aptemplates",
          perm: "aptemplates"
        },
        {
          name: "Schedules",
          faicon: "far fa-calendar-alt",
          path: "/schedules",
          perm: "schedules"
        },
        {
          name: "Reports",
          icon: "file_copy",
          path: "/reports",
          perm: "reports"
        },
        {
          name: "Dropdowns",
          faicon: "far fa-caret-square-down",
          path: "/dropdowns",
          perm: "dropdowns"
        },
        {
          name: "Languages",
          faicon: "fas fa-language",
          path: "/languages",
          perm: "languages"
        },
        {
          name: "Cities",
          faicon: "fas fa-city",
          path: "/cities",
          perm: "cities"
        },
        {
          name: "Outcomes",
          faicon: "fas fa-tasks",
          path: "/outcomes",
          perm: "outcomes"
        },
        {
          name: "Referrals",
          faicon: "far fa-share-square",
          path: "/referrals",
          perm: "referrals"
        },
        {
          name: "User Roles & Permissions",
          icon: "ballot",
          path: "/rolespermissions",
          perm: "permissions"
        }
      ]
    };
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize();
      }
    }
  },
  mounted() {
    let docClasses = document.body.classList;
    let isWindows = navigator.platform.startsWith("Win");
    if (isWindows) {
      // if we are on windows OS we activate the perfectScrollbar function
      initScrollbar("sidebar");
      initScrollbar("sidebar-wrapper");
      initScrollbar("main-panel");

      docClasses.add("perfect-scrollbar-on");
    } else {
      docClasses.add("perfect-scrollbar-off");
    }
    this.$store.dispatch("getNocs").then(response => {});
    this.$store.dispatch("getDropdowns").then(response => {});
    this.$store.dispatch("getStaffList").then(response => {});
    this.$store.dispatch("getReferrals").then(response => {});
    this.$store.dispatch("getCategories").then(response => {});
  },
  watch: {
    sidebarMini() {
      this.minimizeSidebar();
    }
  }
};
</script>

<style lang="scss">
$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}
.main-panel .zoomIn {
  animation-name: zoomIn95;
}
@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}
.main-panel .zoomOut {
  animation-name: zoomOut95;
}
</style>
