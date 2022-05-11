import { getField } from 'vuex-map-fields';

export default {

    getField,

    loggedIn(state) {
        return state.user.token !== null
    },

    filterClients (state) {
    	state.clients.filter(client => client.first_name);
    	return state.clients;
    },

    facilitators (state) {
        return state.staffList.filter(el => {
            return el.position === "AQIS Facilitator"
        })
    }

}
