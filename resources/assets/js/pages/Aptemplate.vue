<template>
    <div class="content">
        <Addtemplatemodal :aptemplateEdit="aptemplate" @close="closeModal('aptemplateModal')"
                          @open="loading = false" v-if="showAptemplateModal"></Addtemplatemodal>

        <div class="md-layout">
            <div class="md-progress-spinner-centre">
                <md-progress-spinner md-mode="indeterminate" v-if="loading">
                </md-progress-spinner>
            </div>

            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="green">
                        <h4 class="title">{{aptemplate.category}} Action Plan Template</h4>
                    </md-card-header>
                    <md-card-content>
                        <nav class="panel">
                            <div class="panel-block">
                                <p>
                                    <a @click="editModal('aptemplateModal')" class="button is-info is-active"
                                       v-show="$root.canWrite('aptemplates')">
                                        <span> Edit Template </span>
                                        <span class="icon is-small">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    <a @click.prevent="deleteAptemplate" class="button is-danger is-active"
                                       v-show="$root.canDelete('aptemplates')">
                                        <span> Delete Template </span>
                                        <span class="icon is-small">
                                            <i class="fas fa-times"></i>
                                        </span>
                                    </a>
                                    <a @click="downloadPdf('aptemplate')" class="button is-success is-active">
                                        <span> Print Template </span>
                                        <span class="icon is-small">
                                            <i class="fas fa-print"></i>
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div class="panel-block">
                                <div id="aptemplate">
                                    <table class="table is-bordered"
                                           style="table-layout: fixed; width: 100%">
                                        <col width="20%">
                                        <tr>
                                            <th>NOC</th>
                                            <td v-if="aptemplate.noc"><strong> {{aptemplate.noc.code}} </strong></td>
                                        </tr>
                                         <tr>
                                            <th>Previous NOC</th>
                                            <td v-if="aptemplate.prevNoc"><strong> {{aptemplate.prevNoc}} </strong></td>
                                        </tr>
                                        <tr v-if="aptemplate.noc">
                                            <th>Category</th>
                                            <td v-if="aptemplate.noc"><strong> {{aptemplate.noc.title}} </strong></td>
                                        </tr>

                                        <tr v-if="aptemplate.notes">
                                            <th>Notes</th>
                                            <td v-if="aptemplate.notes"><em> {{aptemplate.notes}} </em></td>
                                        </tr>

                                        <tr v-if="aptemplate.certLicense">
                                            <th>Certification/ Licensing</th>
                                            <td><span v-html="aptemplate.certLicense"></span></td>
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


                                        <tr v-if="aptemplate.credAssessment">
                                            <th>Credential Assessment</th>
                                            <td><span v-html="aptemplate.credAssessment"></span></td>
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
                                                    <tr :key="index"
                                                        v-for="(referral, index) in credAssessmentReferrals">
                                                        <td> {{ referral.name }}</td>
                                                        <td> {{ referral.phone }}</td>
                                                        <td> {{ referral.address }}</td>
                                                        <td> {{ referral.website }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr v-if="aptemplate.docTranslation">
                                            <th>Documents Translation</th>
                                            <td><span v-html="aptemplate.docTranslation"></span></td>
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
                                                    <tr :key="index"
                                                        v-for="(referral, index) in docTranslationReferrals">
                                                        <td> {{ referral.name }}</td>
                                                        <td> {{ referral.phone }}</td>
                                                        <td> {{ referral.address }}</td>
                                                        <td> {{ referral.website }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr v-if="aptemplate.training">
                                            <th>Training</th>
                                            <td><span v-html="aptemplate.training"></span></td>
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

                                        <tr v-if="aptemplate.localExperience">
                                            <th>Local Experience</th>
                                            <td><span v-html="aptemplate.localExperience"></span></td>
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
                                                    <tr :key="index"
                                                        v-for="(referral, index) in localExperienceReferrals">
                                                        <td> {{ referral.name }}</td>
                                                        <td> {{ referral.phone }}</td>
                                                        <td> {{ referral.address }}</td>
                                                        <td> {{ referral.website }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr v-if="aptemplate.altCareers">
                                            <th>Alternative Career</th>
                                            <td><span v-html="aptemplate.altCareers"></span></td>
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

                                        <tr v-if="aptemplate.mentoring">
                                            <th>Mentoring / Networking</th>
                                            <td><span v-html="aptemplate.mentoring"></span></td>
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

                                        <tr v-if="aptemplate.portfolioWorkshop">
                                            <th>Portfolio Workshop</th>
                                            <td><span v-html="aptemplate.portfolioWorkshop"></span></td>
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
                                                    <tr :key="index"
                                                        v-for="(referral, index) in portfolioWorkshopReferrals">
                                                        <td> {{ referral.name }}</td>
                                                        <td> {{ referral.phone }}</td>
                                                        <td> {{ referral.address }}</td>
                                                        <td> {{ referral.website }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr v-if="aptemplate.otherResources">
                                            <th>Other Resources</th>
                                            <td><span v-html="aptemplate.otherResources"></span></td>
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
                                                    <tr :key="index"
                                                        v-for="(referral, index) in otherResourcesReferrals">
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
                            </div>

                        </nav>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
    var pdfMake = require('pdfmake/build/pdfmake.js');
    var pdfFonts = require('pdfmake/build/vfs_fonts.js');
    pdfMake.vfs = pdfFonts.pdfMake.vfs;
import htmlToPdfmake from "html-to-pdfmake"
    import Addtemplatemodal from './Modals/Addtemplatemodal.vue'

    export default {

        components: {
            Addtemplatemodal
        },

        created() {
            this.fetchData(this.aptemplateID)
            this.loading = false
            this.getAllReferrals()
        },

        data() {
            return {
                loading: true,
                aptemplate: [],
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
                    return el.pivot.category === 'mentoringNetworking'
                })
            },
            portfolioWorkshopReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'portfolioWorkshop'
                })
            },
            otherResourcesReferrals: function () {
                return this.templateReferrals.filter(function (el) {
                    return el.pivot.category === 'otherResources'
                })
            },
        },

        methods: {
            print() {
                // Pass the element id here
                this.$htmlToPaper('aptemplate');
            },
            getAptemplate() {
                return axios.get('/api/aptemplates/' + this.aptemplateID)
            },

            getAllReferrals() {
                axios.get('/api/aptemplates/referrals/' + this.aptemplateID)
                    .then(response => {
                        this.templateReferrals = response.data
                    })
            },
            fetchData() {
                axios.all([this.getAptemplate()])
                    .then((response) => {
                        this.aptemplate = response[0].data
                    })
                    .catch((errors) => {
                        console.log(errors)
                    })
            },
            downloadPdf(id)
 {
      var head ="Document For Action Plan";
      var headerText = htmlToPdfmake(head);
      var docDefinition = {
        pageSize: "A4",
        pageMargins: [10, 60, 10, 40],
        header: {
          columns: [{ text: headerText, alignment: "center" ,margin:[12,20,30,20]}],
        },
        content: htmlToPdfmake(document.getElementById("aptemplate").innerHTML),
        footer: {
          columns: [{ text: "Footer Text", alignment: "center" }],
        },
      };

      pdfMake.createPdf(docDefinition).open();
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
            deleteAptemplate(id) {
                let payload = {
                    url: '/api/aptemplates/',
                    id: this.aptemplateID,
                    confirmtxt: 'Templates has been deleted.'
                }
                this.$store.dispatch('deleteRecord', payload)
                    .then(response => {
                        if (response) {
                            this.$router.push('/aptemplates')
                        }
                    })
            }
        }
    }

</script>

<style scoped>
    td {
        word-wrap: break-word
    }
</style>

