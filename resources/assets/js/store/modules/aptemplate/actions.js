export default {
    findAptemplate(context){
 axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                 .get('/api/aptemplates/find/' + context.state.selectNoc)
                
                .then(response => {
                    response = response.data
                    context.commit('SET_APTEMPLATE', response)
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    
    },
    addAptemplate (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .post('/api/aptemplates', {
                    noc: context.state.aptemplate.noc,
                    category: context.state.aptemplate.category,
                    cert_license: context.state.aptemplate.cert_license,
                    credential_eval: context.state.aptemplate.credential_eval,
                    docs_trans: context.state.aptemplate.docs_trans,
                    training: context.state.aptemplate.training,
                    bridging: context.state.aptemplate.bridging,
                    language: context.state.aptemplate.language,
                    further_education: context.state.aptemplate.further_education,
                    trades: context.state.aptemplate.trades,
                    workplace_exp: context.state.aptemplate.workplace_exp,
                    alt_career: context.state.aptemplate.alt_career,
                    mentoring: context.state.aptemplate.mentoring,
                    visible: 1,
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
    
    updateAptemplate (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        const url = `api/aptemplates/${context.state.aptemplate.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    noc: context.state.aptemplate.noc,
                    category: context.state.aptemplate.category,
                    cert_license: context.state.aptemplate.cert_license,
                    credential_eval: context.state.aptemplate.credential_eval,
                    docs_trans: context.state.aptemplate.docs_trans,
                    training: context.state.aptemplate.training,
                    bridging: context.state.aptemplate.bridging,
                    language: context.state.aptemplate.language,
                    further_education: context.state.aptemplate.further_education,
                    trades: context.state.aptemplate.trades,
                    workplace_exp: context.state.aptemplate.workplace_exp,
                    alt_career: context.state.aptemplate.alt_career,
                    mentoring: context.state.aptemplate.mentoring,
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

    getAptemplate (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                // .get('/api/aptemplates/' + context.state.aptemplate.id)
                .get('/api/aptemplates/'+context.state.client.id)
                .then(response => {
                    response = response.data
                    context.commit('SET_APTEMPLATE', response)
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },

    getClientAptemplate (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .get('/api/clientaps/' + context.state.clientap.id)
                .then(response => {
                    response = response.data
                    context.commit('SET_APTEMPLATE', response)
                    resolve(response)
                })
                .catch (errors => {
                    console.log(errors)
                    reject(errors)
                })
            })
        }
    },
    
    
    xmlToJson(xml) {
        // Create the return object
        let obj = {};
      
        if (xml.nodeType === 1) { // element
          // do attributes
          if (xml.attributes.length > 0) {
            obj['@attributes'] = {};
            for (let j = 0; j < xml.attributes.length; j += 1) {
              const attribute = xml.attributes.item(j);
              obj['@attributes'][attribute.nodeName] = attribute.nodeValue;
            }
          }
        } else if (xml.nodeType === 3) { // text
          obj = xml.nodeValue;
        }
      
        // do children
        // If just one text node inside
        if (xml.hasChildNodes() && xml.childNodes.length === 1 && xml.childNodes[0].nodeType === 3) {
          obj = xml.childNodes[0].nodeValue;
        } else if (xml.hasChildNodes()) {
          for (let i = 0; i < xml.childNodes.length; i += 1) {
            const item = xml.childNodes.item(i);
            const nodeName = item.nodeName;
            if (typeof (obj[nodeName]) === 'undefined') {
              obj[nodeName] = xmlToJson(item);
            } else {
              if (typeof (obj[nodeName].push) === 'undefined') {
                const old = obj[nodeName];
                obj[nodeName] = [];
                obj[nodeName].push(old);
              }
              obj[nodeName].push(xmlToJson(item));
            }
          }
        }
        return obj;
    },
    

    
    updateClientAptemplate (context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token
        const url = `api/clientaps/${context.state.clientaps.id}`
        if (context.rootGetters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios
                .put(url, {
                    client_id: context.state.clientaps.client_id,
                    facilitator: context.state.clientaps.facilitator,
                    noc: context.state.clientaps.noc,
                    category: context.state.clientaps.category,
                    cert_license: context.state.clientaps.cert_license,
                    credential_eval: context.state.clientaps.credential_eval,
                    docs_trans: context.state.clientaps.docs_trans,
                    training: context.state.clientaps.training,
                    bridging: context.state.clientaps.bridging,
                    language: context.state.clientaps.language,
                    further_education: context.state.clientaps.further_education,
                    trades: context.state.clientaps.trades,
                    workplace_exp: context.state.clientaps.workplace_exp,
                    alt_career: context.state.clientaps.alt_career,
                    mentoring: context.state.clientaps.mentoring,
                    visible: 1,
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

    searchAptemplate (context, string) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token
        const url = `api/search/aptemplate`
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