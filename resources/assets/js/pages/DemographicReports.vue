<template>
    <div>
        <div class="columns container is-widescreen">
            <div class="column is-10 is-offset-1">
                <br />
                <a class="button is-success is-active no-print" @click="createPDF">
                    <span>Print Page</span>
                    <span class="icon is-small">
                        <i class="fas fa-print"></i>
                    </span>
                </a>
                <p class="title is-1">Demographic Report</p>
                <p class="subtitle is-3" v-show="start != null">From {{ start }} to {{ end }}</p>

                <table
                    class="table is-bordered is-striped is-narrow is-hoverable"
                    v-for="(table, tableIndex) in tableData"
                    :key="tableIndex"
                >
                    <thead>
                        <tr>
                            <th class="is-size-5" :colspan="table.rowTitles.length">{{ table.title }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th
                                v-for="(rowTitle, rowTitleIndex) in table.rowTitles"
                                :key="rowTitleIndex"
                            >{{ rowTitle }}</th>
                        </tr>

                        <tr v-for="(tableBody, bodyIndex) in table.body" :key="bodyIndex">
                            <td
                                v-for="(tableCol, tableColIndex) in tableBody"
                                :key="tableColIndex"
                            >{{ tableCol }}</td>
                        </tr>
                        <tr v-show="table.unknown">
                            <th>Unknown</th>
                            <th>{{ table.unknown }}</th>
                        </tr>
                        <tr>
                            <th v-if="table.rowTitles.length > 2" colspan="2">Total</th>
                            <th v-else>Total</th>
                            <th>{{ table.total }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
var pdfMake = require("pdfmake/build/pdfmake.js");
var pdfFonts = require("pdfmake/build/vfs_fonts.js");
pdfMake.vfs = pdfFonts.pdfMake.vfs;
export default {
    props: {
        responseData: null
    },

    data() {
        return {
            tableData: null,
            start: null,
            end: null
        };
    },
    created() {
        if (!this.responseData) {
            return this.$router.push("/reports");
        } else {
            this.tableData = this.responseData.data;
            this.start = this.responseData.start;
            this.end = this.responseData.end;
        }
    },

    computed: {
        reportResponse() {
            return this.responseData;
        }
    },
    data() {
        return {};
    },
    methods: {
        // method creates the pdfmake table from the returned results
        formatTable(input) {
            let tableData = [];

            //table title
            let tableTitle = [];
            tableTitle.push({
                text: this.tableData[input].title,
                style: { bold: true },
                colSpan: this.tableData[input].rowTitles.length
            });
            for (
                let i = 0;
                i < this.tableData[input].rowTitles.length - 1;
                i++
            ) {
                tableTitle.push({ text: "" });
            }
            tableData.push(tableTitle);

            // header row
            let titleRow = [];
            for (let i = 0; i < this.tableData[input].rowTitles.length; i++) {
                titleRow.push({
                    text: this.tableData[input].rowTitles[i],
                    style: { bold: true }
                });
            }
            tableData.push(titleRow);

            //body
            for (let i = 0; i < this.tableData[input].body.length; i++) {
                let tableRow = [];
                for (let col in this.tableData[input].body[i]) {
                    tableRow.push({
                        text: this.tableData[input].body[i][col],
                        style: {}
                    });
                }
                tableData.push(tableRow);
            }

            let footerColSpan = this.tableData[input].rowTitles.length;

            // unknowns
            let tableUnknown = [];

            if (this.tableData[input].unknown) {
                tableUnknown.push({
                    text: "Unknown",
                    style: { bold: true },
                    colSpan: footerColSpan - 1
                });
                for (let i = 0; i < footerColSpan - 2; i++) {
                    tableUnknown.push({
                        text: ""
                    });
                }
                tableUnknown.push({
                    text: this.tableData[input].unknown,
                    style: { bold: true }
                });
                tableData.push(tableUnknown);
            }

            let tableTotal = [];
            if (this.tableData[input].total) {
                tableTotal.push({
                    text: "Total",
                    style: { bold: true },
                    colSpan: footerColSpan - 1
                });
                for (let i = 0; i < footerColSpan - 2; i++) {
                    tableTotal.push({
                        text: ""
                    });
                }
                tableTotal.push({
                    text: this.tableData[input].total,
                    style: { bold: true }
                });
                tableData.push(tableTotal);
            }

            return tableData;
        },
        createPDF() {
            let dateText = "";
            if (this.start != null) {
                dateText = "From " + this.start + " to " + this.end;
            }
            let tables = [];
            for (let key in this.tableData) {
                tables.push({
                    table: {
                        headerRows: 1,
                        widths: "*",
                        body: this.formatTable(key)
                    },
                    style: { margin: [0, 5, 0, 15] }
                });
                tables.push("\n", "\n");
            }
            let tableData = this.formatTable("age");
            var docDefinition = {
                info: {
                    title: "AQISDemographicReport"
                },
                styles: {
                    header: {
                        fontSize: 15,
                        bold: true
                    }
                },
                content: [
                    {
                        text: ["Created: " + new Date().toDateString()]
                    },
                    "\n",
                    {
                        text: "Demographic Report",
                        style: { fontSize: 24, bold: true }
                    },
                    {
                        text: dateText,
                        style: { fontSize: 18, bold: true }
                    },

                    "\n",
                    tables
                ]
            };
            pdfMake.createPdf(docDefinition).open();
        }
    }
};
</script>
<style scoped>
th{
        width: 520px

} 
</style>
