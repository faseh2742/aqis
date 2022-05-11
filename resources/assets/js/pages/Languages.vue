<template>
    <div class="md-layout">
        <AddLanguageModal v-if="showLanguageModal" @close="closeModal"></AddLanguageModal>
        <div class="md-progress-spinner-centre">
            <md-progress-spinner v-if="loading" class="md-progress-spinner-centre" md-mode="indeterminate">
            </md-progress-spinner>
        </div>
        <div class="md-layout-item md-size-100">
            <md-card>
                <md-card-header data-background-color="green">
                    <h3 class="title">Manage Languages</h3>
                    <p class="titleCategory">Manage Language list.</p>
                </md-card-header>
                <md-card-content>
                    <div>
                        <p>
                            <a class="button is-link is-active" @click="showLanguageModal=true">
                                <span>Add Language</span>
                                <span class="icon is-small">
                                    <i class="far fa-plus-square"></i>
<!--                                            <i class="fas fa-user-plus"></i>-->
                                        </span>
                            </a>
                        </p>
                    </div>

                    <br>

                    <multiselect
                        v-model="languageSelected"
                        placeholder="Please select a language"
                        :options="languages"
                        label="language"
                        track-by="id"
                        :multiple="false"
                        style="max-width: 600px"
                        @select="optionSelected"
                        @remove="closeForm('edit')">
                    </multiselect>

                    <br>

                    <div v-if="showNewLanguageForm" class="md-medium" style="max-width: 600px">
                        <md-field>
                            <label>Language</label>
                            <md-input v-model="languageName"></md-input>
                        </md-field>
                    </div>

                    <div v-if="showEditLanguageForm" class="md-medium" style="max-width: 600px">
                        <md-field>
                            <label>Language</label>
                            <md-input v-model="editLanguage"></md-input>
                        </md-field>
                        <button class="button is-primary" @click.prevent="updateLanguage(languageSelected.id)">
                            Save
                        </button>
                        <button class="button is-danger" @click="deleteLanguage(languageSelected.id)">
                            Delete
                        </button>
                    </div>

                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
import AddLanguageModal from "./Modals/AddLanguageModal";

    export default {
        name: 'Languages',

        created() {
            this.fetchData()
        },

        components: {
            AddLanguageModal
        },

        computed: {
        },

        data() {
            return {
                loading: false,
                showLanguageModal: false,
                showNewLanguageForm: false,
                showEditLanguageForm: false,
                languages: [],
                languageSelected: null,
                newLanguage: '',
                editLanguage: '',
            }
        },

        methods: {
            fetchData() {
                this.loading = true
                axios.get('/api/language')
                .then(response => {
                    this.loading = false
                    this.languages = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },

            optionSelected(selectedOption) {
                this.languageSelected = selectedOption
                this.editLanguage = selectedOption.language
                this.showEditLanguageForm = true
            },

            updateLanguage(id) {
                axios.put('/api/language/' + id, {
                    language: this.editLanguage
                })
                .then(response => {
                    this.editLanguage = null
                    this.languageSelected = null
                    this.fetchData()
                })
                .catch (errors => {
                    console.log(errors)
                })
            },

            closeForm(name) {
                switch (name) {
                    case 'edit':
                        this.showEditLanguageForm = false
                        this.editLanguage = null
                        break;
                    case 'new':
                        this.showNewLanguageForm = false
                        this.newLanguage = null
                }
            },

            closeModal(){
                this.fetchData()
                this.showLanguageModal = false
            },

            deleteLanguage(id) {
                let payload = {
                    url: '/api/language/',
                    id: id,
                    confirmtxt: 'The language has been deleted.'
                }
                this.$store.dispatch('deleteRecord', payload)
                .then(response => {
                    this.editLanguage = null
                    this.languageSelected = null
                    this.fetchData()
                })
            },

        },
    }
</script>

<style scoped>
    [v-cloak] {
        display: none;
    }

    .edit {
        display: none;
    }

    .editing .edit {
        display: flex;
    }

    .editing .view {
        display: none;
    }
</style>
