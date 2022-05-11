<template>
    <!-- <div> -->
    <!-- <div class="select md-menu md-select"> -->
    <select
        class="select md-menu md-select"
        data-placeholder="Choose a City..."
        v-bind:value="value"
        v-on:input="$emit('input', $event.target.value)"
    >
        <option value="" disabled selected>Choose a city...</option>
        <option v-for="city in cities" :value="city.city" :key="city.id">
            {{ city.city }}
        </option>
    </select>
    <!-- </div> -->
    <!-- </div> -->
</template>

<script>
    export default {
        props: ["value"],

        created() {
            this.fetchData()
        },
        data() {
            return {
                cities: []
            }
        },
        methods: {
            fetchData(){
                axios.get('/api/getCities')
                    .then(response => {
                        this.cities = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }
        },
    };
</script>
