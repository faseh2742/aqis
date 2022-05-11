<template>
    <modal>
        <template slot="header">Template Search</template>
        <template slot="header-button">
            <button @click="close" aria-label="close" class="delete"></button>
        </template>

        <div v-if="showTemplate" class="md-layout">

            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                    <label>Search</label>
                    <md-input @keyup="searchAptemplate" name="search" type="text" v-model="search"></md-input>
                    <span class="icon is-small is-left">
                        <i aria-hidden="true" class="fas fa-search"></i>
                        </span>
                </md-field>
            </div>
            <table class="table is-bordered is-striped is-hoverable is-fullwidth" v-if="aptemplates">
                <tr>
                    <th>NOC</th>
                    <th>Category</th>
                    <th class="is-narrow">Import</th>
                </tr>

                <tr :key="aptemplate.id" v-for="aptemplate in aptemplates">
                    <td v-if="aptemplate.noc"> {{ aptemplate.noc.code }}</td>
                    <td v-if="aptemplate.noc"> {{ aptemplate.noc.title }}</td>
                    <td>
                        <button @click="importAptemplate(aptemplate)"
                                class="button is-success">
                            <span><i class="fas fa-file-import"></i></span>
                        </button>
                    </td>
                </tr>

            </table>

        </div>
    </modal>
</template>

<script>
    export default {
        name: "AptemplateSearch",

        data() {
            return {
                search: "",
                aptemplates: "",
                showTemplate: true,
                showExisting: false
            };
        },

        methods: {
            close() {
                this.$emit("close");
            },

            importAptemplate(aptemplate) {
                this.$emit("import", aptemplate);
            },

            searchAptemplate() {
                if (this.search != "") {
                    axios
                        .post("/api/search/aptemplate", {
                            string: this.search
                        })
                        .then(response => {
                            this.aptemplates = response.data.data;
                        });
                } else {
                    this.aptemplates = "";
                }
            }
        }
    };
</script>
