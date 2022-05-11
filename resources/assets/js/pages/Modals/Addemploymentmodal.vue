<template>
    <modal>
        <template v-if="employmentEdit" slot="header">Edit Employment</template>
        <template v-else slot="header">Add Employment</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <form method="post" @submit.prevent="saveEmployment()" id="addEmploymentForm" @keydown="form.errors.clear($event.target.name)">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <label>NOC</label>
                    <multiselect v-model="form.noc" name="noc" :options="noclist" label="title" track-by="title" :custom-label="customLabel" @input="form.errors.clear('noc')">
                        <template slot="singleLabel" slot-scope="props">
                            {{ props.option.code + " - [" + props.option.title + "]" }} </template>
                        <template slot="option" slot-scope="props">
                            {{ props.option.code + " - [" + props.option.title + "]"  }} </template>
                    </multiselect>
                    <span class="help is-danger" v-if="form.errors.has('noc')"
                            v-text="form.errors.get('noc')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Job Title</label>
                        <md-input v-model="form.job_title" type="text" name="job_title"></md-input>
                    </md-field>
                     <span class="help is-danger" v-if="form.errors.has('job_title')"
                            v-text="form.errors.get('job_title')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Years of Experience</label>
                        <md-input v-model="form.experience_years" type="number" min="1" name="experience_years">
                        </md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('experience_years')"
                            v-text="form.errors.get('experience_years')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value" @click="form.errors.clear('country')">
                            <label for="country">Country</label>
                            <CountryList v-model="form.country"></CountryList>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('country')"
                            v-text="form.errors.get('country')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Notes</label>
                        <md-textarea v-model="form.notes" name="notes"></md-textarea>
                        <span class="help is-danger" v-if="form.errors.has('notes')"
                            v-text="form.errors.get('notes')"></span>
                    </md-field>
                </div>

            </div>
        </form>
        <template slot="footer">
            <button class="button is-success" type="submit" form="addEmploymentForm" :disabled="saveDisabled">
                <span> Save </span>
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
import CountryList from '../CountryList'

export default {
    name: 'AddEmploymentModal',

    props: {
        client_id: '',
        employmentEdit: '',
    },

    created() {
    },

    mounted() {
        if (this.employmentEdit) {
            this.form.editForm(this.form, this.employmentEdit)
        }
    },

    computed: {
        noclist() {
            return this.$store.state.nocList
        },
    },


    data() {
        return {
            loading: false,
            saveDisabled: false,
            form: new Form({
                client_id: this.client_id,
                noc: '',
                job_title: '',
                field: '',
                experience_years: '',
                country: '',
                notes: '',

            })

        }
    },
    components: {
        CountryList,
    },

    methods: {
        close() {
            this.$emit('close');
        },
        customLabel ({ code, title }) {
            return `${code} – ${title}`
        },
        nocLabel({
            code,
            title
        }) {
            return `${code} — [${title}]`
        },
        saveEmployment() {
            this.saveDisabled = true
            if (this.employmentEdit) {
                this.form.put('api/employment/' + this.employmentEdit.id)
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Employment Saved.')
                        this.saveDisabled = false
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            } else {
                this.form.post('api/employment')
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Employment Saved.')
                        this.saveDisabled = false
                        this.$store.state.employments.push(response)
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
