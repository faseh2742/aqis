import { updateField } from 'vuex-map-fields';

export default {
    updateField,

    RESET_USER (state) {
        state.user = {
            name: null,
            token: null,
            role: null,
            permission: {},
            refresh_token: null,

    }
    },
    SET_CATEGORY_ID (state, id) {
        state.category_id = id
    },
    SET_AUTHUSER (state, user) {
        state.authUser = user
    },

    SET_NOCLIST (state, nocList) {
        state.nocList = nocList
    },

    SET_DROPDOWNS (state, dropdowns) {
        state.dropdowns = dropdowns
    },

    SET_REFERRALS (state, referrals) {
        state.referrals = referrals
    },

    SET_CATEGORIES (state, categories) {
        state.categories = categories
    },

    SET_STAFFLIST (state, staffList) {
        state.staffList = staffList
    },

    SET_ACCESSTOKEN (state, token) {
        state.user.token = token
    },
    SET_REFRESHTOKEN (state, token) {
        state.user.refresh_token = token
    },
    SET_ISFETCHINGTOKEN (state, bool) {
        state.user.isFetchingToken = bool
    },
    SET_REFRESHPROMISE (state, refresh) {
        state.refresh = refresh
    },
    SET_USERROLE (state, role) {
        state.user.role = role
    },
    SET_USERNAME (state, name) {
        state.user.name = name
    },
    SET_USERPERMISSION (state, permission) {
        state.user.permission = permission
    },
    SET_PERMISSIONS (state, permissions) {
        state.permissions = permissions
    },
    SET_CLIENTS (state, clients) {
        state.clients = clients
    },
    SET_FACILITATORS (state, facilitators) {
        state.facilitators = facilitators
    },
    SET_ROLE (state, roles) {
        state.role = roles
    },
    SET_ROLETABLE (state, roles) {
        state.roleTable = roles
    },
    DESTROY_ROLE (state)
    {
        state.role = null
    },
     DESTROY_ROLETABLE (state)
    {
        state.roleTable = null
    },
    SET_EDUCATIONS (state, educations) {
        state.educations = educations
    },
    SET_TRAININGS (state, trainings) {
        state.trainings = trainings
    },
    SET_EMPLOYMENTS (state, employments) {
        state.employments = employments
    },
    SET_MEETINGS (state, meetings) {
        state.meetings = meetings
    },
    SET_WORKSHOPS (state, workshops) {
        state.workshops = workshops
    },
    SET_CURRENT_MEETING (state, token) {
        state.currentMeeting = token
    },
    SET_APTEMPLATES (state, aptemplates) {
        state.aptemplates = aptemplates
    },
    DESTROY_ACCESSTOKEN (state) {
        state.user.token = null
    },
    DESTROY_REFRESHTOKEN (state) {
        state.user.refresh_token = null
    },
    OPEN_CLIENT_MODAL (state) {
        state.showClientModal = true
    },
    OPEN_USER_MODAL (state) {
        state.showUserModal = true
    },
    OPEN_APTEMPLATE_MODAL (state) {
        state.showAptemplateModal = true
    },
    OPEN_SEARCH_MODAL (state) {
        state.showSearchModal = true
    },
    CLOSE_CLIENT_MODAL (state) {
        state.showClientModal = false
    },
    CLOSE_USER_MODAL (state) {
        state.showUserModal = false
    },
    CLOSE_APTEMPLATE_MODAL (state) {
        state.showAptemplateModal = false
    },
    CLOSE_SEARCH_MODAL (state) {
        state.showSearchModal = false
    },
    AUTHORIZE_USER (state, token) {
        state.authentication = 'axios'
    },
    SET_REPORT_REQUEST (state, token){
        state.reportRequest = token;
    },
    SET_REPORT_RESPONSE(state, token){
        state.reportResponse = token;
    },
    SET_CHARTDATA( state, token){
        let Chart = token.Chart;
        delete token.Chart;
        state.chartData[Chart] = token;
    },

    SET_CLIENT_LAST_PAGE(state, page){
        state.clientsLastPage = page;
    },
    SET_DOCS(state,response)
    {
        state.docs = response

    },


}
