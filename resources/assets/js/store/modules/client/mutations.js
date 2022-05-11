export default {
    // CLIENT MUTATIONS
    SET_CLIENT (state, client) {
        state.client = client
    },
    SET_CLIENTID (state, clientId) {
        state.client.client_id = clientId
    },
    SET_CLIENT_FNAME (state, value) {
        state.client.first_name = value
    },
    SET_CLIENT_LNAME (state, value) {
        state.client.last_name = value
    },
    SET_CLIENT_CLID (state, value) {
        state.client.client_id = value
    },
    SET_CLIENT_IMMISTATUS (state, value) {
        state.client.immigration_status = value
    },
    SET_CLIENT_DOB (state, value) {
        state.client.dob = value
    },
    SET_CLIENT_DOA (state, value) {
        state.client.doa = value
    },
    SET_CLIENT_GENDER (state, value) {
        state.client.gender = value
    },
    SET_CLIENT_ADDRESS (state, value) {
        state.client.address = value
    },
    SET_CLIENT_PHPRIMARY (state, value) {
        state.client.phone_primary = value
    },
    SET_CLIENT_PHSECONDARY (state, value) {
        state.client.phone_secondary = value
    },
    SET_CLIENT_EMAIL (state, value) {
        state.client.email = value
    },
    SET_CLIENT_HIGHEDU (state, value) {
        state.client.highest_education = value
    },
    SET_CLIENT_MOTHERTONGUE (state, value) {
        state.client.mother_tongue = value
    },
    SET_CLIENT_COUNTRYORIGIN (state, value) {
        state.client.country_origin = value
    },
    SET_CLIENT_ENGPROF (state, value) {
        state.client.english_proficiency = value
    },
    SET_CLIENT_INTNEEDED (state, value) {
        state.client.interpreter_needed = value
    },
    SET_CLIENT_INTLANG (state, value) {
        state.client.interpreter_language = value
    },
    SET_CLIENT_CCARENEEDED (state, value) {
        state.client.childcare_needed = value
    },
    SET_CLIENT_NOTES (state, value) {
        state.client.notes = value
    },
    SET_CLIENT_VISIBLE (state, value) {
        state.client.visible = value
    },

    // EDUCATION MUTATIONS
    EDUCATION_MODAL (state, command) {
        if (command == 'open') {
            state.showEducationModal = true
        } else {
            state.showEducationModal = false
        }
    },
    SET_EDU_LEVEL (state, value) {
        state.education.education_level = value
    },
    SET_EDU_MAJOR (state, value) {
        state.education.major = value
    },
    SET_EDU_DATE (state, value) {
        state.education.graduation_date = value
    },
    SET_EDU_COUNTRY (state, value) {
        state.education.education_country = value
    },
    SET_EDUCATION (state, education) {
        state.education = education
    },

    // TRAINING MUTATIONS
    TRAINING_MODAL (state, command) {
        if (command == 'open') {
            state.showTrainingModal = true
        } else {
            state.showTrainingModal = false
        }
    },
    SET_TRAINING_SUBJECT (state, value) {
        state.training.subject = value
    },
    SET_TRAINING_ASSOCIATION (state, value) {
        state.training.association = value
    },
    SET_TRAINING_YEAR (state, value) {
        state.training.training_year = value
    },
    SET_TRAINING_COUNTRY (state, value) {
        state.training.country = value
    },
    SET_TRAINING (state, training) {
        state.training = training
    },

    // EMPLOYMENT MUTATIONS
    EMPLOYMENT_MODAL (state, command) {
        if (command == 'open') {
            state.showEmploymentModal = true
        } else {
            state.showEmploymentModal = false
        }
    },
    SET_EMPLOYMENT_NOC (state, value) {
        state.employment.noc = value
    },
    SET_EMPLOYMENT_JOBTITLE (state, value) {
        state.employment.job_title = value
    },
    SET_EMPLOYMENT_FIELD (state, value) {
        state.employment.field = value
    },
    SET_EMPLOYMENT_EXPERIENCE (state, value) {
        state.employment.experience_years = value
    },
    SET_EMPLOYMENT_COUNTRY (state, value) {
        state.employment.country = value
    },
    SET_EMPLOYMENT (state, employment) {
        state.employment = employment
    },

    // MEETING MUTATIONS
    MEETING_MODAL (state, command) {
        if (command == 'open') {
            state.showMeetingModal = true
        } else {
            state.showMeetingModal = false
        }
    },
    SET_MEETING_TYPE (state, value) {
        state.meeting.type = value
    },
    SET_MEETING_DATE (state, value) {
        state.meeting.date = value
    },
    SET_MEETING_STATUS (state, value) {
        state.meeting.status = value
    },
    SET_MEETING_LOCATION (state, value) {
        state.meeting.location = value
    },
    SET_MEETING_FUNDER (state, value) {
        state.meeting.funder = value
    },
    SET_MEETING_FACILITATOR (state, value) {
        state.meeting.facilitator = value
    },
    SET_MEETING_COMMENTS (state, value) {
        state.meeting.comments = value
    },
    SET_MEETING (state, meeting) {
        state.meeting = meeting
    },

    // WORKSHOP MUTATIONS
    WORKSHOP_MODAL (state, command) {
        if (command == 'open') {
            state.showWorkshopModal = true
        } else {
            state.showWorkshopModal = false
        }
    },
    SET_WORKSHOP_TYPE (state, value) {
        state.workshop.type = value
    },
    SET_WORKSHOP_STARTDATE (state, value) {
        state.workshop.start_date = value
    },
    SET_WORKSHOP_ENDDATE (state, value) {
        state.workshop.end_date = value
    },
    SET_WORKSHOP_ATTENDANCE (state, value) {
        state.workshop.attendance = value
    },
    SET_WORKSHOP_LOCATION (state, value) {
        state.workshop.location = value
    },
    SET_WORKSHOP_FUNDER (state, value) {
        state.workshop.funder = value
    },
    SET_WORKSHOP_FACILITATOR (state, value) {
        state.workshop.facilitator = value
    },
    SET_WORKSHOP_COMMENTS (state, value) {
        state.workshop.comments = value
    },
    SET_WORKSHOP (state, workshop) {
        state.workshop = workshop
    },
    SET_CLIENTAP(state, ap){
        state.clientap = ap;
    },
    SEARCH_MODAL (state, command) {
        if (command == 'open') {
            state.showSearchModal = true
        } else {
            state.showSearchModal = false
        }
    },

    SAVE_MODAL (state, command) {
        if (command == 'open') {
            state.showSaveModal = true
        } else {
            state.showSaveModal = false
        }
    },
    Clientap_Modal (state, command) {
        if (command == 'open') {
            state.showClientapModal = true
        } else {
            state.showClientapModal = false
        }
    },
    // EDIT MODAL
    EDIT_MODAL (state, value) {
        state.editModal = value
    }



}