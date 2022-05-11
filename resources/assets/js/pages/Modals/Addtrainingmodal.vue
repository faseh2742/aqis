<template>
    <modal>
        <template v-if="trainingEdit" slot="header">Edit Training/ Certification / Professional Affiliation</template>
        <template v-else slot="header">Add Training/ Certification / Professional Affiliation</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <form method="post" @submit.prevent="saveTraining()" id="addTrainingForm" @keydown="form.errors.clear($event.target.name)">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Name of Training/ Certification / Professional Affiliation</label>
                        <md-input v-model="form.subject" type="text" name="subject"></md-input>
                    </md-field>
                     <span class="help is-danger" v-if="form.errors.has('subject')"
                            v-text="form.errors.get('subject')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Association/ School</label>
                        <md-input v-model="form.association" type="text" name="association"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('association')"
                            v-text="form.errors.get('association')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="training_year">Year</label>
                            <select class="select md-menu md-select" v-model="form.training_year" name="training_year" id="training_year" @change="form.errors.clear($event.target.name)">
                                <option value="2030">2030</option>
                                <option value="2029">2029</option>
                                <option value="2028">2028</option>
                                <option value="2027">2027</option>
                                <option value="2026">2026</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                            </select>
                        </div>
                    </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value" @click="form.errors.clear('country')">
                            <label for="country">Country</label>
                            <CountryList v-model="form.country"></CountryList>

                        </div>
                    </md-field> <span class="help is-danger" v-if="form.errors.has('country')"
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
            <button class="button is-success" type="submit" form="addTrainingForm" :disabled="saveDisabled">
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
import Form from "../../Forms.js"
import CountryList from '../CountryList'

export default {
    name: 'AddTrainingModal',

    props: {
        client_id: '',
        trainingEdit: '',
    },

    created() {
    },

    mounted() {
        if (this.trainingEdit) {
            this.form.editForm(this.form, this.trainingEdit)
        }

    },

    computed: {},

    data() {
        return {
            loading: false,
            saveDisabled: false,
            form: new Form({
                client_id: this.client_id,
                subject: '',
                association: '',
                training_year: '',
                country: '',
                notes: '',
            }),
        }
    },
    components: {
        CountryList,
    },

    methods: {
        close() {
            this.$emit('close');
        },
        yearList() {
            let date = new Date()
            let currentYear = date.getFullYear()
            let yearList = []

            for (let i = currentYear; i > 1964; i--) {
                yearList.push(i)
            }
            console.log(yearList)
            return yearList;
        },
        saveTraining() {
            this.saveDisabled = true
            if (this.trainingEdit) {
                this.form.put('api/training/' + this.trainingEdit.id)
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Training Saved.')
                        this.saveDisabled = false
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            } else {
                this.form.post('api/training')
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Training Saved.')
                        this.saveDisabled = false
                        this.$store.state.trainings.push(response)
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
