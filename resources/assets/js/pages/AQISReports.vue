<template>
    <div>
        <div class="columns">
            <div class="column is-10 is-offset-1" name="table">
                <br />
                <a class="button is-success is-active no-print" @click="createPDF">
                    <span>Create PDF</span>
                    <span class="icon is-small">
                        <i class="fas fa-print"></i>
                    </span>
                </a>
                <h1 class="title is-2 no-print">AQIS {{ name }} Report</h1>
                <div class="table-container">
                    <table
                        class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7 landscape"
                    >
                        <thead>
                            <tr>
                                <th>Months</th>
                                <th
                                    colspan="2"
                                    v-for="(month, index) in months"
                                    :key="index"
                                >{{ month }}</th>

                                <th></th>
                                <th colspan="2">Totals</th>
                            </tr>
                            <tr class="rotate">
                                <th>Welcome Centre Locations</th>
                                <td v-for="index in 24" :key="index">{{ getAlternate(index) }}</td>
                                <td></td>
                                <td v-for="index in 2" :key="'A'+index">{{ getAlternate(index) }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(location, index) in locations" :key="index">
                                <td>{{ location }}</td>
                                <template v-for="(month, index)  in tableData[location]">
                                    <td
                                        v-bind:key="index"
                                    >{{ tableData[location][index][alternates[0]] }}</td>
                                    <td
                                        v-bind:key="index+1"
                                    >{{ tableData[location][index][alternates[1]] }}</td>
                                </template>
                                <td>
                                    <span v-if="index == Object.keys(locations).length - 1">&darr;</span>
                                </td>
                                <td>{{ totalValueByLocation(location, alternates[0]) }}</td>
                                <td>{{ totalValueByLocation(location, alternates[1]) }}</td>
                            </tr>
                            <tr>
                                <th>Total WC AQIS {{ name }}</th>
                                <template v-for="(month, index) in months">
                                    <th
                                        v-bind:key="month"
                                    >{{ totalValueByMonth(month, alternates[0], 'welcome centre') }}</th>
                                    <th
                                        v-bind:key="index"
                                    >{{ totalValueByMonth( month, alternates[1], 'welcome centre') }}</th>
                                </template>
                                <th>&rarr;</th>
                                <th>{{ getTotal(alternates[0], 'welcome centre') }}</th>
                                <th>{{ getTotal(alternates[1], 'welcome centre') }}</th>
                            </tr>
                            <tr>
                                <th>Total Mobile Unit AQIS {{ name }}</th>
                                <template v-for="(month, index) in months">
                                    <th
                                        v-bind:key="month"
                                    >{{ totalValueByMonth(month, alternates[0], 'mobile unit') }}</th>
                                    <th
                                        v-bind:key="index"
                                    >{{ totalValueByMonth( month, alternates[1], 'mobile unit') }}</th>
                                </template>
                                <th>&rarr;</th>
                                <th>{{ getTotal(alternates[0], 'mobile unit') }}</th>
                                <th>{{ getTotal(alternates[1], 'mobile unit') }}</th>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        responseData: null
    },

    data() {
        return {
            locations: null,
            tableData: null,
            year: null,
            name: null,
            alternates: null
        };
    },
    created() {
        if (!this.responseData) {
            return this.$store.dispatch("getRolePermission").then(() => {
                this.$router.push("/reports");
            });
        }
        this.locations = Object.keys(this.responseData.data);
        this.tableData = this.responseData.data;
        this.year = Number(this.responseData.year);
        this.name = this.responseData.name;
        this.alternates = this.responseData.alternates;
    },

    computed: {
        reportResponse() {
            return this.responseData;
        },
        requestParams() {
            return this.$store.state.reportRequest;
        },
        months() {
            let year = this.year;
            let nextYear = year + 1;
            return [
                "Apr-" + year,
                "May-" + year,
                "Jun-" + year,
                "Jul-" + year,
                "Aug-" + year,
                "Sep-" + year,
                "Oct-" + year,
                "Nov-" + year,
                "Dec-" + year,
                "Jan-" + nextYear,
                "Feb-" + nextYear,
                "Mar-" + nextYear
            ];
        }
    },
    data() {
        return {};
    },
    methods: {
        totalValueByMonth(month, type, locType) {
            let total = 0;
            Object.entries(this.tableData).forEach(([key, value]) => {
                if (key.toLowerCase().includes(locType)) {
                    total += value[month][type];
                }
            });
            return total;
        },

        totalValueByLocation(location, type) {
            let total = 0;
            Object.entries(this.tableData[location]).forEach(([key, value]) => {
                total += value[type];
            });
            return total;
        },

        getTotal(type, locType) {
            let total = 0;
            Object.entries(this.tableData).forEach(([key1, value1]) => {
                if (key1.toLowerCase().includes(locType)) {
                    Object.entries(value1).forEach(([key2, value2]) => {
                        total += value2[type];
                    });
                }
            });
            return total;
        },

        getAlternate(index) {
            return index % 2 ? this.alternates[0] : this.alternates[1];
        },

        writeRotatedText(text) {
            var ctx,
                canvas = document.createElement("canvas");
            canvas.width = 50;
            canvas.height = 300;
            ctx = canvas.getContext("2d");
            ctx.font = "36pt Arial";
            ctx.save();
            ctx.rotate(0.5 * Math.PI);
            ctx.fillStyle = "#000";
            ctx.fillText(text, 0, 0);
            ctx.restore();
            return canvas.toDataURL();
        },

        // method creates the pdfmake table from the returned results
        formatTable(input) {
            let tableData = [];

            // header row
            let headerRow1 = [];
            headerRow1.push({
                text: "Months",
                style: "headerText"
            });

            for (let i = 0; i < this.months.length; i++) {
                headerRow1.push({
                    text: this.months[i],
                    style: "headerText",
                    colSpan: 2
                });
                headerRow1.push({ text: "" });
            }
            headerRow1.push({
                text: ""
            });
            headerRow1.push({
                text: "Totals",
                style: "headerText",
                colSpan: 2
            });
            headerRow1.push({ text: "" });

            tableData.push(headerRow1);

            // alternating row
            let altRow = [];
            altRow.push({
                text: "Welcome Centre Locations",
                style: "headerText"
            });

            for (let i = 1; i <= 24; i++) {
                altRow.push({
                    image: this.writeRotatedText(this.getAlternate(i)),
                    fit: [7, 53],
                    alignment: "center"
                });
            }
            altRow.push({
                text: ""
            });

            altRow.push({
                image: this.writeRotatedText(this.getAlternate(1)),
                fit: [7, 53],
                alignment: "center"
            });
            altRow.push({
                image: this.writeRotatedText(this.getAlternate(0)),
                fit: [7, 53],
                alignment: "center"
            });

            tableData.push(altRow);

            // body
            for (let i = 0; i < this.locations.length; i++) {
                let bodyRow = [];
                bodyRow.push({
                    text: this.locations[i],
                    style: "bodyText"
                });
                for (let j = 0; j < 12; j++) {
                    bodyRow.push({
                        text: this.tableData[this.locations[i]][this.months[j]][
                            this.getAlternate(1)
                        ],
                        style: "bodyText"
                    });
                    bodyRow.push({
                        text: this.tableData[this.locations[i]][this.months[j]][
                            this.getAlternate(0)
                        ],
                        style: "bodyText"
                    });
                }
                bodyRow.push({
                    text: ""
                });

                bodyRow.push({
                    text: this.totalValueByLocation(
                        this.locations[i],
                        this.getAlternate(1)
                    ),
                    style: "bodyText"
                });

                bodyRow.push({
                    text: this.totalValueByLocation(
                        this.locations[i],
                        this.getAlternate(0)
                    ),
                    style: "bodyText"
                });
                tableData.push(bodyRow);
            }

            // total wC
            let totalWc = [];
            totalWc.push({
                text: "Total WC AQIS" + this.name,
                style: "headerText"
            });
            for (let i = 0; i < 12; i++) {
                totalWc.push({
                    text: this.totalValueByMonth(
                        this.months[i],
                        this.getAlternate(1),
                        "welcome centre"
                    ),
                    style: "headerText"
                });

                totalWc.push({
                    text: this.totalValueByMonth(
                        this.months[i],
                        this.getAlternate(0),
                        "welcome centre"
                    ),
                    style: "headerText"
                });
            }
            totalWc.push({
                text: "->"
            });

            totalWc.push({
                text: this.getTotal(this.getAlternate(1), "welcome centre"),
                style: "headerText"
            });
            totalWc.push({
                text: this.getTotal(this.getAlternate(0), "welcome centre"),
                style: "headerText"
            });

            tableData.push(totalWc);

            //total MU
            let totalMu = [];
            totalMu.push({
                text: "Total Mobile Unit AQIS " + this.name,
                style: "headerText"
            });
            for (let i = 0; i < 12; i++) {
                //console.log(this.months, this.months[0])
                totalMu.push({
                    text: this.totalValueByMonth(
                        this.months[i],
                        this.getAlternate(1),
                        "mobile unit"
                    ),
                    style: "headerText"
                });

                totalMu.push({
                    text: this.totalValueByMonth(
                        this.months[i],
                        this.getAlternate(0),
                        "mobile unit"
                    ),
                    style: "headerText"
                });
            }
            totalMu.push({
                text: "->"
            });

            totalMu.push({
                text: this.getTotal(this.getAlternate(1), "mobile unit"),
                style: "headerText"
            });
            totalMu.push({
                text: this.getTotal(this.getAlternate(0), "mobile unit"),
                style: "headerText"
            });

            tableData.push(totalMu);

            return tableData;
        },
        createPDF() {
            let dateText = "";
            if (this.start != null) {
                dateText = "From " + this.start + " to " + this.end;
            }

            var docDefinition = {
                pageSize: "legal",

                pageOrientation: "landscape",
                info: {
                    title: "AQISReport"
                },
                styles: {
                    headerText: {
                        fontSize: 10,
                        bold: true
                    },
                    bodyText: {
                        fontSize: 10
                    }
                },
                content: [
                    {
                        text: ["Created: " + new Date().toDateString()]
                    },
                    "\n",
                    {
                        text: "AQIS " + this.name + " Report",
                        style: { fontSize: 24, bold: true }
                    },
                    {
                        text: dateText,
                        style: { fontSize: 18, bold: true }
                    },

                    "\n",
                    {
                        table: {
                            headerRows: 1,
                            widths: [
                                70,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20,
                                20
                            ],
                            body: this.formatTable("age"),
                            style: { fontSize: 9 }
                        }
                    }
                ]
            };
            pdfMake.createPdf(docDefinition).open();
        }
    }
};
</script>
<style lang="scss">
.rotate {
    td {
        //width: 100%;
        text-align: left;

        vertical-align: middle;
        transform: rotate(90deg);
        width: 90px;
    }
}
@media print {
    .no-print {
        display: none !important;
    }
    ::-webkit-scrollbar {
        display: none;
    }
}
</style>
