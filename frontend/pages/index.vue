<template>
  <div class="home-page-container">
    <section>Hello World.</section>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  layout: 'default',
  setup() {

  },
})
</script>


<style scoped>
.home-page-container {
  height: calc(100vh - 160px);
  background: #d9d7d7;
}
</style>
