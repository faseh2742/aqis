export default {

    SET_APTEMPLATE (state, aptemplate) {
        state.aptemplate = aptemplate
    },
    SET_APTEMPLATEID (state, aptemplateID) {
        state.aptemplate.id = aptemplateID
    },
     SET_SELECT_NOC (state, value) {
        state.selectNoc = value
    },

    // AP TEMPLATE FORM

    SET_TEMPLATE_NOC (state, value) {
        state.aptemplate.noc = value
    },
    SET_TEMPLATE_CATEGORY (state, value) {
        state.aptemplate.category = value
    },
    SET_TEMPLATE_LICENSE (state, value) {
        state.aptemplate.cert_license = value
    },
    SET_TEMPLATE_CREDENTIALS (state, value) {
        state.aptemplate.credential_eval = value
    },
    SET_TEMPLATE_DOCS (state, value) {
        state.aptemplate.docs_trans = value
    },
    SET_TEMPLATE_TRAINING (state, value) {
        state.aptemplate.training = value
    },
    SET_TEMPLATE_BRIDGING (state, value) {
        state.aptemplate.bridging = value
    },
    SET_TEMPLATE_LANGUAGE (state, value) {
        state.aptemplate.language = value
    },
    SET_TEMPLATE_EDUCATION (state, value) {
        state.aptemplate.further_education = value
    },
    SET_TEMPLATE_TRADES (state, value) {
        state.aptemplate.trades = value
    },
    SET_TEMPLATE_WORKPLACE (state, value) {
        state.aptemplate.workplace_exp = value
    },
    SET_TEMPLATE_CAREER (state, value) {
        state.aptemplate.alt_career = value
    },
    SET_TEMPLATE_MENTORING (state, value) {
        state.aptemplate.mentoring = value
    },
    EDIT_MODAL (state, value) {
        state.editModal = value
    },

}