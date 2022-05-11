<template>
    <modal>
        <template slot="header">Client Action Plan</template>
        <template slot="header-button">
            <button @click="close" aria-label="close" class="delete"></button>
        </template>
        <div v-if="showCategorySelection">
            <h2>Please select sections to import</h2>

            <p>
                <label for="certLicense">Certification/Licensing</label>
                <input id="certLicense" type="checkbox" v-model="categoriesPicked" value="certLicense">
            </p>
            <p>
                <label for="credAssessmentImport">Credential Assessment</label>
                <input id="credAssessmentImport" type="checkbox" v-model="categoriesPicked" value="credAssessment">
            </p>
            <p><label for="docTranslationImport">Document Translation</label>
                <input id="docTranslationImport" type="checkbox" v-model="categoriesPicked" value="docTranslation">
            </p>
            <p><label for="trainingImport">Trainings</label>
                <input id="trainingImport" type="checkbox" v-model="categoriesPicked" value="training">
            </p>
            <p><label for="localExperienceImport">Local Experience</label>
                <input id="localExperienceImport" type="checkbox" v-model="categoriesPicked" value="localExperience">
            </p>
            <p><label for="altCareersImport">Alternate Careers</label>
                <input id="altCareersImport" type="checkbox" v-model="categoriesPicked" value="altCareers">
            </p>
            <p><label for="mentoringImport">Mentoring</label>
                <input id="mentoringImport" type="checkbox" v-model="categoriesPicked" value="mentoring">
            </p>
            <p><label for="portfolioWorkshopImport">Portfolio Workshop</label>
                <input id="portfolioWorkshopImport" type="checkbox" v-model="categoriesPicked" value="portfolioWorkshop">
            </p>
            <p><label for="otherResourcesImport">Other Resources</label>
                <input id="otherResourcesImport" type="checkbox" v-model="categoriesPicked" value="otherResources">
            </p>

            <p>
                <button class="button is-info" @click="importFilteredAptemplate(aptemplateImport.id)">Next</button>
            </p>

        </div>
        <div v-if="filteredTemplate || aptemplateEdit || clientapImport">
            <form @submit.prevent="saveClientap()" id="addClientapForm" method="post">
                <div class="md-layout">

                    <div class="md-title" v-if="aptemplateEdit">{{aptemplateEdit.noc.code + " - " +
                        aptemplateEdit.noc.title}}
                    </div>
                    <div class="md-title" v-else-if="aptemplateImport">{{filteredTemplate.noc.code + " - " + filteredTemplate.noc.title}}
                    </div>
                    <div class="md-title" v-else-if="clientapImport">{{clientapImport.noc.code + " - " + clientapImport.noc.title}}
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                            <div class="md-field md-theme-default md-has-value">
                                <label for="category">Category</label>
                                <select v-model="category" class="select md-menu md-select"
                                        id="category" name="category">
                                    <option disabled selected value="">Please select a category</option>
                                    <option :key="index" :value="category.value"
                                            v-for="(category, index) in categories"> {{ category.name }}
                                    </option>
                                </select>
                            </div>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100"
                         v-if="category==='certificationLicensing'">
                        <md-field>
                            <label for="certLicense">Certification/ Licensing</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="certLicense"
                                id="certLicense"
                                v-model="form.certLicense">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('certLicense')"
                                  v-text="form.errors.get('certLicense')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true"
                                     :options="certLicenseReferrals" label="name" track-by="id"
                                     v-model="form.certLicenseReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='credentialAssessment'">
                        <md-field>
                            <label for="credAssessment">Credential Assessment</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="credAssessment"
                                id="credAssessment"
                                v-model="form.credAssessment">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('credAssessment')"
                                  v-text="form.errors.get('credAssessment')"></span>
                        </md-field>

                        <label>Referrals</label>

                        <md-field>
                            <multiselect :multiple="true"
                                         :options="credAssessmentReferrals" label="name" track-by="id"
                                         v-model="form.credAssessmentReferrals"></multiselect>
                        </md-field>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='documentTranslation'">
                        <md-field>
                            <label>Document Translation</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="docTranslation"
                                v-model="form.docTranslation">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('docTranslation')"
                                  v-text="form.errors.get('docTranslation')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true"
                                     :options="docTranslationReferrals" label="name" track-by="id"
                                     v-model="form.docTranslationReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='training'">
                        <md-field>
                            <label>Training</label>
                            <!-- <md-textarea v-model="form.training" name="training"></md-textarea> -->
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="training"
                                v-model="form.training">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('training')"
                                  v-text="form.errors.get('training')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true" :options="trainingReferrals" label="name"
                                     track-by="id" v-model="form.trainingReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='localExperience'">
                        <md-field>
                            <label>Local Experience</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="localExperience"
                                v-model="form.localExperience">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('localExperience')"
                                  v-text="form.errors.get('localExperience')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true"
                                     :options="localExperienceReferrals" label="name" track-by="id"
                                     v-model="form.localExperienceReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='alternativeCareer'">
                        <md-field>
                            <label>Alternative Career</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="altCareers"
                                v-model="form.altCareers">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('altCareers')"
                                  v-text="form.errors.get('altCareers')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true" :options="altCareersReferrals"
                                     label="name" track-by="id" v-model="form.altCareersReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='mentoringNetworking'">
                        <md-field>
                            <label>Mentoring / Networking</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="mentoring"
                                v-model="form.mentoring">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('mentoring')"
                                  v-text="form.errors.get('mentoring')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true" :options="mentoringReferrals"
                                     label="name" track-by="id" v-model="form.mentoringReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='portfolioWorkshop'">
                        <md-field>
                            <label>Portfolio Workshop</label>
                            <ckeditor
                                :config="editorConfig"
                                :editor="editor"
                                name="portfolioWorkshop"
                                v-model="form.portfolioWorkshop">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('portfolioWorkshop')"
                                  v-text="form.errors.get('portfolioWorkshop')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true"
                                     :options="portfolioWorkshopReferrals" label="name" track-by="id"
                                     v-model="form.portfolioWorkshopReferrals"></multiselect>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100" v-if="category==='otherResources'">
                        <md-field>
                            <label>Other Resources</label>
                            <ckeditor
                                name="otherResources"
                                v-model="form.otherResources">
                            </ckeditor>
                            <span class="help is-danger" v-if="form.errors.has('otherResources')"
                                  v-text="form.errors.get('otherResources')"></span>
                        </md-field>

                        <label>Referrals</label>
                        <multiselect :multiple="true" :options="otherResourcesReferrals"
                                     label="name" track-by="id" v-model="form.otherResourcesReferrals"></multiselect>

                    </div>
                </div>
            </form>
        </div>

        <template slot="footer" v-if="!showCategorySelection">
            <button v-if="aptemplateEdit" class="button is-success" form="addClientapForm" type="submit">
                <span> Save </span>
                <span class="icon is-small">
                    <i class="far fa-save"></i>
                </span>
            </button>

            <button v-else class="button is-success" form="addClientapForm" type="submit">
                <span> Create </span>
                <span class="icon is-small">
                    <i class="far fa-save"></i>
                </span>
            </button>
            <button @click="close" class="button">Cancel</button>
        </template>

    </modal>
</template>

<script>
    import Form from '../../Forms'

    import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
    import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
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
    import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote';
    import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat';

    export default {
        name: 'addClientapForm',

        props: {
            aptemplateImport: '',
            clientapImport: '',
            aptemplateEdit: '',
            client_id: '',
            clientmeeting_id: '',
            staff_id: '',
        },

        created() {
            if (this.aptemplateEdit) {
                this.form.editForm(this.form, this.aptemplateEdit)
                this.getTemplateReferrals(this.aptemplateEdit.aptemplate_id)
                this.getClientReferrals(this.aptemplateEdit.id)
            } else if (this.aptemplateImport) {
                this.showCategorySelection = true
                this.getTemplateReferrals(this.aptemplateImport.id)
            } else if (this.clientapImport) {
                this.form.editForm(this.form, this.clientapImport)
                this.form.clientmeeting_id = this.clientmeeting_id
                this.getTemplateReferrals(this.clientapImport.aptemplate_id)
                this.getClientReferrals(this.clientapImport.id)
            }
        },

        data() {
            return {
                loading: false,
                saveDisabled: false,
                category: '',
                selectedReferrals: '',
                showCategorySelection: false,
                categoriesPicked: [],
                filteredTemplate: '',
                templateReferrals: [],
                clientReferrals: [],

                form: new Form({
                    aptemplate_id: '',
                    client_id: this.client_id,
                    clientmeeting_id: this.clientmeeting_id,
                    staff_id: this.staff_id,
                    noc: '',
                    certLicense: '',
                    certLicenseReferrals: '',
                    credAssessment: '',
                    credAssessmentReferrals: '',
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
            },
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

        watch: {
            noc: function () {
                this.form.errors.clear('noc')
            },
        },

        methods: {
            close() {
                this.$emit('close');
            },

            getClientReferrals(id) {
                axios.get('/api/clientaps/referrals/' + id)
                .then(response => {
                    this.clientReferrals = response.data
                    this.form.certLicenseReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'certificationLicensing'
                    })
                    this.form.credAssessmentReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'credentialAssessment'
                    })
                    this.form.docTranslationReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'documentTranslation'
                    })
                    this.form.trainingReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'training'
                    })
                    this.form.localExperienceReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'localExperience'
                    })
                    this.form.altCareersReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'alternativeCareer'
                    })
                    this.form.mentoringReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'mentoringNetworking'
                    })
                    this.form.portfolioWorkshopReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'portfolioWorkshop'
                    })
                    this.form.otherResourcesReferrals = this.clientReferrals.filter(el => {
                        return el.pivot.category === 'otherResources'
                    })
                })
            },

            getTemplateReferrals(id) {
                axios.get('/api/aptemplates/referrals/' + id)
                .then(response => {
                    this.templateReferrals = response.data
                })
            },

            importFilteredAptemplate(id) {
                if (this.aptemplateImport) {
                    axios.post('/api/aptemplates/filter/' + id, {
                        categoriesPicked: this.categoriesPicked
                    })
                        .then(response => {
                            this.filteredTemplate = response.data
                            this.showCategorySelection = false
                            this.form.editForm(this.form, this.filteredTemplate)
                            this.form.aptemplate_id = this.filteredTemplate.id
                        })
                        .catch(errors => {
                            console.log(errors)
                        })
                }
            },

            saveClientap() {
                this.saveDisabled = true
                if (this.aptemplateEdit) {
                    this.form.putWithoutReset('/api/clientaps/' + this.aptemplateEdit.id)
                        .then(response => {
                            this.saveDisabled = true
                            this.$store.dispatch('confirmSuccess', 'Action Plan Saved.')
                            this.getClientReferrals(response.data.id)
                        })
                        .catch(errors => {
                            this.saveDisabled = false
                            console.log(errors)
                        })
                } else {
                    this.form.post('/api/clientaps')
                        .then(response => {
                            this.saveDisabled = false
                            this.close()
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
