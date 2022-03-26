<template>
  <div class="profile-container">
    <UserBioDetails
      :user="user"
      :user_image="profile_image"
      @updated="basicDetailsComponentUpdated"
    />
    <UserExperinceDetails
      :experiences="experiences"
      @updated="experienceDetailsComponentUpdated"
    />
    <UserSkillsDetails :skills="skills" />
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref, useContext, useStore } from '@nuxtjs/composition-api'

export default defineComponent({
  layout: 'profile',
  middleware: ["auth"],
  setup() {
    const store = useStore()
    const { $axios, } = useContext()

    const user = ref({})
    const profile_image = ref('')
    const experiences = ref([])
    const skills = ref([
      { id: 1, skill: "c" },
      { id: 2, skill: "c++" },
      { id: 3, skill: "Php" },
      { id: 4, skill: "Laravel" },
      { id: 5, skill: "Angular" },
      { id: 6, skill: "Ionic" },
      { id: 7, skill: "NodeJs" },
    ])

    function basicDetailsComponentUpdated(data: any) {
      store.commit("auth/setUser", data.user);
      user.value = data.user;
      profile_image.value = data.profile_image;
    }

    function experienceDetailsComponentUpdated(data: any) {
      store.dispatch("experience/updateExperience", data.experiences);
      experiences.value = data.experiences;
    }

    onMounted(()=>{
      $axios.get("/api/user", {
        headers: {
          Authorization: "Bearer " + store.getters["auth/getToken"],
        },
      })
      .then((d) => {
        store.commit("auth/setUser", d.data.user);
        user.value = d.data.user;
        profile_image.value = d.data.profile_image;
      })
      .catch((e) => console.log(e));

      $axios
      .get("/api/user/getExperiences", {
        headers: {
          Authorization: "Bearer " + store.getters["auth/getToken"],
        },
      })
      .then((d) => {
        store.dispatch("experience/updateExperience", d.data.experiences);
        experiences.value = d.data.experiences;
      })
      .catch((e) => console.log(e));
    })

    return {
      // data
      user,
      profile_image,
      experiences,
      skills,

      // methods
      basicDetailsComponentUpdated,
      experienceDetailsComponentUpdated
    }
  },
})
</script>


<style scoped>
.profile-container {
  min-height: calc(100vh - 192px);
  padding: 16px 64px;
  background: #e2e2e2;
}

@media all and (max-width: 768px) {
  .profile-container {
    min-height: calc(100vh - 160px);
    padding: 8px;
  }
}
</style>
