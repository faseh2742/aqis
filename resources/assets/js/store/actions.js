import axios from "axios"
import Swal from "sweetalert2"

export default {
    getClientDocs(context, id)
    {
        axios.defaults.headers.common["Authorization"] =
        "Bearer " + context.state.user.token
    const url = `/api/getClientDocs/${id}`
    if (context.getters.loggedIn) {
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(response => {
                    response = response.data
                    console.log(response)
                    context.commit("SET_DOCS", response)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    }
    },
    postRefreshToken(context) {
        // if there is no access_token currently being fetched, then continue
        if (!context.state.user.isFetchingToken) {
            context.commit('SET_ISFETCHINGTOKEN', true)

            const refresh = new Promise((resolve, reject) => {
                axios.post('/api/auth/refresh', {
                    refresh_token: context.state.user.refresh_token,
                }).then(response => {
                    let access_token = response.data.access_token;
                    let refresh_token = response.data.refresh_token;
                    document.cookie = "access_token=" + access_token + ";max-age=" + response.data.expires_in
                    $cookies.set('refresh_token', refresh_token)
                    context.commit('SET_ACCESSTOKEN', access_token)
                    context.commit('SET_REFRESHTOKEN', refresh_token)
                    context.commit('SET_ISFETCHINGTOKEN', false)

                    resolve(access_token)
                }).catch(errors => {
                    reject(errors)
                })
            });
            // store the promise in the state, the purpose of storing the promise is because we do not wish to
            // create more than one refresh request to the backend
            context.commit('SET_REFRESHPROMISE', refresh)
        }
        // return the stored promise
        return context.state.refresh
    },

    getRole(context) {
        // insert code for retrieving  the of the currently enrolled user
        axios.defaults.headers.common["Authorization"] = "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/role")
                    .then(response => {
                        response = response.data
                        context.commit("SET_ROLE", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },
    getRolePermission(context) {
        // insert code for retrieving  the of the currently enrolled user
        axios.defaults.headers.common["Authorization"] = "Bearer " + context.state.user.token
            return new Promise((resolve, reject) => {
                axios
                    .all([
                        axios.get("/api/user/role"),
                        axios.get("/api/user/permission"),
                        axios.get("/api/user/getAuthenticatedUser")
                    ])
                    .then(response => {
                        let role = response[0].data
                        let permission = response[1].data != "" ? response[1].data : {};
                        let name = response[2].data.firstName + " " + response[2].data.lastName
                        // $cookies.set("role", role)
                        // $cookies.set("permission", permission)
                        $cookies.set("name", name)
                        context.commit("SET_USERROLE", role)
                        context.commit("SET_USERNAME", name)
                        context.commit("SET_USERPERMISSION", permission)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
    },
    getClients(context, url) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_CLIENTS", response.data)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getEducations(context, id) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        const url = `/api/educations/${id}`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_EDUCATIONS", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getTrainings(context, id) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        const url = `/api/trainings/${id}`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_TRAININGS", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getEmployments(context, id) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        const url = `/api/employments/${id}`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_EMPLOYMENTS", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getMeetings(context, id) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        const url = `/api/meetings/${id}`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_MEETINGS", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getWorkshops(context, id) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        const url = `/api/workshops/${id}`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_WORKSHOPS", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getAptemplates(context, url) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get(url)
                    .then(response => {
                        response = response.data
                        context.commit("SET_APTEMPLATES", response.data)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getNocs(context) {
        return new Promise((resolve, reject) => {
            axios.post('/api/noclist')
                .then(response => {
                    response = response.data.NOC_STRUCTURE.UNIT_GROUPS.UNIT_GROUP
                    let nocList = []
                    let length = response.length
                    for (let i = 0; i < length; i++) {
                        nocList.push({
                            code: response[i].CODE.NUMBER,
                            title: response[i].TITLE_E
                        })
                    }

                    context.commit("SET_NOCLIST", nocList)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    getDropdowns(context) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        return new Promise((resolve, reject) => {
            axios.get('/api/dropdown')
                .then(response => {
                    response = response.data
                    let dropdowns = []
                    let length = response.length
                    for (let i = 0; i < length; i++) {
                        dropdowns.push({
                            name: response[i].name,
                            items: response[i].items
                        })
                    }

                    context.commit("SET_DROPDOWNS", dropdowns)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    getReferrals(context) {
        return new Promise((resolve, reject) => {
            axios.get('/api/referrals/all')
                .then(response => {
                    response = response.data
                    let referrals = []
                    let length = response.length
                    for (let i = 0; i < length; i++) {
                        referrals.push({
                            id: response[i].id,
                            name: response[i].name,
                            category: response[i].category,
                        })
                    }

                    context.commit("SET_REFERRALS", referrals)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    getCategories(context) {
        return new Promise((resolve, reject) => {
            axios.get('/api/categories')
                .then(response => {
                    response = response.data
                    let categories = []
                    let length = response.length
                    for (let i = 0; i < length; i++) {
                        categories.push({
                            id: response[i].id,
                            name: response[i].name,
                            value: response[i].value,
                            referrals: response[i].referrals,
                            outcomes: response[i].outcomes,
                        })
                    }
                    context.commit("SET_CATEGORIES", categories)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    getStaffList(context) {
        axios.defaults.headers.common["Authorization"] =
        "Bearer " + context.state.user.token
        return new Promise((resolve, reject) => {
            axios.get('/api/staff/list')
                .then(response => {
                    response = response.data

                    context.commit("SET_STAFFLIST", response)
                    resolve(response)
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    login(context, credentials) {
        return new Promise((resolve, reject) => {
            axios
                .post("/api/login", {
                    username: credentials.username,
                    password: credentials.password
                })
                .then(response => {
                    const token = response.data.access_token
                    const refresh_token = response.data.refresh_token

                    document.cookie = "access_token=" + token + ";max-age=" + response.data.expires_in
                    $cookies.set('refresh_token', refresh_token)

                    context.commit('SET_ACCESSTOKEN', token)
                    context.commit('SET_REFRESHTOKEN', refresh_token)
                    context.dispatch('getRolePermission').then(() => {
                        resolve(response)

                    }).catch((errors) => {
                        console.log(errors)
                        resolve()
                    })
                })
                .catch(errors => {
                    console.log(errors)
                    reject(errors)
                })
        })
    },

    logout(context) {
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/logout")
                    .then(response => {
                        context.dispatch('deleteStateCookies')
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    deleteStateCookies(context) {
        localStorage.removeItem("access_token")
        document.cookie = "access_token=null;max-age=-1"
        document.cookie = "refresh_token=null;max-age=-1"
        document.cookie = "name=null;max-age=-1"
        document.cookie = "role=null;max-age=-1"
        document.cookie = "XSRF-TOKEN=null;max-age=-1"
        document.cookie = "laravel_session=null;max-age=-1"
        context.commit("RESET_USER")
    },

    getClientRegReport(context, data) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        // const url = `/api/aptemplates/`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/client/report", context.state.reportRequest)
                    .then(response => {
                        response = response.data
                        context.commit("SET_REPORT_RESPONSE", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },
    getChartData(context, data) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        // const url = `/api/aptemplates/`
        let end = new Date()
        let x = new Date()
        let start = new Date(x.setMonth(x.getMonth() - 1))
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/client/report/chart/" + data.url, {
                        startDate: start,
                        endDate: end
                    })
                    .then(response => {
                        response = response.data

                        context.commit("SET_CHARTDATA", response)

                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    addClientAptemplate(context) {
        //console.log(context.state.aptemplateModule.aptemplate)
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.rootState.user.token
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/clientaps", {
                        client_id: context.state.clientModule.client.client_id,
                        facilitator:
                            context.state.aptemplateModule.aptemplate
                                .facilitator,
                        noc: context.state.aptemplateModule.aptemplate.noc,
                        category:
                            context.state.aptemplateModule.aptemplate.category,
                        cert_license:
                            context.state.aptemplateModule.aptemplate
                                .cert_license,
                        credential_eval:
                            context.state.aptemplateModule.aptemplate
                                .credential_eval,
                        docs_trans:
                            context.state.aptemplateModule.aptemplate
                                .docs_trans,
                        training:
                            context.state.aptemplateModule.aptemplate.training,
                        bridging:
                            context.state.aptemplateModule.aptemplate.bridging,
                        language:
                            context.state.aptemplateModule.aptemplate.language,
                        further_education:
                            context.state.aptemplateModule.aptemplate
                                .further_education,
                        trades:
                            context.state.aptemplateModule.aptemplate.trades,
                        workplace_exp:
                            context.state.aptemplateModule.aptemplate
                                .workplace_exp,
                        alt_career:
                            context.state.aptemplateModule.aptemplate
                                .alt_career,
                        mentoring:
                            context.state.aptemplateModule.aptemplate.mentoring,
                        visible: 1,
                        currentMeeting: context.state.currentMeeting
                    })
                    .then(response => {
                        response = response.data
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },
    findClientap(context) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.rootState.user.token
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/clientaps/" + context.state.currentMeeting)

                    .then(response => {
                        response = response.data
                        context.commit("clientModule/SET_CLIENTAP", response[0])
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    async deleteRecord(context, payload) {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: `You won't be able to revert this!`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "md-button md-success",
            cancelButtonClass: "md-button md-danger",
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false
        });
        if (result.value) {
            return new Promise((resolve, reject) => {
                axios.delete(payload.url + payload.id)
                    .then(response => {
                        Swal.fire({
                            title: "Deleted!",
                            text: payload.confirmtxt,
                            type: "success",
                            confirmButtonClass: "md-button md-success",
                            buttonsStyling: false
                        });
                        resolve(response);
                    })
                    .catch(errors => {
                        if (errors.response.data.errors) {
                            // this.onFailedSubmit(errors.response.data.errors);
                            reject(errors.response.data.errors);
                        } else {
                            // this.onFailedSubmit(errors.response);
                            reject(errors.response);
                        }
                    });
            });
        }
    },

    async getCategoryRecord(context, payload) {

        return new Promise((resolve, reject) => {
            axios.get(payload.url + payload.id)
                .then(response => {
                    resolve(response);
                })
                .catch(errors => {
                    if (errors.response.data.errors) {
                        // this.onFailedSubmit(errors.response.data.errors);
                        reject(errors.response.data.errors);
                    } else {
                        // this.onFailedSubmit(errors.response);
                        reject(errors.response);
                    }
                });
        });
    },
    async confirmation(context, payload) {
        const result = await Swal.fire({
            title: payload.title,
            text: payload.text,
            type: payload.type,
            showCancelButton: true,
            confirmButtonClass: "md-button md-success",
            cancelButtonClass: "md-button md-danger",
            confirmButtonText: payload.confirmButtonText,
            buttonsStyling: false
        });
        if (result.value) {
            return new Promise((resolve, reject) => {
                axios.post(payload.url + payload.id)
                    .then(response => {
                        Swal.fire({
                            title: payload.confirmTile,
                            text: payload.confirmTxt,
                            type: "success",
                            confirmButtonClass: "md-button md-success",
                            buttonsStyling: false
                        });
                        resolve(response);
                    })
                    .catch(errors => {
                        if (errors.response.data.errors) {
                            // this.onFailedSubmit(errors.response.data.errors);
                            reject(errors.response.data.errors);
                        } else {
                            // this.onFailedSubmit(errors.response);
                            reject(errors.response);
                        }
                    });
            });
        }
    },


    searchPermissions(context, string) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.user.token
        const url = `api/search/permission`
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios.post(url, {
                    string: string,
                })
                    .then(response => {
                        resolve(response)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            })
        }
    },

    getGroupActivityReport(context) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("api/report/workshop?year=" + context.state.reportRequest.year + '&type=' + context.state.reportRequest.type)
                    .then(response => {
                        response = response.data
                        context.commit("SET_REPORT_RESPONSE", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getMonthlyActivity(context, payload) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("api/report/monthly?start_date=" + payload)
                    .then(response => {
                        response = response.data
                        context.commit("SET_REPORT_RESPONSE", response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getClientReport(context) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("api/report/clients?year=" + context.state.reportRequest.year)
                    .then(response => {
                        response = response.data
                        context.commit("SET_REPORT_RESPONSE", response)
                        console.log(response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    getDemographicReport(context) {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + context.state.user.token
        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                    .get("api/report/demographics?start_date=" + context.state.reportRequest.start_date + '&end_date=' + context.state.reportRequest.end_date)
                    .then(response => {
                        response = response.data
                        context.commit("SET_REPORT_RESPONSE", response)
                        console.log(response)
                        resolve(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                        reject(errors)
                    })
            })
        }
    },

    confirmSuccess(context, title) {
        Swal.fire({
            type: 'success',
            title: title,
            showConfirmButton: false,
            timer: 2500
        })
    },

}
