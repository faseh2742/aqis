export default {

    updateClient (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token
        const url = `api/clients/${context.state.client.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise ((resolve, reject) => {
                axios.post(url , {
                    first_name: context.state.client.first_name,
                    last_name: context.state.client.last_name,
                    client_id: context.state.client.client_id,
                    immigration_status: context.state.client.immigration_status,
                    dob: context.state.client.dob,
                    doa: context.state.client.doa,
                    gender: context.state.client.gender,
                    address: context.state.client.address,
                    phone_primary: context.state.client.phone_primary,
                    phone_secondary: context.state.client.phone_secondary,
                    email: context.state.client.email,
                    highest_education: context.state.client.highest_education,
                    mother_tongue: context.state.client.mother_tongue,
                    country_origin: context.state.client.country_origin,
                    english_proficiency: context.state.client.english_proficiency,
                    interpreter_needed: context.state.client.interpreter_needed,
                    interpreter_language: context.state.client.interpreter_language,
                    childcare_needed: context.state.client.childcare_needed,
                    notes: context.state.client.notes,
                    visible: '1'
                })
                .then (response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    reject(errors)
                })
            })
        }
    },

    getClient (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .get('/api/clients/' + context.state.client.client_id)
                .then(response => {
                    response = response.data
                    context.commit('SET_CLIENT', response)
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },

//ADD ACTIONS
    addEducation (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/education', {
                    client_id: context.state.client.id,
                    education_level: context.state.education.education_level,
                    major: context.state.education.major,
                    graduation_date: context.state.education.graduation_date,
                    education_country: context.state.education.education_country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    addTraining (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/training', {
                    client_id: context.state.client.id,
                    subject: context.state.training.subject,
                    association: context.state.training.association,
                    training_year: context.state.training.training_year,
                    country: context.state.training.country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    addEmployment (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/employment', {
                    client_id: context.state.client.id,
                    noc: context.state.employment.noc,
                    job_title: context.state.employment.job_title,
                    field: context.state.employment.field,
                    experience_years: context.state.employment.experience_years,
                    country: context.state.employment.country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    addMeeting (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/meeting', {
                    client_id: context.state.client.id,
                    type: context.state.meeting.type,
                    date: context.state.meeting.date,
                    status: context.state.meeting.status,
                    location: context.state.meeting.location,
                    funder: context.state.meeting.funder,
                    facilitator: context.state.meeting.facilitator,
                    comments: context.state.meeting.comments,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    addWorkshop (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/workshop', {
                    client_id: context.state.client.id,
                    type: context.state.workshop.type,
                    start_date: context.state.workshop.start_date,
                    end_date: context.state.workshop.end_date,
                    attendance: context.state.workshop.attendance,
                    location: context.state.workshop.location,
                    funder: context.state.workshop.funder,
                    facilitator: context.state.workshop.facilitator,
                    comments: context.state.workshop.comments,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },

//UPDATE ACTIONS
    updateEducation (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/education/${context.state.education.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    education_level: context.state.education.education_level,
                    major: context.state.education.major,
                    graduation_date: context.state.education.graduation_date,
                    education_country: context.state.education.education_country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    updateTraining (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/training/${context.state.training.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    subject: context.state.training.subject,
                    association: context.state.training.association,
                    training_year: context.state.training.training_year,
                    country: context.state.training.country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    updateEmployment (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/employment/${context.state.employment.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    noc: context.state.employment.noc,
                    job_title: context.state.employment.job_title,
                    field: context.state.employment.field,
                    experience_years: context.state.employment.experience_years,
                    country: context.state.employment.country,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    updateMeeting (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/meeting/${context.state.meeting.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    type: context.state.meeting.type,
                    date: context.state.meeting.date,
                    status: context.state.meeting.status,
                    location: context.state.meeting.location,
                    funder: context.state.meeting.funder,
                    facilitator: context.state.meeting.facilitator,
                    comments: context.state.meeting.comments,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    
    updateWorkshop (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/workshop/${context.state.workshop.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    type: context.state.workshop.type,
                    start_date: context.state.workshop.start_date,
                    end_date: context.state.workshop.end_date,
                    attendance: context.state.workshop.attendance,
                    location: context.state.workshop.location,
                    funder: context.state.workshop.funder,
                    facilitator: context.state.workshop.facilitator,
                    comments: context.state.workshop.comments,
                })
                .then(response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },

    searchClient (context, string) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token
        const url = `api/search/client`
        if (context.rootGetters.loggedIn) {
            return new Promise ((resolve, reject) => {
                axios.post(url , {
                    string: string,   
                })
                .then (response => {
                    response = response.data
                    resolve(response)
                })
                .catch (errors => {
                    reject(errors)
                })
            })
        }
    },

}