<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add City</p>
                    <button class="delete" aria-label="close" @click="close"></button>
                </header>
                <section class="modal-card-body">
                    <form method="post" @submit.prevent="saveCity()" id="addCityForm" @keydown="form.errors.clear($event.target.name)">

                        <div class="md-layout">
                            <div class="md-layout-item md-medium-size-100 md-size-50">
                                <label>
                                    City
                                </label>
                                <md-field>
                                    <md-input name="item" v-model="form.city" type="text"></md-input>
                                    <span class="help is-danger" v-if="form.errors.has('city')"
                                      v-text="form.errors.get('city')"></span>
                                </md-field>
                            </div>

                            <div class="md-layout-item">
                                <md-field>
                                    <div class="md-field md-theme-default md-has-value">
                                        <label for="province">Province</label>
                                        <select class="select md-menu md-select" v-model="form.province" name="province" id="province">
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
                            </div>
                        </div>

                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" type="submit" form="addCityForm" :disabled="saveDisabled">
                        <span>Save</span>
                        <span class="icon is-small">
                            <i class="far fa-save"></i>
                        </span>
                    </button>
                    <button class="button" @click="close">Cancel</button>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
    import Form from "../../Forms.js";

    export default {
        name: "AddCityModal",

        created() {
        },

        computed: {
        },

        data() {
            return {
                saveDisabled: false,
                users: [],
                form: new Form({
                    city: '',
                    province: '',
                }),
            };
        },
        components: {},

        methods: {
            close() {
                this.$emit("close");
            },
            saveCity() {
                this.saveDisabled = true
                return this.form.post('/api/city')
                    .then (response => {
                        this.close()
                        this.saveDisabled = false
                    })
                    .catch (error => {
                        console.log(error)
                        this.saveDisabled = false
                    })
            }
        }
    };
</script>
