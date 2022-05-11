<template>
  <div 
  class="sidebar" 
  :data-color="activeColor" 
  :data-image="backgroundImage" 
  :data-background-color="backgroundColor"
  :style="sidebarStyle">

    <div class="logo">
      <a href="/#/dashboard/" class="simple-text logo-mini">
        <div class="logo-img">
            <img :src="imgLogo" alt="AQIS Logo">
        </div>
      </a>

      <a href="/#/dashboard/" class="simple-text logo-normal">
        {{title}}
      </a>
    </div>
    <div class="sidebar-wrapper">
      <slot name="content"></slot>
      <md-list class="nav">
        <!--By default vue-router adds an active class to each route link. This way the links are colored when clicked-->
        <slot>
          <sidebar-link v-for="(link,index) in sidebarLinks"
                        :key="link.name + index"
                        :to="link.path"
                        :link="link">
          </sidebar-link>
        </slot>
      </md-list>
    </div>
  </div>
</template>
<script>
import SidebarLink from './SidebarLink.vue'
import MobileMenu from '../../pages/Layout/MobileMenu.vue'

export default{
  components: {
    SidebarLink,
    MobileMenu
  },
  props: {
    title: {
      type: String,
      default: 'AQIS'
    },
    backgroundImage: {
      type: String,
      default: require('../../../img/sidebar-2.jpg')
    },
    backgroundColor: {
      type: String,
      default: "black",
      validator: value => {
        let acceptedValues = ["", "black", "white", "red"];
        return acceptedValues.indexOf(value) !== -1;
      }
    },
    imgLogo: {
      type: String,
      default: require('../../../img/aqis.jpg')
    },
    activeColor: {
      type: String,
      default: 'green',
      validator: (value) => {
        let acceptedValues = ['', 'purple', 'blue', 'green', 'orange', 'red']
        return acceptedValues.indexOf(value) !== -1
      }
    },
    sidebarLinks: {
      type: Array,
      default: () => []
    },
    autoClose: {
      type: Boolean,
      default: true
    }
  },
  provide () {
    return {
      autoClose: this.autoClose
    }
  
  },
  computed: {
    sidebarStyle () {
      return {
        backgroundImage: `url(${this.backgroundImage})`
      }
    }
  }
}
</script>
<style>
  @media screen and (min-width: 991px) {
    .nav-mobile-menu{
      display: none;
    }
  }
</style>
