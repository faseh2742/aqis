export default {

    getFacilitator (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .get('/api/faci;itator/' + context.state.client.client_id)
                .then(response => {
                    response = response.data
                    context.commit('SET_FACILITATOR', response)
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },


}