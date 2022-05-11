<template>
    <div class="content">

        <add-referral-modal :referralEdit="referralEdit" v-if="showReferralModal" @close="closeModal" @update="updateModal"></add-referral-modal>

        <div class="md-layout">
            <div class="md-progress-spinner-centre">
                <md-progress-spinner v-if="loading" md-mode="indeterminate">
                </md-progress-spinner>
            </div>
            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="green">
                        <h3 class="title">Referral Management</h3>
                        <p class="titleCategory">List of current referrals</p>
                    </md-card-header>
                    <md-card-content>
                        <nav class="panel">
                            <div v-show="$root.canWrite('referrals')" class="panel-block">
                                <p>
                                    <a class="button is-link is-active" @click="openModal">
                                        <span>Add Referral</span>
                                        <span class="icon is-small">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div class="panel-block">
                                <p class="control has-icons-left">
                                    <input class="input is-small" type="text" name="string" placeholder="search"
                                        v-model="search" @keyup="searchReferral">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="panel-block">

                                <table class="table is-bordered is-fullwidth">
                                    <tr>
                                        <th width="25%">Name</th>
                                        <!-- <th>Community</th> -->
                                        <th width="20%">Address</th>
                                        <th>Phone</th>
                                        <th>Website</th>
                                        <th>Category</th>
                                        <th>Last updated</th>
                                        <th v-show="$root.canWrite('referrals')" class="is-narrow">Edit</th>
                                        <th v-show="$root.canDelete('referrals')" class="is-narrow">Delete</th>
                                    </tr>
                                    <tr v-for="(referral, index) in referrals">
                                        <td>
                                            {{ referral.name }}
                                        </td>
                                        <!-- <td>
                                                {{ referral.community }}
                                        </td> -->
                                        <td>
                                                {{ referral.address }}
                                        </td>
                                        <td>
                                            <ul>
                                                <span v-html="createBullets(referral.phone)"></span>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <span v-html="createBullets(referral.website)"></span>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li v-for="(category, index) in referral.categories" :key="index">
                                                    {{ category.name }}
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            {{ moment(referral.updated_at).format("MMM Do YYYY") }}
                                        </td>
                                        <td v-show="$root.canWrite('referrals')"><button class="button is-success" @click="editModal(referral)">
                                                <span><i class="fas fa-pencil-alt"></i></span>
                                            </button>
                                        </td>
                                        <td v-show="$root.canDelete('referrals')"><button class="button is-danger" @click="deleteReferral(index, referral.id)">
                                                <span><i class="far fa-trash-alt"></i></span>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-block paginate" align="right">
                                <pagination :firstPage="firstPage" :previousPage="previousPage"
                                    :currentPage="currentPage" :nextPage="nextPage" :lastPage="lastPage"
                                    :totalPages="totalPages" :maxVisibleButtons="3" :url="url"
                                    @pageChanged="onPageChange($event)"></pagination>
                            </div>
                        </nav>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>

import Pagination from './pagination.vue'

import AddReferralModal from './Modals/AddReferralModal.vue'
import moment from 'moment'

export default {
    created() {
        this.fetchData()
    },
    components: {
        Pagination,
        AddReferralModal,
    },
    data() {
        return {
            loading: true,
            showReferralModal: false,
            referralEdit: '',
            referrals: [],
            search: '',
            referralsPerpage: [],
            firstPage: '',
            previousPage: '',
            currentPage: '',
            nextPage: '',
            lastPage: '',
            totalPages: '',
            url: '/api/referrals',
            moment: moment,
        }
    },
    computed: {},
    methods: {
        getReferrals(url) {
            return axios.get(url)
        },
        fetchData() {
            this.loading = true
            axios.all([this.getReferrals(this.url)])
                .then(response => {
                    this.referrals = response[0].data.data
                    this.firstPage = response[0].data.first_page_url
                    this.previousPage = response[0].data.prev_page_url
                    this.currentPage = response[0].data.current_page
                    this.nextPage = response[0].data.next_page_url
                    this.lastPage = response[0].data.last_page_url
                    this.totalPages = response[0].data.last_page
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                })

        },
        openModal() {
            this.referralEdit = null
            this.showReferralModal = true
        },
        closeModal() {
            this.showReferralModal = false
        },
        updateModal() {
            this.showReferralModal = false
            this.fetchData()
            this.$store.dispatch('getCategories')
        },
        editModal(item) {
            this.referralEdit = item
            this.showReferralModal = true
        },
        onPageChange(value) {
            this.loading = true
            this.getReferrals(value)
                .then(response => {
                    this.referrals = response.data.data
                    this.firstPage = response.data.first_page_url
                    this.previousPage = response.data.prev_page_url
                    this.currentPage = response.data.current_page
                    this.nextPage = response.data.next_page_url
                    this.lastPage = response.data.last_page_url
                    this.totalPages = response.data.last_page
                    this.loading = false
                })
                .catch(errors => {
                    console.log(errors)
                })
        },

        searchReferral() {
            if (this.search != "") {
                axios.post('/api/search/referrals', {
                        string: this.search
                    })
                    .then(response => {
                        this.referrals = response.data.data
                    })
            } else {
                this.fetchData()
            }

        },

        deleteReferral(index, id) {
            let payload = {
                url: '/api/referrals/',
                id: id,
                confirmtxt: 'Referral has been deleted.'
            }
            this.$store.dispatch('deleteRecord', payload)
                .then(response => {
                    if (response) {
                        this.referrals.splice(index, 1)
                    }
                })
        },
        createBullets(string) {
            if (string) {
                let stringArray = string.split(",")
                let listItem = []
                let result = stringArray.forEach(item => {
                    listItem = listItem + `<li>` + item + `</li>`
                })
                return listItem
            } else {
                return ''
            }
        }
    },
}

</script>
