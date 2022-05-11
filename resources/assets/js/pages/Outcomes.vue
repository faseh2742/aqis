<template>
    <div class="md-layout">
        <add-outcome-modal v-if="showOutcomeModal" @close="closeModal('outcomeModal')"></add-outcome-modal>
        <div class="md-progress-spinner-centre">
            <md-progress-spinner v-if="loading" class="md-progress-spinner-centre" md-mode="indeterminate">
            </md-progress-spinner>
        </div>
        <div class="md-layout-item md-size-100">
            <md-card>
                <md-card-header data-background-color="green">
                    <h3 class="title">Manage Outcomes</h3>
                    <p class="titleCategory">Customize client outcomes.</p>
                </md-card-header>
                <md-card-content>
                    <label><b>Select Category</b></label><br>
                    <div class="control select">
                        <select @change="getOutcomes()" name="category" id="category" v-model="category_id">
                            <option selected disabled>Please select a category.</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }} </option>
                        </select>
                    </div>
                    <a v-show="$root.canWrite('outcomes')" v-if="category_id" class="button is-link is-active" @click="showOutcomeModal = true">
                        <span>Add Outcome</span>
                        <span class="icon is-small">
                            <i class="fas fa-plus"></i>
                        </span>
                    </a>
                    <br>


                    <table class="md-layout-item md-medium-size-100 md-size-100">
                        <thead>
                            <tr class="md-table-row">
                                <th>Outcome</th>
                                <th>Status</th>
                                <th v-show="$root.canWrite('outcomes')">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="outcome in outcomes" :key="outcome.id"
                                :class="(outcome == editedOutcome) ? 'editing md-table-row' : 'md-table-row'" v-cloak>
                                <td>
                                    <span class="view"> {{ outcome.outcome }} </span>
                                    <span class="edit">
                                        <div class="md-layout-item">
                                            <md-field>
                                                <md-input v-model="form.outcome" type="text"></md-input>
                                            </md-field>
                                        </div>
                                    </span>
                                </td>
                                <td>
                                    <span class="view" v-if="outcome.status ==1">Active</span> 
                                    <span class="has-text-danger" v-else>Inactive</span>
                                    <span class="edit">

                                        <div class="md-layout">
                                            <div class="md-layout-item">
                                                <md-radio v-model="form.status" :value=1>Active</md-radio>
                                                <md-radio class="has-text-danger" v-model="form.status" :value=0>Inactive</md-radio>
                                            </div>
                                        </div>
                                    </span>
                                </td>
                                <td v-show="$root.canWrite('outcomes')">
                                    <md-button class="md-just-icon md-success view" @click="outcomeEdit(outcome)">
                                        <md-icon>edit</md-icon>
                                    </md-button>
                                    <md-button class="md-just-icon md-success edit" @click="updateOutcome(outcome.id)">
                                        <md-icon>save</md-icon>
                                    </md-button>
                                    <md-button v-show="$root.canDelete('outcomes')" class="md-just-icon md-danger view" @click="deleteOutcome(url , outcome.id, 'The dropdown item has been deleted.')">
                                        <md-icon>close</md-icon>
                                    </md-button>
                                    <md-button class="md-just-icon md-info edit" @click="editedOutcome = ''">
                                        <md-icon>cancel</md-icon>
                                    </md-button>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
import Form from '../Forms.js'
import AddOutcomeModal from './Modals/AddOutcomeModal'
import Swal from "sweetalert2"

export default {
    name: 'Outcomes',

    created() {
        // this.getOutcomes()
    },

    components: {
        AddOutcomeModal,
    },

    computed: {
        category_id: {
          get() {
            return this.$store.state.category_id
          },
          set(id) {
            this.$store.commit('SET_CATEGORY_ID', id)
          }
        },
        categories() {
          return this.$store.state.categories
        }
    },

    data() {
        return {
            loading: false,
            showOutcomeModal: false,
            outcomes: [],
            editedOutcome: '',
            editMode: false,
            url: '/api/getoutcomes/',
            form: new Form({
                category_id: this.category_id,
                outcome: '',
                status: '',
            })
        }
    },

    methods: {
        getOutcomes() {
            this.loading = true
            return axios.get(this.url + this.category_id)
                .then(response => {
                    this.outcomes = response.data.outcomes
                    this.loading = false
                })
                .catch(errors => {
                    this.loading = false
                })
        },
        closeModal(name) {
            switch (name) {
                case 'outcomeModal':
                    this.showOutcomeModal = false
                    this.getOutcomes()
                    break;
            }
        },
        outcomeEdit(outcome) {
            this.editedOutcome = outcome
            for (let field in outcome) {
                this.form[field] = outcome[field]
            }
            console.log(outcome)
        },
        saveOutcome() {
            this.loading = true
            return this.form.post(this.url)
                .then(response => {
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                    this.loading = false
                })
        },
        updateOutcome(id) {
            this.loading = true
            return this.form.put('/api/categories/' + id)
                .then(response => {
                    this.editedOutcome = ''
                    this.getOutcomes()
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                    this.loading = false
                })
        },
        deleteOutcome(url, id, confirmtxt) {
            this.form.deleteRecord('/api/category/', id, confirmtxt)
            .then(response => {
                if(response) {
                    this.getOutcomes()
                }
            })  
        }

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