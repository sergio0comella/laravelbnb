<template>
  <div>
      <div
          v-for="(error, index) in errors"
          :key="key(index)"
          class="invalid-feedback"
      >
          {{ error }}
      </div>
  </div>
</template>

<script>
export default {
    name: "ValidationErrors",
    props: ['errors'],
    methods: {
        key(index) {
            return 'validation_errors_' + index + '_' + Math.random();
        }
    }
}
</script>

<style scoped>
.form-control.is-invalid ~ div > .invalid-feedback {
    display: block;
}
</style>
