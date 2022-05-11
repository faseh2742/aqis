import store from '../store/'

import DashboardLayout from '../pages/Layout/DashboardLayout.vue'

import Dashboard from '../pages/Dashboard.vue'
import Login from '../pages/Login.vue'
import Logout from '../pages/Logout.vue'
import Clientslist from '../pages/Clientslist.vue'
import Clientprofile from '../pages/Clientprofile.vue'
import Aptemplate from '../pages/Aptemplate.vue'
import Aptemplatelist from '../pages/Aptemplatelist.vue'
import Schedules from "../pages/Schedules.vue";
import denied from '../pages/Denied.vue'
import Staffs from '../pages/Staffs.vue'
import Reports from '../pages/Reports.vue'
import clientRegReport from '../pages/ClientReports.vue'
import Dropdowns from '../pages/Dropdowns.vue'
import Languages from '../pages/Languages.vue'
import Cities from '../pages/Cities.vue'
import Outcomes from '../pages/Outcomes.vue'
import RolesPermissions from '../pages/RolesPermissions.vue'
import UserProfile from '../pages/UserProfile.vue'
// import Charts from '../pages/Charts.vue'
import Referrals from '../pages/ReferralList.vue'
import AQISReport from '../pages/AQISReports.vue'
import DemographicReports from '../pages/DemographicReports.vue'
import MonthlyReport from "../pages/Reports/MonthlyReport";

const routes = [{
    path: '/',
    component: DashboardLayout,
    redirect: '/login',
    children: [
    {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, roles: ['Admin', 'Facilitator'], },
    },
    {
        path: 'denied',
        name: 'Denied',
        component: denied
    },
    {
        path: 'clients',
        name: 'Clients',
        component: Clientslist,
        meta: { requiresAuth: true, roles: ['Admin', 'Facilitator'], permName: 'clients' },
    },
    {
        path: 'staffs',
        name: 'Staff Management',
        component: Staffs,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'facilitators' },

    },
    {
        path: 'clients/:id',
        name: 'Client Profile',
        component: Clientprofile,
        meta: { requiresAuth: true, roles: ['Admin', 'Facilitator'], permName: 'clients' },

    },
    {
        path: 'aptemplates',
        name: 'Action Plan Templates',
        component: Aptemplatelist,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'aptemplates' },

    },

    {
        path: 'schedules',
        name: 'Schedules',
        component: Schedules,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'schedules' },

    },

    {
        path: 'aptemplates/:id',
        name: 'Action Plan',
        component: Aptemplate,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'aptemplates' },
    },
    {
        path: '/reports',
        name: 'Reports',
        component: Reports,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'reports' },

    },
    {
        path: 'dropdowns',
        name: 'Manage Dropdowns',
        component: Dropdowns,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'dropdowns' },

    },
    {
        path: 'languages',
        name: 'Manage Languages',
        component: Languages,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'languages' },

    },
    {
        path: 'cities',
        name: 'Manage Cities',
        component: Cities,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'cities' },

    },
    {
        path: 'outcomes',
        name: 'Manage Outcomes',
        component: Outcomes,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'outcomes' },

    },
    {
        path: 'referrals',
        name: 'Manage Referrals',
        component: Referrals,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'referrals' },

    },
    {
        path: 'rolespermissions',
        name: 'Roles & Permissions',
        component: RolesPermissions,
        meta: { requiresAuth: true, roles: ['Admin'], permName: 'permissions' },

    },
    {
        path: 'userprofile',
        name: 'User Profile',
        component: UserProfile,
        meta: { requiresAuth: true, roles: ['Facilitator', 'Admin'], },

    },
    ]
},
{
    path: '/reports/ClientReg',
    name: 'Registration Report',
    component: clientRegReport,
    meta: { requiresAuth: true, roles: ['Admin'], permName: 'reports' },

},
{
    path: '/reports/AQISReport',
    name: 'AQIS Report',
    component: AQISReport,
    meta: { requiresAuth: true, roles: ['Admin'], permName: 'reports' },
    props: true,

},
{
    path: '/reports/Demographics',
    name: 'Demographic Reports',
    component: DemographicReports,
    meta: { requiresAuth: true, roles: ['Admin'], permName: 'reports' },
    props: true,

},

{
    path: '/reports/monthly',
    name: 'AQIS Monthly Report',
    component: MonthlyReport,
    meta: { requiresAuth: true, roles: ['Admin'], permName: 'reports'},
    props: true,
},

{
    path: '/login',
    name: 'Log In',
    component: Login,
    beforeEnter: (to, from, next) => {
        if ($cookies.isKey('access_token')) {
            next('/dashboard')
        } else {
            next();
        }
    }
},
{
    path: '/logout',
    name: 'Log Out',
    component: Logout,
}
]


export default routes
