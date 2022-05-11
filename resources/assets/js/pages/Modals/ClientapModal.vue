<template>
    <modal>
        <template slot="header">Action Plan <br>
            <a @click="print" class="button is-success is-active">
                <span> Print Template </span>
                <span class="icon is-small">
                    <i class="fas fa-print"></i>
                </span>
            </a>
        </template>
        <template slot="header-button">
            <button @click="close" aria-label="close" class="delete"></button>
        </template>
        <div id="actionplan">
            <table class="table is-bordered" style="table-layout: fixed; width: 100%">
                <col width="20%">
                <tr>
                    <th>NOC</th>
                    <td v-if="actionplan.noc"> {{actionplan.noc.code}}</td>
                </tr>
                <tr v-if="actionplan.noc">
                    <th>Category</th>
                    <td v-if="actionplan.noc"> {{actionplan.noc.title}}</td>
                </tr>

                <tr v-if="actionplan.certLicense">
                    <th>Certification / Licensing</th>
                    <td><span v-html="actionplan.certLicense"></span></td>
                </tr>
                <tr v-if="certLicenseReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in certLicenseReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.credAssessment">
                    <th>Credential Assessment</th>
                    <td><span v-html="actionplan.credAssessment"></span></td>
                </tr>
                <tr v-if="credAssessmentReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in credAssessmentReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.docTranslation">
                    <th>Documents Translation</th>
                    <td><span v-html="actionplan.docTranslation"></span></td>
                </tr>
                <tr v-if="docTranslationReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in docTranslationReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.training">
                    <th>Training</th>
                    <td><span v-html="actionplan.training"></span></td>
                </tr>
                <tr v-if="trainingReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in trainingReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.localExperience">
                    <th>Local Experience</th>
                    <td><span v-html="actionplan.localExperience"></span></td>
                </tr>
                <tr v-if="localExperienceReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in localExperienceReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.altCareers">
                    <th>Alternative Career</th>
                    <td><span v-html="actionplan.altCareers"></span></td>
                </tr>
                <tr v-if="altCareersReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in altCareersReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.mentoring">
                    <th>Mentoring / Networking</th>
                    <td><span v-html="actionplan.mentoring"></span></td>
                </tr>
                <tr v-if="mentoringReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in mentoringReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.portfolioWorkshop">
                    <th>Portfolio Workshop</th>
                    <td><span v-html="actionplan.portfolioWorkshop"></span></td>
                </tr>
                <tr v-if="portfolioWorkshopReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in portfolioWorkshopReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr v-if="actionplan.otherResources">
                    <th>Other Resources</th>
                    <td><span v-html="actionplan.otherResources"></span></td>
                </tr>
                <tr v-if="otherResourcesReferrals!=''">
                    <th>Referrals</th>
                    <td>
                        <table class="table is-narrow">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Website</th>
                            </tr>
                            <tr :key="index" v-for="(referral, index) in otherResourcesReferrals">
                                <td> {{ referral.name }}</td>
                                <td> {{ referral.phone }}</td>
                                <td> {{ referral.address }}</td>
                                <td> {{ referral.website }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </div>
        <template slot="footer">
            <button @click="close" class="button">Cancel</button>
        </template>
    </modal>
</template>

<script>

    export default {

        components: {},

        props: {
            actionplan: {},
        },

        created() {
            this.getAllReferrals()
        },

        data() {
            return {
                loading: true,
                templateReferrals: [],
                showAptemplateModal: false,
                aptemplateID: this.$route.params.id,
            }
        },

        computed: {
            certLicenseReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'certificationLicensing'
                })
            },
            credAssessmentReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'credentialAssessment'
                })
            },
            docTranslationReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'documentTranslation'
                })
            },
            trainingReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'training'
                })
            },
            localExperienceReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'localExperience'
                })
            },
            altCareersReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'alternativeCareer'
                })
            },
            mentoringReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === ''
                })
            },
            portfolioWorkshopReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'mentoringNetworking'
                })
            },
            otherResourcesReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'otherResources'
                })
            },
        },

        methods: {
            close() {
                this.$emit('close');
            },
            print() {
                // Pass the element id here
                this.$htmlToPaper('actionplan');
            },
            getAllReferrals() {
                axios.get('/api/clientaps/referrals/' + this.actionplan.id)
                    .then(response => {
                        this.templateReferrals = response.data
                    })
            },
            fetchData() {
                axios.all([this.getAptemplate()])
                    .then((response) => {
                        this.actionplan = response[0].data
                    })
                    .catch((errors) => {
                        console.log(errors)
                    })
            },
            editModal(name) {
                switch (name) {
                    case 'aptemplateModal':
                        this.showAptemplateModal = true;
                        break;
                }
            },
            closeModal(name) {
                switch (name) {
                    case 'aptemplateModal':
                        this.fetchData(this.aptemplateID)
                        this.getAllReferrals()
                        this.showAptemplateModal = false
                        break;
                }
            },
        }
    }

</script>

<style scoped>
    td {
        word-wrap: break-word
    }
</style>
