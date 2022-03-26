<template>
  <div class="skill">
    <i class="fa fa-times"></i>
    <span class="skill-text">{{ data.skill }}</span>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  props: {
    data: {
      required: true,
    }
  },
  setup() {

  },
})
</script>


<style scoped>
.skill {
  border: 1px solid #817e7e;
  margin: 4px;
}
.skill-text {
  padding: 4px 8px;
}
</style>
