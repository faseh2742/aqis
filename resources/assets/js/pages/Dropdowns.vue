<template>
    <div class="md-layout">
        <AddItemModal v-if="showItemModal" @close="closeModal('itemModal')"></AddItemModal>
        <div class="md-progress-spinner-centre">
            <md-progress-spinner v-if="loading" class="md-progress-spinner-centre" md-mode="indeterminate">
            </md-progress-spinner>
        </div>
        <div class="md-layout-item md-size-100">
            <md-card>
                <md-card-header data-background-color="green">
                    <h3 class="title">Manage Dropdowns</h3>
                    <p class="titleCategory">Customized application dropdowns.</p>
                </md-card-header>
                <md-card-content>
                    <label><b>Select Dropdown</b></label><br>
                    <div class="control select">
                        <select @change="getDropdownItems()" name="dropdown" id="dropdown" v-model="dropdown_id">
                            <option selected disabled>Please select a dropdown.</option>
                            <option v-for="dropdown in dropdowns" :key="dropdown.id" :value="dropdown.id">
                                {{ dropdown.name }} </option>
                        </select>
                    </div>
                    <a v-show="$root.canWrite('dropdowns')" v-if="dropdown_id" class="button is-link is-active" @click="showItemModal = true">
                        <span>Add Item</span>
                        <span class="icon is-small">
                            <i class="fas fa-plus"></i>
                        </span>
                    </a>
                    <br>


                    <table class="md-layout-item md-medium-size-100 md-size-100">
                        <thead>
                            <tr class="md-table-row">
                                <th>Item</th>
                                <th>Status</th>
                                <th v-show="$root.canWrite('dropdowns')">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in dropdownItems" :key="item.id"
                                :class="(item == editedItem) ? 'editing md-table-row' : 'md-table-row'" v-cloak>
                                <td>
                                    <span class="view"> {{ item.item }} </span>
                                    <span class="edit">
                                        <div class="md-layout-item">
                                            <md-field>
                                                <md-input v-model="form.item" type="text"></md-input>
                                            </md-field>
                                        </div>
                                    </span>
                                </td>
                                <td>
                                    <span class="view" v-if="item.status == 1">Active</span> <span class="has-text-danger"
                                        v-else>Inactive</span>
                                    <span class="edit">

                                        <div class="md-layout">
                                            <div class="md-layout-item">
                                                <md-radio v-model="form.status" :value=1>Active</md-radio>
                                                <md-radio class="has-text-danger" v-model="form.status" :value=0>Inactive</md-radio>
                                            </div>
                                        </div>
                                    </span>
                                </td>
                                <td v-show="$root.canWrite('dropdowns')">
                                    <md-button class="md-just-icon md-success view" @click="itemEdit(item)">
                                        <md-icon>edit</md-icon>
                                    </md-button>
                                    <md-button class="md-just-icon md-success edit" @click="updateDropdown(item.id)">
                                        <md-icon>save</md-icon>
                                    </md-button>
                                    <md-button v-show="$root.canDelete('dropdowns')" class="md-just-icon md-danger view" @click="deleteDropdown(url , item.id, 'The dropdown item has been deleted.')">
                                        <md-icon>close</md-icon>
                                    </md-button>
                                    <md-button class="md-just-icon md-info edit" @click="editedItem = ''">
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
import {
    mapFields
} from 'vuex-map-fields'
import AddItemModal from './Modals/AddItemModal'
import Swal from "sweetalert2"

export default {
    name: 'Dropdowns',

    created() {
        this.fetchData()
        this.getDropdownItems()
    },

    components: {
        AddItemModal,
    },

    computed: {
        ...mapFields([
            'dropdown_id'
        ]),

    },

    data() {
        return {
            loading: false,
            showItemModal: false,
            dropdowns: [],
            dropdownItems: [],
            editedItem: '',
            editMode: false,
            url: '/api/dropdown/',
            form: new Form({
                dropdown_id: this.dropdown_id,
                item: '',
                status: '',
            })
        }
    },

    methods: {
        getDropdowns() {
            return this.$store.dispatch('getDropdowns')
        },
        getDropdownItems() {
            this.loading = true
            return axios.get(this.url + this.dropdown_id)
                .then(response => {
                    this.dropdownItems = response.data.items
                    this.loading = false
                })
                .catch(errors => {
                    this.loading = false
                })
        },
        fetchData() {
            this.loading = true
            return axios.all([this.getDropdowns(), ])
                .then(response => {
                    this.dropdowns = response[0]
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                    this.loading = false
                })
        },
        closeModal(name) {
            switch (name) {
                case 'itemModal':
                    this.showItemModal = false
                    this.getDropdowns()
                    this.getDropdownItems()
                    break;
            }
        },
        itemEdit(item) {
            this.editedItem = item
            for (let field in item) {
                this.form[field] = item[field]
            }
            console.log(item)
        },
        saveDropdown() {
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
        updateDropdown(id) {
            this.loading = true
            return this.form.put(this.url + id)
                .then(response => {
                    this.editedItem = ''
                    this.getDropdownItems()
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                    this.loading = false
                })
        },
        deleteDropdown(url, id, confirmtxt) {
            this.form.deleteRecord(url, id, confirmtxt)
            .then(response => {
                if(response) {
                    this.getDropdownItems()
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



        