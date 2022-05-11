<template>
  <modal>
    <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>
    <template v-if="aptemplateEdit" slot="header">Edit Template</template>
    <template v-else slot="header">Add Template</template>
    <template slot="header-button">
        <button class="delete" aria-label="close" @click="close"></button>
    </template>
          <form method="post" @submit.prevent="saveAptemplate()" id="addTemplateForm">
            <div class="md-layout">


              <div class="md-layout-item md-small-size-100 md-size-100">
                  <md-field>
                    <label for="notes">Notes</label>
                    <md-textarea v-model="form.notes" id="notes"></md-textarea>
                  </md-field>
                </div>

              <div class="md-layout-item md-small-size-100 md-size-100">
                <label for="noc">NOC</label>
                    <multiselect v-model="form.noc" id="noc" :options="nocList" label="title" track-by="title" :custom-label="customLabel">
                        <template slot="singleLabel" slot-scope="props">
                            {{ props.option.code + " - [" + props.option.title + "]" }} </template>
                        <template slot="option" slot-scope="props">
                            {{ props.option.code + " - [" + props.option.title + "]"  }} </template>
                    </multiselect>
                    <span class="help is-danger" v-if="form.errors.has('noc')"
                            v-text="form.errors.get('noc')"></span>
                </div>
                <div v-if="aptemplateEdit" class="md-layout-item md-small-size-100 md-size-100">

                                 <label>
                                    Previous NOC
                                </label>
                                <md-field>
                                    <md-input name="prevNoc" v-model="form.prevNoc" type="text"></md-input>
                                    <span class="help is-danger" v-if="form.errors.has('prevNoc')"
                                      v-text="form.errors.get('prevNoc')"></span>
                                </md-field>
                </div>



                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="category">Category</label>
                            <select class="select md-menu md-select" name="category"
                                id="category" v-model="category">
                                <option value="" selected disabled>Please select a category</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.value"> {{ category.name }} </option>
                            </select>
                        </div>
                    </md-field>
                </div>


                <div v-if="category==='certificationLicensing'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label for="certLicense">Certification / Licensing</label>
                        <ckeditor
                            name="certLicense"
                            id="certLicense"
                            :editor="editor"
                            v-model="form.certLicense"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('certLicense')"
                            v-text="form.errors.get('certLicense')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.certLicenseReferrals" :options="referralsList('certificationLicensing')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='credentialAssessment'" class="md-layout-item md-small-size-100 md-size-100">
                    <label for="credAssessment">Credential Assessment</label>
                    <md-field>
                        <ckeditor
                            name="credAssessment"
                            :editor="editor"
                            v-model="form.credAssessment"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('credAssessment')"
                            v-text="form.errors.get('credAssessment')"></span>
                    </md-field>

                    <label>Referrals</label>

                    <md-field>
                      <multiselect v-model="form.credAssessmentReferrals" :options="referralsList('credentialAssessment')" label="name" track-by="id" :multiple="true"></multiselect>
                    </md-field>

                </div>

                <div v-if="category==='documentTranslation'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Document Translation</label>
                        <ckeditor
                            name="docTranslation"
                            :editor="editor"
                            v-model="form.docTranslation"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('docTranslation')"
                            v-text="form.errors.get('docTranslation')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.docTranslationReferrals" :options="referralsList('documentTranslation')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='training'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Training</label>
                        <ckeditor
                            name="training"
                            :editor="editor"
                            v-model="form.training"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('training')"
                            v-text="form.errors.get('training')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.trainingReferrals" :options="referralsList('training')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='localExperience'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Local Experience</label>
                        <ckeditor
                            name="localExperience"
                            :editor="editor"
                            v-model="form.localExperience"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('localExperience')"
                            v-text="form.errors.get('localExperience')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.localExperienceReferrals" :options="referralsList('localExperience')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='alternativeCareer'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Alternative Career</label>
                        <ckeditor
                            name="altCareers"
                            :editor="editor"
                            v-model="form.altCareers"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('altCareers')"
                            v-text="form.errors.get('altCareers')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.altCareersReferrals" :options="referralsList('alternativeCareer')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='mentoringNetworking'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Mentoring / Networking</label>
                        <ckeditor
                            name="mentoring"
                            :editor="editor"
                            v-model="form.mentoring"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('mentoring')"
                            v-text="form.errors.get('mentoring')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.mentoringReferrals" :options="referralsList('mentoringNetworking')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

                <div v-if="category==='portfolioWorkshop'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Portfolio Workshop</label>
                        <ckeditor
                            name="portfolioWorkshop"
                            :editor="editor"
                            v-model="form.portfolioWorkshop"
                            :config="editorConfig">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('portfolioWorkshop')"
                            v-text="form.errors.get('portfolioWorkshop')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect
                        v-model="form.portfolioWorkshopReferrals"
                        :options="referralsList('portfolioWorkshop')"
                        label="name"
                        track-by="id"
                        :multiple="true">
                    </multiselect>

                </div>

                <div v-if="category==='otherResources'" class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Other Resources</label>
                        <ckeditor
                            name="otherResources"
                            :editor="editor"
                            :config="editorConfig"
                            v-model="form.otherResources">
                        </ckeditor>
                        <span class="help is-danger" v-if="form.errors.has('otherResources')"
                            v-text="form.errors.get('otherResources')"></span>
                    </md-field>

                    <label>Referrals</label>
                    <multiselect v-model="form.otherResourcesReferrals" :options="referralsList('otherResources')" label="name" track-by="id" :multiple="true"></multiselect>

                </div>

            </div>
          </form>
       <template slot="footer">
            <button v-if="aptemplateEdit" class="button is-success" type="submit" form="addTemplateForm" :disabled="saveDisabled">
                <span> Save </span>
                <span class="icon is-small">
                    <i class="far fa-save"></i>
                </span>
            </button>

           <button v-else class="button is-success" form="addTemplateForm" type="submit">
               <span> Create </span>
               <span class="icon is-small">
                    <i class="far fa-save"></i>
                </span>
           </button>

            <button class="button" @click="close">Cancel</button>
        </template>
    </modal>
</template>

<script>
import Form from '../../Forms.js'

import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
import Font from '@ckeditor/ckeditor5-font/src/font';
import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold';
import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic';
import UnderlinePlugin from '@ckeditor/ckeditor5-basic-styles/src/underline'
import List from '@ckeditor/ckeditor5-list/src/list';
import LinkPlugin from '@ckeditor/ckeditor5-link/src/link';
import ParagraphPlugin from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import HeadingPlugin from '@ckeditor/ckeditor5-heading/src/heading';
import IndentPlugin from '@ckeditor/ckeditor5-indent/src/indent';
import IndentBlock from '@ckeditor/ckeditor5-indent/src/indentblock';
import PasteFromOffice from '@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';
import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote'
import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat';


export default {
    name: 'AddTemplateModal',

    props: {
        aptemplateEdit: '',
    },

    created() {
        if (this.aptemplateEdit) {
            this.form.editForm(this.form, this.aptemplateEdit)
            this.getAllReferrals()
            }
    },

    data() {
        return {
            loading: false,
            saveDisabled: false,
            category: '',
            selectedReferrals: '',

            form: new Form({
                noc: '',
                prevNoc:'',
                notes: '',
                credAssessment: '',
                credAssessmentReferrals: '',
                certLicense: '',
                certLicenseReferrals: '',
                docTranslation: '',
                docTranslationReferrals: '',
                training: '',
                trainingReferrals: '',
                localExperience: '',
                localExperienceReferrals: '',
                altCareers: '',
                altCareersReferrals: '',
                mentoring: '',
                mentoringReferrals: '',
                portfolioWorkshop: '',
                portfolioWorkshopReferrals: '',
                otherResources: '',
                otherResourcesReferrals: '',
            }),

            editor: ClassicEditor,
            editorConfig: {
                plugins: [
                    EssentialsPlugin,
                    BoldPlugin,
                    ItalicPlugin,
                    UnderlinePlugin,
                    List,
                    LinkPlugin,
                    ParagraphPlugin,
                    HeadingPlugin,
                    IndentPlugin,
                    IndentBlock,
                    PasteFromOffice,
                    Alignment,
                    BlockQuote,
                    Autoformat,
                ],

                toolbar: {
                    items: ['heading', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo', '|',
                        'bold', 'italic', 'underline', 'alignment', 'link', 'bulletedList', 'numberedList', 'blockQuote']
                },

                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    ]
                },
                indentBlock: {
                    offset: 1,
                    unit: 'em'
                },
            }
        }
    },

    computed: {
        nocList() {
            return this.$store.state.nocList
        },
        noc() {
        return this.form.noc
        },

        categories() {
            return this.$store.state.categories
        }
    },

    watch: {
        noc: function() {
          this.form.errors.clear('noc')

      },
      prevNoc: function() {
          this.form.errors.clear('prevNoc')

      },
    },

    methods: {
        customLabel ({ code, title }) {
            return `${code} – ${title}`
        },
        open() {
            this.$emit('open')
        },
        close() {
            this.$emit('close');
        },

        getCertLicenseReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/certificationLicensing")
        },
        getCredAssessmentReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/credentialAssessment")
        },
        getDocTranslationReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/documentTranslation")
        },
        getTrainingReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/training")
        },
        getLocalExperienceReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/localExperience")
        },
        getAltCareersReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/alternativeCareer")
        },
        getMentoringReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/mentoringNetworking")
        },
        getPortfolioWorkshopReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/portfolioWorkshop")
        },
        getOtherResourcesReferrals() {
          return axios.get('/api/aptemplates/referrals/' + this.aptemplateEdit.id + "/otherResources")
        },
        getAllReferrals() {
          axios.all([this.getCredAssessmentReferrals(), this.getCertLicenseReferrals(), this.getDocTranslationReferrals(),
          this.getTrainingReferrals(), this.getLocalExperienceReferrals(), this.getAltCareersReferrals(),
          this.getMentoringReferrals(), this.getPortfolioWorkshopReferrals(), this.getOtherResourcesReferrals()])
          .then(response => {
            this.form.credAssessmentReferrals = response[0].data
            this.form.certLicenseReferrals = response[1].data
            this.form.docTranslationReferrals = response[2].data
            this.form.trainingReferrals = response[3].data
            this.form.localExperienceReferrals = response[4].data
            this.form.altCareersReferrals = response[5].data
            this.form.mentoringReferrals = response[6].data
            this.form.portfolioWorkshopReferrals = response[7].data
            this.form.otherResourcesReferrals = response[8].data
          })
        },
        referralsList(category) {
          let referrals = this.$store.state.categories.find(function (el) {
                return el.value === category
            })
            if(referrals) {
                return referrals.referrals
            } else { return referrals = [] }
        },
        saveAptemplate() {
            this.saveDisabled = true
            if (this.aptemplateEdit) {
                this.form.putWithoutReset('/api/aptemplates/' + this.aptemplateEdit.id)
                    .then(response => {
                        this.saveDisabled = false
                        this.$store.dispatch('confirmSuccess', 'Action Plan Saved.')
                        this.getAllReferrals()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            } else {
                this.form.post('/api/aptemplates')
                    .then(response => {
                        this.saveDisabled = false
                        this.close()
                        this.$router.push('/aptemplates/' + response.data.id)
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            }
        },


    }
}

</script>

<style>

</style>
