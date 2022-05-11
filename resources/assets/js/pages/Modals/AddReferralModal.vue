<template>
    <modal>
        <template v-if="referralEdit" slot="header">Edit Referral</template>
        <template v-else slot="header">Add Referral</template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <form @submit.prevent="saveReferral()" id="referralForm" method="post" @input="form.errors.clear($event.target.name)">
            <div class="md-layout">

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Name</label>
                        <md-input v-model="form.name" type="text" name="name"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('name')"
                            v-text="form.errors.get('name')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Community</label>
                        <md-input v-model="form.community" type="text" name="community"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('community')"
                        v-text="form.errors.get('community')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Address</label>
                        <md-input v-model="form.address" type="text" name="address"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('address')"
                        v-text="form.errors.get('address')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Phone</label>
                        <md-input v-model="form.phone" type="tel" name="phone"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('phone')"
                            v-text="form.errors.get('phone')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Website</label>
                        <md-input v-model="form.website" type="text" name="website"></md-input>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('website')"
                        v-text="form.errors.get('website')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="categories">Category</label>
                            <multiselect v-model="form.categories" name="categories"
                            :options="categories" label="value" track-by="id" :multiple="true" :custom-label="categoryName"  @input="form.errors.clear('categories')"></multiselect>
                        </div>
                    </md-field>
                    <span class="help is-danger" v-if="form.errors.has('categories')"
                        v-text="form.errors.get('categories')"></span>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <div class="md-field md-theme-default md-has-value">
                            <label for="notes">Notes</label>
                            <md-textarea name="notes" v-model="form.notes"></md-textarea>
                        </div>
                    </md-field>
                </div>

            </div>
        </form>

        <template slot="footer">
            <button class="button is-success" type="submit" form="referralForm" :disabled="saveDisabled">
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
import Form from '../../Forms'

export default {
    name: 'AddReferralModal',

    props:{
        referralEdit: '',
    },

    created() {
        if (this.referralEdit) {
            this.form.editForm(this.form, this.referralEdit)
        }
    },

    computed: {
        categories() {
            return this.$store.state.categories
        }
    },

    data() {
        return {
            loading: false,
            saveDisabled: false,
            form: new Form({
                name: '',
                community: '',
                address: '',
                phone: '',
                website: '',
                notes: '',
                categories: '',
            }),
        }
    },

    methods: {
        close() {
            this.$emit('close')
        },

        update() {
            this.$emit('update')
        },

        categoryName({name}) {
            return name
        },

        saveReferral() {
            this.saveDisabled = true
            if (this.referralEdit) {
                this.form.put('/api/referrals/' + this.referralEdit.id)
                    .then(response => {
                        this.update()
                        this.saveDisabled = false
                    })
                    .catch(errors => {
                        console.log(errors)
                        this.saveDisabled = false
                    })
            } else {
                this.form.post('/api/referrals')
                    .then(response => {
                        this.update()
                        this.saveDisabled = false
                    })
                    .catch(errors => {
                        console.log(errors)
                        this.saveDisabled = false
                    })
            }
        },
    },
}
</script>
