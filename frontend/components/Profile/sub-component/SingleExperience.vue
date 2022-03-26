<template>
  <li>
    <p class="job-title">
      {{ data.job_title }} at {{ data.company_name }}
    </p>
    <p class="job-time-period">
      <span>{{ data.start_date | date }}</span> -
      <span v-if="data.currently_working">Present</span>
      <span v-else>{{ data.end_date | date }}</span>
    </p>
    <div class="btn-group">
      <AppButton class="btn-warning" @click="$emit('edit', data)">
        <i class="far fa-pen" />
      </AppButton>
      <AppButton class="btn-danger" @click="$emit('delete', data)">
        <i class="far fa-trash-alt" />
      </AppButton>
    </div>
  </li>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  props: {
    data: {
      type: Object,
      required: true
    }
  },
  setup(props) {

  },
})
</script>


<style scoped>
.job-title {
  margin: 0px;
  font-size: 15px;
}
.job-time-period {
  margin: 0px;
  font-size: 13px;
  color: #605b5b;
}
.btn-group{
  margin-top: 8px;
}
</style>
