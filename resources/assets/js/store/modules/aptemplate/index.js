import state from './state'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'


const aptemplateModule = {
  namespaced: true,
    state,
    actions,
    mutations,
    getters,
  }

export default aptemplateModule