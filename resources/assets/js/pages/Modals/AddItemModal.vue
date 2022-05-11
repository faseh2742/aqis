<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add Item</p>
                    <button class="delete" aria-label="close" @click="close"></button>
                </header>
                <section class="modal-card-body">
                    <form method="post" @submit.prevent="saveItem()" id="addItemForm" @keydown="form.errors.clear($event.target.name)">

                        <div class="md-layout">
                        <label class="md-layout-item md-size-15 md-form-label">
                          Item
                        </label>
                        <div class="md-layout-item">
                          <md-field>
                            <md-input name="item" v-model="form.item" type="text"></md-input>
                          </md-field>
                          <span class="help is-danger" v-if="form.errors.has('item')"
                            v-text="form.errors.get('item')"></span>
                        </div>
                      </div>

                        <div class="md-layout">
                          <label class="md-layout-item md-size-15 md-form-label">
                          Status
                        </label>
                          <div class="md-layout-item">
                              <md-radio name="status" v-model="form.status" :value=1 @change="form.errors.clear('status')">Active</md-radio>
                              <md-radio name="status" v-model="form.status" :value=0 @change="form.errors.clear('status')">Inactive</md-radio>
                              <span class="help is-danger" v-if="form.errors.has('status')"
                            v-text="form.errors.get('status')"></span>
                          </div>
                        </div>

                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" type="submit" form="addItemForm" :disabled="saveDisabled">
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

export default {
  name: "AddItemModal",

  created() {
  },

  computed: {
  },

  data() {
    return {
        saveDisabled: false,
      users: [],
      form: new Form({
        dropdown_id: this.$store.state.dropdown_id,
        item: '',
        status: '',
      }),
    };
  },
  components: {},

  methods: {
    close() {
      this.$emit("close");
    },
    saveItem() {
        this.saveDisabled = true
      return this.form.post('/api/dropdown')
      .then (response => {
        this.close()
          this.saveDisabled = false
      })
      .catch (error => {
        console.log(error)
          this.saveDisabled = false
      })
    }
  }
};
</script>
