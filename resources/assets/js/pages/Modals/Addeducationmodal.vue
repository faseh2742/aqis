<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p v-if="educationEdit" class="modal-card-title">Edit Education</p>
          <p v-else class="modal-card-title">Add Education</p>
          <template slot="header-button">
            <button class="delete" aria-label="close" @click="close"></button>
          </template>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
          <md-card>
            <md-card-content>
              <form
                method="post"
                @submit.prevent="saveEducation()"
                @keydown="form.errors.clear($event.target.name)"
                @input="form.errors.clear($event.target.name)"
                id="addEducationForm"
              >
                <div class="md-layout">
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="education_level">Level of Education</label>
                        <select
                          class="select md-menu md-select"
                          v-model="form.education_level"
                          name="education_level"
                          id="education_level"
                        >
                          <option
                            v-for="(level, index) in educationLevels.items"
                            :key="index"
                            :value="level.item"
                          >{{ level.item }}</option>
                        </select>

                      </div>
                    </md-field>
                    <span
                          class="help is-danger"
                          v-if="form.errors.has('education_level')"
                          v-text="form.errors.get('education_level')"
                        ></span>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <div class="md-field md-theme-default md-has-value">
                        <label for="education_country">Country</label>
                        <CountryList name="education_country" v-model="form.education_country"></CountryList>
                      </div>
                    </md-field>
                    <span
                      class="help is-danger"
                      v-if="form.errors.has('education_country')"
                      v-text="form.errors.get('education_country')"
                    ></span>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Major</label>
                      <md-input v-model="form.major" type="text" name="major"></md-input>
                    </md-field>
                    <span
                      class="help is-danger"
                      v-if="form.errors.has('major')"
                      v-text="form.errors.get('major')"
                    ></span>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label for="graduation_date">Graduation Year</label>
                        <md-input name="graduation_date" v-model="form.graduation_date" type="text"></md-input>
                    </md-field>
                    <span
                      class="help is-danger"
                      v-if="form.errors.has('graduation_date')"
                      v-text="form.errors.get('graduation_date')"
                    ></span>
                  </div>

                </div>
              </form>
            </md-card-content>
          </md-card>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" type="submit" form="addEducationForm" :disabled="saveDisabled">
            <span>Save</span>
            <span class="icon is-small">
              <i class="far fa-save"></i>
            </span>
          </button>
          <button class="button" @click="close">Cancel</button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
import Form from "../../Forms.js";
import CountryList from "../CountryList";

export default {
  name: "AddEducationModal",

  props: {
    client_id: "",
    educationEdit: ""
  },

  created() {},

  mounted() {
    if (this.educationEdit) {
      this.form.editForm(this.form, this.educationEdit);
    }
  },

  computed: {
    educationLevels() {
      let educationLevels = this.$store.state.dropdowns.find(function(el) {
        return el.name === "Level of Education";
      });
      return educationLevels;
    }
  },

  data() {
    return {
      loading: false,
        saveDisabled: false,
      form: new Form({
        client_id: this.client_id,
        education_level: "",
        major: "",
        graduation_date: "",
        education_country: ""
      })
    };
  },

  components: {
    CountryList
  },

    methods: {
        close() {
            this.$emit('close');
        },
        saveEducation() {
            this.saveDisabled = true
            if (this.educationEdit) {
                this.form.put('api/education/' + this.educationEdit.id)
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Education Saved.')
                        this.saveDisabled = false
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            } else {
                this.form.post('api/education')
                    .then(response => {
                        this.$store.dispatch('confirmSuccess', 'Education Saved.')
                        this.saveDisabled = false
                        this.$store.state.educations.push(response)
                        this.close()
                    })
                    .catch(errors => {
                        this.saveDisabled = false
                        console.log(errors)
                    })
            }
        },
    }

};
</script>
