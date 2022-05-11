<template>
    <modal>
        <template slot="header">Resources <br>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <a class="button is-primary is-active">
            <span>Add Resource</span>
            <span class="icon is-small">
                <i class="fas fa-plus-square"></i>
            </span>
        </a>
        </template>
        <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
        </template>
        <table class="table">
            <tr>
                <th>Program Name</th>
                <td width="30%"> {{ workshop.programName }} </td>
                <th>Workshop Type</th>
                <td> {{ workshop.type }} </td>
            </tr>
            <tr>
                <th>Group Activity Description</th>
                <td> {{ workshop.description }} </td>
                <th></th>
                <td></td>
            </tr>
            <tr>
                <th>Workshop start date</th>
                <td> {{ workshop.start_date }} </td>
                <th>Workshop end date</th>
                <td> {{ workshop.end_date }} </td>
            </tr>
            <tr>
                <th>Location</th>
                <td> {{ workshop.location }} </td>
                <th>Funder</th>
                <td> {{ workshop.funder }} </td>
            </tr>
            <tr>
                <th>Facilitator</th>
                <td> {{ workshop.staff.user.firstName + " " + workshop.staff.user.lastName }} </td>
            </tr>
            
             <tr>
                <th>Group Activity Duration (hh:mm)</th>
                <td> {{ workshop.duration }} </td>    
                <th></th>
                <td></td>       
            </tr>
        </table>
        <h1>
            Resources
        </h1>
        <div class="content">
            <ol type="1">
                <li v-for="(actionplan, index) in workshop.clientaps" :key="index">
                    <a href=""> {{ actionplan.noc.code }}</a>
                </li>
            </ol>
        </div>
        <template slot="footer">
            <button class="button" @click="close">Close</button>
        </template>
    </modal>
</template>

<script>
export default {
    name: 'workshopResourceModal',

    props: {
        workshop: '',
    },

    methods: {
        close() {
            this.$emit('close');
        },
    },
}
</script>