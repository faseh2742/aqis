import Vue from "vue";
import VueRouter from "vue-router";
import DashboardPlugin from "./material-dashboard";

// Plugins
import App from "./App.vue";
import Chartist from "chartist";

// router setup
import routes from "./routes/routes";

//Importing moment.js
import moment from "moment";

// plugin setup
Vue.use(VueRouter);
Vue.use(DashboardPlugin);
// Vue.use(moment);

// configure router
const router = new VueRouter({
    routes, // short for routes: routes
    linkExactActiveClass: "nav-item active"
});

// global library setup
Object.defineProperty(Vue.prototype, "$Chartist", {
    get() {
        return this.$root.Chartist;
    }
});

Object.defineProperty(Vue.prototype, '$moment', {value: moment});

/* eslint-disable no-new */
new Vue({
    el: "#app",
    render: h => h(App),
    router,
    data: {
        Chartist: Chartist,
    },
});
