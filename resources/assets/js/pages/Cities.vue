<template>
    <div class="md-layout">
        <AddCityModal v-if="showCityModal" @close="closeModal"></AddCityModal>
        <div class="md-progress-spinner-centre">
            <md-progress-spinner v-if="loading" class="md-progress-spinner-centre" md-mode="indeterminate">
            </md-progress-spinner>
        </div>
        <div class="md-layout-item md-size-100">
            <md-card>
                <md-card-header data-background-color="green">
                    <h3 class="title">Manage Cities</h3>
                    <p class="titleCategory">Manage City list.</p>
                </md-card-header>
                <md-card-content>
                    <div>
                        <p>
                            <a class="button is-link is-active" @click="showCityModal=true">
                                <span>Add City</span>
                                <span class="icon is-small">
                                    <i class="far fa-plus-square"></i>
                                </span>
                            </a>
                        </p>
                    </div>

                    <br>

                    <multiselect
                        v-model="citySelected"
                        placeholder="Please select a city"
                        :options="cities"
                        label="city"
                        :custom-label="customLabel"
                        track-by="id"
                        :multiple="false"
                        style="max-width: 600px"
                        @select="optionSelected"
                        @remove="closeForm('edit')">
                    </multiselect>

                    <br>

                    <div v-if="showEditCityForm" class="md-medium" style="max-width: 600px">
                        <form method="post" @submit.prevent="updateCity(citySelected.id)" id="updateCityForm" @keydown="form.errors.clear($event.target.name)">
                            <md-field>
                                <label>City</label>
                                <md-input v-model="form.editCity"></md-input>
                                <span class="help is-danger" v-if="form.errors.has('city')"
                                      v-text="form.errors.get('city')"></span>
                            </md-field>
                            <!--                        <div class="md-layout-item">-->
                            <md-field>
                                <div class="md-field md-theme-default md-has-value">
                                    <label for="province">Province</label>
                                    <select class="select md-menu md-select" v-model="form.editProvince" name="province" id="province">
                                        <option value="AB">Alberta</option>
                                        <option value="BC">British Columbia</option>
                                        <option value="MB">Manitoba</option>
                                        <option value="NB">New Brunswick</option>
                                        <option value="NL">Newfoundland and Labrador</option>
                                        <option value="NS">Nova Scotia</option>
                                        <option value="ON">Ontario</option>
                                        <option value="PE">Prince Edward Island</option>
                                        <option value="QC">Quebec</option>
                                        <option value="SK">Saskatchewan</option>
                                        <option value="NT">Northwest Territories</option>
                                        <option value="NU">Nunavut</option>
                                        <option value="YT">Yukon</option>
                                    </select>
                                </div>
                            </md-field>
                            <span class="help is-danger" v-if="form.errors.has('province')"
                                  v-text="form.errors.get('province')"></span>
                            <!--                        </div>-->
                            <button class="button is-success" type="submit" form="updateCityForm">
                                Save
                            </button>
                            <button class="button is-danger" @click="deleteCity(citySelected.id)">
                                Delete
                            </button>
                        </form>
                    </div>

                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
    import AddCityModal from "./Modals/AddCityModal";
    import Form from "../Forms.js"

    export default {
        name: 'cities',

        created() {
            this.fetchData()
        },

        components: {
            AddCityModal,
        },

        computed: {
        },

        data() {
            return {
                loading: false,
                showCityModal: false,
                showNewCityForm: false,
                showEditCityForm: false,
                cities: [],
                citySelected: null,
                newCity: '',
                form: new Form({
                    city: '',
                    province: '',
                })
            }
        },

        methods: {
            fetchData() {
                this.loading = true
                axios.get('/api/city')
                    .then(response => {
                        this.loading = false
                        this.cities = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },

            optionSelected(selectedOption) {
                this.citySelected = selectedOption
                this.form.editCity = selectedOption.city
                this.form.editProvince = selectedOption.province
                this.showEditCityForm = true
            },

            updateCity(id) {
                axios.put('/api/city/' + id, {
                    city: this.form.editCity,
                    province: this.form.editProvince
                })
                    .then(response => {
                        this.form.editCity = null
                        this.form.editProvince = null
                        this.citySelected = null
                        this.fetchData()
                    })
                    .catch (errors => {
                        console.log(errors)
                    })
            },

            customLabel ({city, province}) {
                return `${city} - ${province}`
            },

            closeForm(name) {
                switch (name) {
                    case 'edit':
                        this.showEditCityForm = false
                        this.editCity = null
                        break;
                    case 'new':
                        this.showNewCityForm = false
                        this.newCity = null
                }
            },

            closeModal(){
                this.fetchData()
                this.showCityModal = false
            },

            deleteCity(id) {
                let payload = {
                    url: '/api/city/',
                    id: id,
                    confirmtxt: 'The city has been deleted.'
                }
                this.$store.dispatch('deleteRecord', payload)
                    .then(response => {
                        this.form.editCity = null
                        this.form.editProvince = null
                        this.citySelected = null
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
