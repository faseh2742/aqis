<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item">
                <p>
                    <b> IRCC AQIS Overview Report </b>
                    <br>
                    Reporting period: <b>{{ this.moment(this.start, 'MMMM Do YYYY') }} TO
                    {{ this.moment(this.end, 'MMMM Do YYYY') }} </b>
                    <br>
                    Author: <span v-if="this.meetings"> <b>{{ this.meetings.author.firstName + ' ' + this.meetings.author.lastName }} </b> </span>
                </p>
                <div>
                    <h1 align="center">Accreditation and Qualifications Information Services</h1>
                </div>
            </div>
        </div>
        <div style="text-align: center">
            <div>
                Client Meetings By Location:
            </div>
            <div>
                <table class="comicGreen md-alignment-center">
                    <tr>
                        <th>Location</th>
                        <th>New Clients</th>
                        <th>Repeat Clients</th>
                        <th>Client Meetings</th>
                    </tr>
                    <tr v-for="(location, index) in meetings.locations">
                        <td>{{ index }}</td>
                        <td><a @click="openLocationModal(location.initialRecords)"> {{ location.newClientCount }} </a></td>
                        <td><a @click="openLocationModal(location.repeatRecords)"> {{ location.repeatClientCount }} </a> </td>
                        <td><a @click="openLocationModal(location.records)"> {{ location.newClientCount +
                            location.repeatClientCount }} </a></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{ meetings.meetingInitialCount }}</th>
                        <th>{{ meetings.meetingRepeatCount }}</th>
                        <th>{{ meetings.meetingTotalCount }}</th>
                    </tr>
                </table>

                <app-modal :scrollable="true" height="auto" name="locationModal">
                    <div>
                        <table class="comicGreen">
                            <tr>
                                <th>WC ID</th>
                                <th>Name</th>
                            </tr>
                            <tr v-for="record in locationRecords">
                                <td>{{ record.client.wc_id }}</td>
                                <td>{{ record.client.user.firstName + " " + record.client.user.lastName }}</td>
                            </tr>
                        </table>
                    </div>
                </app-modal>
            </div>
            <br>

            <div>
                <p align="center">
                    <b>Details of Workshops</b>
                </p>
            </div>
            <div>
                <table class="comicGreen">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Title</th>
                        <th># of participants</th>
                    </tr>
                    <tr v-for="workshop in meetings.workshops.workshops">
                        <td>{{moment(workshop.start, "YYYY-MM-DD")}}</td>
                        <td>{{workshop.group_activity.description}}</td>
                        <td>{{workshop.group_activity.location}}</td>
                        <td>{{workshop.title}}</td>
                        <td>{{workshop.participants}}</td>
                    </tr>
                </table>
<!--                <div>-->
<!--                    <p>The cumulative total for the period from {{ this.moment(this.start, 'MMMM Do YYYY') }} to {{-->
<!--                        this.moment(this.end, 'MMMM Do YYYY') }}</p>-->
<!--                    <p># of Workshops: {{this.meetings.workshops.workshopCount}}</p>-->
<!--                    <p># of Attendees: {{this.meetings.workshops.attendeesCount}}</p>-->
<!--                </div>-->
            </div>
            <br>

            <div>
                <p align="center">
                    <b>Details of Forums</b>
                </p>
            </div>
            <div>
                <table class="comicGreen">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Title</th>
                        <th># of participants</th>
                    </tr>
                    <tr v-for="forum in meetings.forums.forums">
                        <td>{{moment(forum.start, "YYYY-MM-DD")}}</td>
                        <td>{{forum.group_activity.description}}</td>
                        <td>{{forum.group_activity.location}}</td>
                        <td>{{forum.title}}</td>
                        <td>{{forum.participants}}</td>
                    </tr>
                </table>
            </div>
            <br>

            <div>
                <p align="center">
                    <b>Details of Group Sessions</b>
                </p>
            </div>
            <div>
                <table class="comicGreen">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Title</th>
                        <th># of participants</th>
                    </tr>
                    <tr v-for="groupSession in meetings.groupSessions.groupSessions">
                        <td>{{moment(groupSession.start, "YYYY-MM-DD")}}</td>
                        <td>{{groupSession.group_activity.description}}</td>
                        <td>{{groupSession.group_activity.location}}</td>
                        <td>{{groupSession.title}}</td>
                        <td>{{groupSession.participants}}</td>
                    </tr>
                </table>
            </div>
            <br>

            <div class="md-layout-item md-alignment-center">
                <p align="center">
                    <b>Demographic Breakdown for New Clients</b>
                </p>
            </div>
            <div class="md-layout-item md-alignment-center">
                <div>
                    Geographical Locations:
                </div>
                <div>
                    <table class="comicGreen has-text-centered">
                        <tr>
                            <th>City</th>
                            <th>Clients</th>
                        </tr>
                        <tr v-for="(city, index) in meetings.cities">
                            <td>{{ index }}</td>
                            <td><a @click="openCityModal(city.records)"> {{ city.count }} </a></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                        </tr>
                    </table>
                    <app-modal :scrollable="true" height="auto" name="cityModal">
                        <div>
                            <table class="comicGreen">
                                <tr>
                                    <th>WC ID</th>
                                    <th>Name</th>
                                </tr>
                                <tr v-for="record in cityRecords">
                                    <td>{{ record.wc_id }}</td>
                                    <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                                </tr>
                            </table>
                        </div>
                    </app-modal>
                </div>
            </div>
            <br>
            <div class="md-layout-item md-alignment-center">
                <div>
                    Gender:
                </div>
                <table class="comicGreen">
                    <tr>
                        <th>Gender</th>
                        <th>Clients</th>
                    </tr>
                    <tr v-for="(gender, index) in meetings.genders">
                        <td> {{ index }}</td>
                        <td><a @click="openGenderModal(gender.records)"> {{ gender.count }} </a></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                    </tr>
                </table>
                <app-modal :scrollable="true" height="auto" name="genderModal">
                    <div>
                        <table class="comicGreen">
                            <tr>
                                <th>WC ID</th>
                                <th>Name</th>
                            </tr>
                            <tr v-for="record in genderRecords">
                                <td>{{ record.wc_id }}</td>
                                <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                            </tr>
                        </table>
                    </div>
                </app-modal>
            </div>
            <br>
            <div class="md-layout-item md-alignment-center">
                <div>
                    Age Ranges:
                </div>
                <table class="comicGreen">
                    <tr>
                        <th>Age Range</th>
                        <th>Clients</th>
                    </tr>
                    <tr>
                        <td> 17 - 24</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.seventeenToTwentyfour.records)"> {{ meetings.ageRanges.seventeenToTwentyfour.count }} </a></td>
                    </tr>
                    <tr>
                        <td> 25 - 34</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.twentyfiveToThirtyfour.records)"> {{ meetings.ageRanges.twentyfiveToThirtyfour.count }} </a></td>
                    </tr>
                    <tr>
                        <td> 35 - 45</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.thirtyfiveToFourtyfive.records)"> {{ meetings.ageRanges.thirtyfiveToFourtyfive.count }} </a></td>
                    </tr>
                    <tr>
                        <td> 46 - 59</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.fourtySixToFiftynine.records)"> {{ meetings.ageRanges.fourtySixToFiftynine.count }} </a></td>
                    </tr>
                    <tr>
                        <td> 60 +</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.sixtyPlus.records)"> {{ meetings.ageRanges.sixtyPlus.count }} </a></td>
                    </tr>
                    <tr>
                        <td> Unknown</td>
                        <td><a @click="openAgerangeModal(meetings.ageRanges.Unknown.records)"> {{ meetings.ageRanges.Unknown.count }} </a></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                    </tr>
                </table>
                <app-modal :scrollable="true" height="auto" name="agerangeModal">
                    <div>
                        <table class="comicGreen">
                            <tr>
                                <th>WC ID</th>
                                <th>Name</th>
                            </tr>
                            <tr v-for="record in agerangeRecords">
                                <td>{{ record.wc_id }}</td>
                                <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                            </tr>
                        </table>
                    </div>
                </app-modal>
            </div>
            <br>
            <div class="md-layout-item md-alignment-center">
                <div>
                    Immigration Status:
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>Immigration status</th>
                            <th>Clients</th>
                        </tr>
                        <tr v-for="(status, index) in meetings.immigrationStatuses">
                            <td> {{ index }}</td>
                            <td><a @click="openStatusModal(status.records)"> {{ status.count }} </a></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                        </tr>
                    </table>
                    <app-modal :scrollable="true" height="auto" name="statusModal">
                        <div>
                            <table class="comicGreen">
                                <tr>
                                    <th>WC ID</th>
                                    <th>Name</th>
                                </tr>
                                <tr v-for="record in statusRecords">
                                    <td>{{ record.wc_id }}</td>
                                    <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                                </tr>
                            </table>
                        </div>
                    </app-modal>
                </div>
            </div>
            <br>
            <div class="md-layout-item md-alignment-center">
                <div>
                    Country of Origin:
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>Country of Origin</th>
                            <th>Clients</th>
                        </tr>
                        <tr v-for="(country, index) in meetings.countriesOrigin">
                            <td> {{ index }}</td>
                            <td><a @click="openCountryModal(country.records)"> {{ country.count }} </a></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                        </tr>
                    </table>
                    <app-modal :scrollable="true" height="auto" name="countryModal">
                        <div>
                            <table class="comicGreen">
                                <tr>
                                    <th>WC ID</th>
                                    <th>Name</th>
                                </tr>
                                <tr v-for="record in countryRecords">
                                    <td>{{ record.wc_id }}</td>
                                    <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                                </tr>
                            </table>
                        </div>
                    </app-modal>
                </div>
            </div>

            <br>

            <div class="md-layout-item md-alignment-center">
                <div>
                    Mother Tongue:
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>Mother Tongue</th>
                            <th>Clients</th>
                        </tr>
                        <tr v-for="(language, index) in meetings.motherTongues">
                            <td> {{ index }}</td>
                            <td><a @click="openLanguageModal(language.records)"> {{ language.count }} </a></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th v-if="meetings.meetingInitialCount">{{ meetings.meetingInitialCount }}</th>
                        </tr>
                    </table>
                    <app-modal :scrollable="true" height="auto" name="languageModal">
                        <div>
                            <table class="comicGreen">
                                <tr>
                                    <th>WC ID</th>
                                    <th>Name</th>
                                </tr>
                                <tr v-for="record in languageRecords">
                                    <td>{{ record.wc_id }}</td>
                                    <td>{{ record.user.firstName + " " + record.user.lastName }}</td>
                                </tr>
                            </table>
                        </div>
                    </app-modal>
                </div>
            </div>

            <br>

            <div class="md-layout-item md-alignment-center">
                <div>
                    Highest Level of Education
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>Level of Education</th>
                            <th>Clients</th>
                        </tr>
                        <tr v-if="meetings.highestEducations.educations" v-for="(education, index) in meetings.highestEducations.educations">
                            <td> {{ index }}</td>
                            <td> {{ education.count }}</td>
                        </tr>
                        <tr v-if="meetings.highestEducations">
                            <th>Total</th>
                            <th>{{ meetings.highestEducations.total }}</th>
                        </tr>
                    </table>
                </div>
            </div>

            <br>

            <div class="md-layout-item md-alignment-center">
                <div>
                    National Occupational Classification (NOC)*:
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>NOC</th>
                            <th>Title</th>
                            <th>Total</th>
                        </tr>
                        <tr v-for="(noc, index) in meetings.nocs.nocs" v-if="meetings.nocs">
                            <td>
                                <div @click="openNocModal(noc.records)"> {{ noc.code }}</div>
                            </td>
                            <td> {{ noc.title }}</td>
                            <td> {{ noc.count }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Total</th>
                            <th v-if="meetings.nocs">{{ meetings.nocs.count }}</th>
                        </tr>
                    </table>
                </div>
            </div>

            <br>


            <div class="md-layout-item md-alignment-center">
                <div>
                    Referrals:
                </div>
                <div>
                    <table class="comicGreen">
                        <tr>
                            <th>Referral Agency</th>
                            <th>Total</th>
                        </tr>
                        <tr v-for="(referral, index) in meetings.referrals" v-if="meetings.referrals">
                            <td v-if="index!='total'"> {{ index }} </td>
                            <td v-if="index!='total'"> {{ referral }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th v-if="meetings.referrals">{{ meetings.referrals.total }}</th>
                        </tr>
                    </table>
                </div>
            </div>

            <br>

        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        name: "MonthlyReport",

        data() {
            return {
                meetings: '',
                start: this.$route.query.start,
                end: this.$route.query.end,
                locationRecords: '',
                cityRecords: '',
                genderRecords: '',
                agerangeRecords: '',
                statusRecords: '',
                countryRecords: '',
                languageRecords: ''
            }
        },

        created() {
            this.fetchData()
        },

        methods: {
            fetchData() {
                // axios.get('/api/reports/monthly?'
                //     + 'startMonthMonthly=' + this.startMonthMonthly + '&'
                //     + 'startYearMonthly=' + this.startYearMonthly + '&'
                //     + 'endMonthMonthly=' + this.endMonthMonthly + '&'
                //     + 'endYearMonthly=' + this.endYearMonthly)
                //     .then(response => {
                //         response = response.data
                //         this.meetings = response
                //         console.log(this.meetings)
                //     })

                axios.get('/api/reports/monthly?', {
                    params: {
                        start: this.start,
                        end: this.end
                    }
                })
                .then(response => {
                    this.meetings = response.data
                    console.log(this.meetings)
                })
            },

            moment(date, format) {
              return moment(date).format(format)
            },

            openLocationModal(records) {
                this.locationRecords = records
                this.$modal.show('locationModal')
            },
            openCityModal(records) {
                this.cityRecords = records
                this.$modal.show('cityModal')
            },
            openGenderModal(records) {
                this.genderRecords = records
                this.$modal.show('genderModal')
            },
            openAgerangeModal(records) {
                this.agerangeRecords = records
                this.$modal.show('agerangeModal')
            },
            openStatusModal(records) {
                this.statusRecords = records
                this.$modal.show('statusModal')
            },
            openCountryModal(records) {
                this.countryRecords = records
                this.$modal.show('countryModal')
            },
            openLanguageModal(records) {
                this.languageRecords = records
                this.$modal.show('languageModal')
            },

            // getStartDate(month, year) {
            //     var startDate = moment(year + '-' + month)
            //     return moment(startDate).startOf('month').format('ll')
            // },
            // getEndDate(month, year) {
            //     var endDate = moment(year + '-' + month)
            //     return moment(endDate).endOf('month').format('ll')
            // }
        }
    }
</script>

<style scoped>
    table.comicGreen {
        font-family: "Comic Sans MS", cursive, sans-serif;
        border: 2px solid #4F7849;
        background-color: #EEEEEE;
        width: 60%;
        text-align: center;
        border-collapse: collapse;
        margin-left: 15%;
        margin-right: 15%;
    }

    table.comicGreen td, table.comicGreen th {
        border: 1px solid #4F7849;
        padding: 3px 5px;
    }

    table.comicGreen tbody td {
        font-size: 19px;
        font-weight: bold;
        color: #4F7849;
    }

    table.comicGreen tr:nth-child(even) {
        background: #CEE0CC;
    }

    table.comicGreen tfoot {
        font-size: 21px;
        font-weight: bold;
        color: #FFFFFF;
        background: #4F7849;
        background: -moz-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
        background: -webkit-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
        background: linear-gradient(to bottom, #7b9a76 0%, #60855b 66%, #4F7849 100%);
        border-top: 1px solid #444444;
    }

    table.comicGreen tfoot td {
        font-size: 21px;
    }

</style>
