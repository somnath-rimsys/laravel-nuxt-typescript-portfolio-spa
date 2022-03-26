<template>
  <div class="auth-container">
    <AppCard class="signup-section">
      <SignUpForm />
    </AppCard>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  layout: 'auth',
  setup() {

  },
})
</script>

<style scoped>
.auth-container {
  height: calc(100vh - 160px);
  display: flex;
  justify-content: center;
  align-items: center;
  background: #d9d7d7;
}
.signup-section {
  width: 500px;
  margin: auto;
  min-height: 250px;
}
@media all and (max-width: 768px) {
  .signup-section {
    width: 80%;
    justify-content: center;
    align-items: center;
    padding: 0px 8px;
  }
}
</style>
