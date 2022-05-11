// function getCookie(name)
//     {
//     var re = new RegExp(name + "=([^;]+)");
//     var value = re.exec(document.cookie);
//     return (value != null) ? unescape(value[1]) : null;
//     }
// var ctoken = document.write(getCookie("access_token"))
// var ltoken = localStorage.getItem('access_token')

// if (ltoken === ctoken) {
//     match = true;
// }

export default {

    user: {
        name: $cookies.get('firstName') || null,
        token: $cookies.get('access_token') || null,
        role: null,
        permission: {},
        refresh_token: $cookies.get('refresh_token') || null,
        isFetchingToken: null,
    },
    refresh: null,
    dropdown_id: '',
    category_id: '',
    dropdowns: '',
    referrals: '',
    categories: '',
    staffList: '',
    facilitators:[],
    clients:[],
    educations: [],
    trainings: [],
    employments: [],
    meetings: [],
    workshops: [],
    aptemplates: [],
    clientaps: [],
    nocList: [],
    reportRequest:{},
    reportResponse:[],
    chartData:{},
    showAptemplateModal: false,
    showSearchModal: false,
    showSavingModal: false,

    currentap:{},
    currentMeeting:-1,
    authorization: {},

    role:{},

    roleTable:{},

    clientsLastPage: false,
    staffPage: '',
    clientPage: '',
    acionTempPage: '',
    docs:[],
}
