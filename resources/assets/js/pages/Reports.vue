<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate"></md-progress-spinner>
            </div>
            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="green">
                        <h3 class="title">Reports</h3>
                        <p class="titleCategory">Current collection of data reports.</p>
                    </md-card-header>
                    <md-card-content>
                        <nav class="panel">
                            <div class="panel-block">
                                <div>
                                    <a
                                        class="button is-fullwidth is-info is-active"
                                        @click="showReport(0)"
                                    >Overview Report</a>
                                </div>&nbsp;
<!--                                <div>-->
<!--                                    <a-->
<!--                                        class="button is-fullwidth is-info is-active"-->
<!--                                        @click="showReport(1)"-->
<!--                                    >Group Activities</a>-->
<!--                                </div>&nbsp;-->
<!--                                <div>-->
<!--                                    <a-->
<!--                                        class="button is-fullwidth is-info is-active"-->
<!--                                        @click="showReport(2)"-->
<!--                                    >Client Meetings</a>-->
<!--                                </div>&nbsp;-->
<!--                                <div>-->
<!--                                    <a-->
<!--                                        class="button is-fullwidth is-info is-active"-->
<!--                                        @click="showReport(3)"-->
<!--                                    >Demographics</a>-->
<!--                                </div>&nbsp;-->
                            </div>

                            <div class="panel-block" v-show="tabToShow == 0">
                                <div class="section">
                                    <div class="container">
<!--                                        <p>Start Date: </p>-->
<!--                                        <p>-->
<!--                                            <select v-model="startMonthMonthly" name="startMonthMonthly" id="startMonthMonthly">-->
<!--                                                <option value="" selected disabled>Month</option>-->
<!--                                                <option v-for="month in months" :value="month.value"> {{ month.text }}</option>-->
<!--                                            </select>-->
<!--                                            <select v-model="startYearMonthly" name="startYearMonthly" id="startYearMonthly">-->
<!--                                                <option value="" selected disabled>Year</option>-->
<!--                                                <option v-for="year in years" :value="year"> {{ year }}</option>-->
<!--                                            </select>-->
<!--                                        </p>-->
<!--                                        <p>End Date: </p>-->
<!--                                        <p>-->
<!--                                            <select v-model="endMonthMonthly" name="endMonthMonthly" id="endMonthMonthly">-->
<!--                                                <option value="" selected disabled>Month</option>-->
<!--                                                <option v-for="month in months" :value="month.value"> {{ month.text }}</option>-->
<!--                                            </select>-->
<!--                                            <select v-model="endYearMonthly" name="startYearMonthly" id="endYearMonthly">-->
<!--                                                <option value="" selected disabled>Year</option>-->
<!--                                                <option v-for="year in years" :value="year"> {{ year }}</option>-->
<!--                                            </select>-->
<!--                                        </p>-->
                                        <div class="md-layout-item md-small-size-100 md-size-50">
                                            <label for="startDate">Start Date</label>
                                            <datepicker :bootstrap-styling="true" v-model="start" :format="dateFormater" id="startDate" @input=""></datepicker>

<!--                                            <span class="help is-danger" v-if="form.errors.has('start')"-->
<!--                                                  v-text="form.errors.get('start')"></span>-->
                                        </div>
                                        <div class="md-layout-item md-small-size-100 md-size-50">
                                            <label for="endDate">End Date</label>
                                            <datepicker :bootstrap-styling="true" v-model="end" :format="dateFormater" id="endDate" @input=""></datepicker>

<!--                                            <span class="help is-danger" v-if="form.errors.has('end')"-->
<!--                                                  v-text="form.errors.get('end')"></span>-->
                                        </div>
                                        <p>
                                            <button @click="generateMonthlyReport" class="button is-success">
                                                Generate Report
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-block" v-show="tabToShow == 1">
                                <h1>Group Activities</h1>
                            </div>
                            <div class="panel-block" v-show="tabToShow == 2">
                                <h1>Client Meetings</h1>
                            </div>
                            <div class="panel-block" v-show="tabToShow == 1 || tabToShow == 2">
                                <form
                                    method="post"
                                    @submit.prevent="onSubmit('generateReport')"
                                    id="generateReport"
                                    @input="valErrors[$event.target.name] = null"
                                >
                                    <table class="table">
                                        <tr>
                                            <th>Year</th>
                                            <td>
                                                <input name="year" v-model="year" type="text" />
                                                <span
                                                    class="help is-danger"
                                                    v-for="(error, index) in valErrors.year"
                                                    :key="index"
                                                >{{ error }}</span>
                                            </td>
                                        </tr>
                                        <tr v-show="tabToShow == 1">
                                            <th>Group Activity Type</th>
                                            <td>
                                                <select name="type" v-model="type">
                                                    <option
                                                        v-for="(type, index) in groupActivityTypes.items"
                                                        :key="index"
                                                        :value="type.item"
                                                        :selected="index === 0"
                                                    >{{ type.item }}</option>
                                                </select>
                                                <span
                                                    class="help is-danger"
                                                    v-for="(error, index) in valErrors.type"
                                                    :key="index"
                                                >{{ error }}</span>
                                            </td>
                                        </tr>
                                    </table>

                                    <button
                                        class="button is-success"
                                        style="justify-content: space-between;"
                                        type="submit"
                                        form="generateReport"
                                    >Generate Report</button>
                                </form>
                            </div>

                            <div class="panel-block" v-show="tabToShow == 3">
                                <h1>Demographics</h1>
                            </div>
                            <div class="panel-block" v-show="tabToShow == 3">
                                <form
                                    method="post"
                                    @submit.prevent="onSubmit('generateReport')"
                                    id="generateReport"
                                    @input="valErrors[$event.target.name] = null"
                                >
                                    <table class="table">
                                        <tr>
                                            <md-datepicker v-model="start_date" md-immediately>
                                                <label>Start</label>
                                            </md-datepicker>
                                            <span
                                                class="help is-danger"
                                                v-for="(error, index) in valErrors.start_date"
                                                :key="index"
                                            >{{ error }}</span>
                                        </tr>
                                        <tr>
                                            <md-datepicker v-model="end_date" md-immediately>
                                                <label>End</label>
                                            </md-datepicker>
                                            <span
                                                class="help is-danger"
                                                v-for="(error, index) in valErrors.end_date"
                                                :key="index"
                                            >{{ error }}</span>
                                        </tr>
                                    </table>

                                    <button
                                        class="button is-success"
                                        style="justify-content: space-between;"
                                        type="submit"
                                        form="generateReport"
                                    >Generate Report</button>
                                </form>
                            </div>
                        </nav>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
import AddTemplateModal from "./Modals/Addtemplatemodal.vue";
import Pagination from "./pagination.vue";
import AQISReportsVue from "./AQISReports.vue";
import moment from "moment";
import Datepicker from '@hokify/vuejs-datepicker';

let convert = require("xml-js");

export default {
    created() {
        this.generateYears()
        this.monthYear =  moment().format('MMMM YYYY');
    },

    components: {
        Datepicker
    },

    data() {
        return {
            loading: false,

            tabToShow: -1,
            months: [{text:"Jan", value:1},
                {text:"Feb", value:2},
                {text:"Mar", value:3},
                {text:"Apr", value:4},
                {text:"May", value:5},
                {text:"June", value:6},
                {text:"July", value:7},
                {text:"Aug", value:8},
                {text:"Sept", value:9},
                {text:"Oct", value:10},
                {text:"Nov", value:11},
                {text:"Dec", value:12}],
            years: [],
            start: '',
            end: '',
            startMonthMonthly: '',
            startYearMonthly: '',
            endMonthMonthly: '',
            endYearMonthly: '',
            clientStatus: "all",
            type: "",
            year: new Date().getFullYear(),
            start_date: "",
            end_date: "",
            valErrors: [],
            tableData: {
                forums: -1,
                forumsPart: 0,
                initialIrcc: 0,
                month: 0,
                repeatIrcc: 0,
                workshop: 0,
                workshopPart: 0
            },
            monthYear: ""
        };
    },
    computed: {
        programNames() {
            return this.getDropdownValues("Program Name");
        },
        groupActivityTypes() {
            return this.getDropdownValues("Group Activity Type");
        }
    },
    methods: {
        dateFormater(date) {
            return moment(date).format('YYYY-MM-DD')
        },
        generateYears() {
            var date  = new Date()
            var thisYear = date.getFullYear()
            this.years = []
            var i
            for (i=2018; i <= thisYear; i++){
                this.years.push(i)
            }
        },
        getDropdownValues(name) {
            let dropdown = { items: null };
            try {
                dropdown = this.$store.state.dropdowns.find(function(el) {
                    return el.name === name;
                });
            } catch (error) {}

            return dropdown;
        },
        showReport(tab) {
            this.tabToShow = tab;
        },

        generateMonthlyReport() {
            let routeData = this.$router.resolve({name:'AQIS Monthly Report', query: {start: this.dateFormater(this.start), end: this.dateFormater(this.end)}})
            window.open(routeData.href, '_blank')
        },

        onSubmit(report) {
            this.valErrors = [];
            let reportType = null;
            let reportName = null;
            switch (this.tabToShow) {
                case 1:
                    reportType = "getGroupActivityReport";
                    reportName = "AQIS Report";
                    this.$store.commit("SET_REPORT_REQUEST", {
                        year: this.year,
                        type: this.type
                    });
                    break;
                case 2:
                    reportType = "getClientReport";
                    reportName = "AQIS Report";
                    this.$store.commit("SET_REPORT_REQUEST", {
                        year: this.year,
                        type: this.type
                    });
                    break;
                case 3:
                    reportType = "getDemographicReport";
                    reportName = "Demographic Reports";
                    this.$store.commit("SET_REPORT_REQUEST", {
                        start_date: this.start_date
                            ? moment(this.start_date).format("YYYY-MM-DD")
                            : "",
                        end_date: this.end_date
                            ? moment(this.end_date).format("YYYY-MM-DD")
                            : ""
                    });
                    break;
            }

            this.$store
                .dispatch(reportType)
                .then(response => {
                    this.$router.push({
                        name: reportName,
                        params: {
                            responseData: response
                        }
                    });
                    // window.open("/#/reports/AQISReport", '_blank');
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.valErrors = error.response.data.errors;
                    }
                });
        },

        getMonthly() {
            let date = new Date();
            let firstOfMonth = new Date(date.getFullYear(), date.getMonth(), 1)
                .toISOString()
                .slice(0, 10);
            this.$store
                .dispatch("getMonthlyActivity", firstOfMonth)
                .then(response => {
                    this.tableData = response;
                });
        },

        getClientReport($year) {}
    }
};
</script>
