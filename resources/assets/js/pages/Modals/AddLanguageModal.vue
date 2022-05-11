<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add Language</p>
                    <button class="delete" aria-label="close" @click="close"></button>
                </header>
                <section class="modal-card-body">
                    <form method="post" @submit.prevent="saveLanguage()" id="addLanguageForm" @keydown="form.errors.clear($event.target.name)">

                        <div class="md-layout">
                            <label class="md-layout-item md-size-15 md-form-label">
                                Language
                            </label>
                            <div class="md-layout-item">
                                <md-field>
                                    <md-input name="item" v-model="form.language" type="text"></md-input>
                                </md-field>
                                <span class="help is-danger" v-if="form.errors.has('language')"
                                      v-text="form.errors.get('language')"></span>
                            </div>
                        </div>

<!--                        <div class="md-layout">-->
<!--                            <label class="md-layout-item md-size-15 md-form-label">-->
<!--                                Status-->
<!--                            </label>-->
<!--                            <div class="md-layout-item">-->
<!--                                <md-radio name="status" v-model="form.status" :value=1 @change="form.errors.clear('status')">Active</md-radio>-->
<!--                                <md-radio name="status" v-model="form.status" :value=0 @change="form.errors.clear('status')">Inactive</md-radio>-->
<!--                                <span class="help is-danger" v-if="form.errors.has('status')"-->
<!--                                      v-text="form.errors.get('status')"></span>-->
<!--                            </div>-->
<!--                        </div>-->

                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" type="submit" form="addLanguageForm" :disabled="saveDisabled">
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
        name: "AddLanguageModal",

        created() {
        },

        computed: {
        },

        data() {
            return {
                saveDisabled: false,
                users: [],
                form: new Form({
                    language: '',
                }),
            };
        },
        components: {},

        methods: {
            close() {
                this.$emit("close");
            },
            saveLanguage() {
                this.saveDisabled = true
                return this.form.post('/api/language')
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
