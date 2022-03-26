<template>
  <header>
    <nuxt-link to="/">
      <img class="logo-icon" src="~/assets/images/logo.png">
    </nuxt-link>
    <ul class="nav-container desktop-menu">
      <nuxt-link
        v-if="isLogin"
        to="/profile"
      >
        <li class="nav-item">
          Profile
        </li>
      </nuxt-link>
      <nuxt-link
        to="/auth/signin"
      >
        <li v-if="!isLogin" class="nav-item">
          Login
        </li>
      </nuxt-link>
      <li v-if="isLogin" class="nav-item" @click="logout()">
        Logout
      </li>
    </ul>
    <div class="mobile-menu">
      <i class="fas fa-ellipsis-v toggle-menu" />
      <!-- <ul class="nav-container">
        <li class="nav-item">Profile</li>
        <li class="nav-item">Login</li>
      </ul> -->
    </div>
  </header>
</template>

<script lang="ts">
import { computed, defineComponent, useContext, useRouter, useStore } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {
    const store = useStore()
    const router = useRouter()
    const { $axios, } = useContext()

    const isLogin = computed(() => store.getters['auth/getAuthStatus'])

    function logout () {
      $axios
        .get('/api/logout', {
          headers: {
            Authorization: 'Bearer ' + store.getters['auth/getToken']
          }
        })
        .then(() => {
          store.dispatch('auth/logout')
          router.push('/')
        })
        .catch(e => console.log(e))
    }

    return {
      // data
      isLogin,

      // methods
      logout
    }
  },
})
</script>


<style scoped>
header {
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #363636;
  padding: 0px 16px;
}
header h3 {
  margin: 0px;
  padding: 0px 8px;
}
header img.logo-icon {
  width: 50px;
  cursor: pointer;
}
header .nav-container.desktop-menu {
  margin: 0px;
  padding: 0px;
  display: flex;
  color: white !important;
  list-style: none;
}
header .nav-container.desktop-menu a {
  color: white !important;
  text-decoration: none;
}
header .nav-container.desktop-menu li.nav-item {
  padding: 0px 8px;
  transition: all 0.5s;
  cursor: pointer;
}
header .nav-container.desktop-menu li.nav-item:hover,
header .nav-container.desktop-menu li.nav-item:active {
  color: red;
}

header .mobile-menu {
  display: none !important;
  position: relative;
}

header .mobile-menu .toggle-menu {
  color: white;
  cursor: pointer;
}

@media all and (max-width: 768px) {
  header .desktop-menu {
    display: none !important;
  }
  header .mobile-menu {
    display: block !important;
  }
}
</style>
