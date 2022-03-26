<template>
  <form @submit.prevent="submitForm()">
    <div>
      <h3>Signup</h3>
    </div>
    <div class="form-group">
      <label for="name">Name</label>
      <input
        id="name"
        v-model="authData.name"
        type="text"
        name="name"
        placeholder="Enter your name"
      >
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input
        id="email"
        v-model="authData.email"
        type="email"
        name="email"
        placeholder="Enter your email"
      >
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input
        id="password"
        v-model="authData.password"
        type="password"
        name="password"
        placeholder="Enter your password"
      >
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirm Password</label>
      <input
        id="password_confirmation"
        v-model="authData.password_confirmation"
        type="password"
        name="password_confirmation"
        placeholder="Confirm your password"
      >
    </div>
    <div class="form-action-group">
      <AppButton class="btn-info">
        {{ loading ? "Loading..." : submitBtnText }}
      </AppButton>
      <nuxt-link
        to="/auth/signin"
        class="signin-link"
      >
        Signin <i class="fas fa-angle-double-right" />
      </nuxt-link>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  data () {
    return {
      loading: false,
      submitBtnText: 'Signup',
      authData: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    submitForm () {
      this.loading = true
      if (this.validateForm()) {
        this.$axios
          .post('/api/register', this.authData)
          .then((res) => {
            this.$store.dispatch('auth/register', res.data)
            this.$router.push('/')
          })
          .catch((e) => {
            if (e.response.data.errors.name) {
              alert(e.response.data.errors.name[0])
            } else if (e.response.data.errors.email) {
              alert(e.response.data.errors.email[0])
            } else if (e.response.data.errors.password) {
              alert(e.response.data.errors.password[0])
            }
          })
          .finally(() => (this.loading = false))
      } else {
        this.loading = false
      }
    },
    validateForm () {
      if (
        !this.authData.name ||
        !this.authData.email ||
        !this.authData.password ||
        !this.authData.password_confirmation
      ) {
        alert('Field is empty')
        return false
      }
      return true
    }
  }
})
</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
  width: 100%;
  justify-content: center;
  align-items: center;
  padding: 0px 64px;
  min-height: 450px;
}
.form-group {
  display: flex;
  flex-direction: column;
  margin-top: 22px;
  width: 100%;
}
.form-action-group {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  margin-top: 40px;
  width: 100%;
}
.form-group:first-child {
  margin-top: 0px;
}
label {
  font-size: 12px;
}
input {
  padding: 8px 0px;
  outline: none;
  border: none;
  border-bottom: 1px solid #6e6e6e;
}
input:focus {
  border-color: #57c8e4;
}
.signin-link {
  text-decoration: none;
  font-size: 13px;
}

@media all and (max-width: 768px) {
  form {
    padding: 0px;
  }
}
</style>
