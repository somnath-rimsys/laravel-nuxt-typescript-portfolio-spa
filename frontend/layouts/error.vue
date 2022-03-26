<template>
  <div class="error-container">
    <h3>I think you are lost.</h3>
    <nuxt-link to="/"> Back to safty</nuxt-link>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {

  },
})
</script>

<style scoped>
div.error-container {
  height: calc(100vh - 160px);
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
</style>
