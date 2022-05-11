<template>
   <div>
    <!-- <div class="select md-menu md-select"> -->
      <select
        class="select md-menu md-select"
        data-placeholder="Choose a Language..."
        v-model="value"

        v-on:input="$emit('input', $event.target.value)">
          <option value="" disabled selected>Choose a language...</option>
          <option v-for="(language,index) in languages" :value="language.language"  :key="index">
              {{ language.language }}
          </option>

      </select>

   </div>
</template>

<script>
export default
{
  props: {
      value:String,
      },

    created() {
      this.fetchData()
    },
    data() {
      return {
         languages: []
      }
    },
    methods: {
     async fetchData(){
          axios.get('/api/getLanguages')
              .then(response => {
                  console.log('Languages List', response.data)
                  this.languages = response.data
              })
              .catch(errors => {
                  console.log(errors)
              })
      }
    },
};
</script>
