<template>
  <transition name="modal">
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">
            Meeting Feedback
            <slot name="header">
              <button
                class="delete feedback"
                aria-label="close"
                @click="close"
              ></button>
            </slot>
          </p>
          <slot name="header-button"></slot>
        </header>
        <section class="modal-card-body">
          <md-card>
            <md-card-content class="text-center" >
              <slot>
                 <b-form-rating v-model="value" readonly variant="warning" style="font-size: xx-large;"></b-form-rating>
                  <p class="mt-2">Value: {{ value }}</p>
                </slot
              >
            </md-card-content>
          </md-card>
        </section>
        <footer class="modal-card-foot">
          <slot name="footer"></slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "FeedbackModal.vue",
  data() {
    return {
        value:3.5,
    };
  },
  created() {
    console.log(this.$store.state.user.role);
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
};
</script>
<style scoped>
.feedback {
  float: right;
}

</style>