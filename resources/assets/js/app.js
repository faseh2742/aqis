require("./bootstrap");
window.Vue = require("vue");
Vue.use(require("vue-cookies"));

import Vue from "vue";
import VueCookies from "vue-cookies";
import VueRouter from "vue-router";
import Vuex from "vuex";
import App from "./App.vue";
import store from "./store/";
import VeeValidate from "vee-validate";
import XRegExp from "xregexp/xregexp-all";
import moment from "moment";
import Multiselect from "vue-multiselect";
import VModal from "vue-js-modal";

// router setup
import routes from "./routes/routes";

// Plugins
import GlobalComponents from "./globalComponents";
import GlobalDirectives from "./globalDirectives";
import Notifications from "./components/NotificationPlugin";
import MaterialDashboard from "./material-dashboard";
import Chartist from "chartist";
import CKEditor from "@ckeditor/ckeditor5-vue";
import VueHtmlToPaper from "vue-html-to-paper";
import { BootstrapVue, FormRatingPlugin } from "bootstrap-vue";
import { permissions } from "./mixins/permissions";

const router = new VueRouter({
    routes, // short for routes: routes
    // mode: 'history',
    linkExactActiveClass: "nav-item active",
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    },
});

const htmltoPaperOptions = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
        "https://unpkg.com/kidlat-css/css/kidlat.css",
        // '../sass/app.scss'
    ],
};
Vue.use(FormRatingPlugin);
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(MaterialDashboard);
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.use(Notifications);
Vue.use(VueCookies);
Vue.use(require("vue-chartist"));
Vue.use(VeeValidate, {
    classes: true,
});
Vue.use(XRegExp);
Vue.use(CKEditor);
// Vue.component('ckeditor-classic-custom', CKEditorClassicCustom);
Vue.use(VueHtmlToPaper, htmltoPaperOptions);
Vue.use(VModal, { componentName: "app-modal" });

// var XRegExp = require('xregexp')

Object.defineProperty(Vue.prototype, "$Chartist", {
    get() {
        return this.$root.Chartist;
    },
});
Object.defineProperty(Vue.prototype, "$moment", { value: moment });

Vue.component("passport-clients", require("./components/passport/Clients.vue"));
Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue")
);
Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue")
);

//Registering Vue-Multiselect Globally
Vue.component("multiselect", Multiselect);
Vue.component("modal", require("./pages/Modals/Modal.vue").default);

router.beforeEach((to, from, next) => {
    if (!to.meta.requiresAuth) {
        return next();
    }

    if (!store.state.user) {
        console.log("no user");
        return next("/login");
    }

    /**since the role is no longer being stored in the cookie and instead being stored directly in the state
     * is the state has a user therefore they are currently logged in but if there is no role then they just refreshed the page
     * so on every router before each, check their role permissions before continuing if there is no role stored in the state
     */
    if (store.state.user.role == null) {
        store
            .dispatch("getRolePermission")
            .then(() => {
                return checkRole(to) ? next() : next("/denied");
            })
            .catch((error) => {
                console.log(error);
            });
    } else {
        return checkRole(to) ? next() : next("/denied");
    }
});

function checkRole(to) {
    if (
        Object.keys(store.state.user.permission).length === 0 &&
        to.meta.roles.includes(store.state.user.role)
    ) {
        return true;
    } else if (
        store.state.user.permission[to.meta.permName] > 0 ||
        to.meta.permName == null
    ) {
        return true;
    }
    return false;
}

axios.interceptors.request.use(
    (config) => {
        // list of urls that do not need an access_token or a role to access
        let tokenNotRequired = ["login", "logout", "refresh"];

        if (tokenNotRequired.some((url) => config.url.includes(url))) {
            return config;
        }

        // if there is an refresh_token in the cookie, attempt to retrieve the new access token
        if (
            ($cookies.isKey("refresh_token") &&
                !$cookies.isKey("access_token")) ||
            config.__isRetryRequest
        ) {
            // if there is a state where the requests are staggered and the refreshtoken
            //has been used before a retryRequest then set the new header
            if (
                config.headers["Authorization"] !=
                    "Bearer " + store.state.user.token &&
                config.headers.__isRetryRequest
            ) {
                config.headers["Authorization"] =
                    "Bearer " + store.state.user.token;
                return config;
            }
            return new Promise((resolve, reject) => {
                store
                    .dispatch("postRefreshToken")
                    .then((access_token) => {
                        config.headers["Authorization"] =
                            "Bearer " + access_token;
                        resolve(config);
                    })
                    .catch((error) => {
                        console.log(error);
                        if (
                            error.response.status === 401 ||
                            error.response.status === 422
                        ) {
                            //since the refresh token is now invalid delete the state and the cookies associated with session and push to login
                            store.dispatch("deleteStateCookies");
                            router.push("/login");
                        }
                        resolve(false);
                    });
            });
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// intercept the server responses to the axios, if there is an 401 error, log out the user and redirect to the login
axios.interceptors.response.use(
    function (config) {
        return config;
    },
    (error) => {
        const status = error.response ? error.response.status : null;

        //if the result is a 401 on the refresh call, the refresh_token is expired so clear the state and push user to login
        if (
            (status === 401 && error.config.url.includes("auth/refresh")) ||
            (status === 401 && error.config.__isRetryRequest)
        ) {
            store.dispatch("deleteStateCookies");
            router.push("/login");
        } else if (error.request !== undefined && status === 401) {
            error.config.__isRetryRequest = true;
            return axios.request(error.config);
        }
        return Promise.reject(error);
    }
);

new Vue({
    el: "#app",
    render: (h) => h(App),
    router,
    store,
    mixins: [permissions],
    data: {
        Chartist: Chartist,
    },
});
