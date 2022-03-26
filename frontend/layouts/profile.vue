<template>
  <div>
    <TheHeader />
    <nuxt />
    <TheFooter />
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {

  },
})
</script>

<style>
body{
  margin: 0px;
  font-family: 'Montserrat', sans-serif;
}
</style>
