<template>
  <div>
    <div class="section-title">
      <h3>Skills.</h3>
      <AppButton style="margin-left: 8px" class="btn-success">
        Add <i class="fas fa-plus-circle" />
      </AppButton>
    </div>

    <AppCard
      class="profile-skills-details"
      :class="{ 'no-skills': skills.length === 0 ? true : false }"
    >
      <p v-if="skills.length === 0" class="no-skills-text">
        No skills added yet
      </p>

      <div v-else class="skills-container">
        <SingleSkill v-for="skill in skills" :key="skill.id" :data="skill" />
      </div>
    </AppCard>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  props: {
    skills: {
      type: Array,
      default: [],
    },
  },
  setup(props) {

  },
})
</script>


<style scoped>
.section-title {
  display: flex;
  align-items: center;
  margin-top: 32px !important;
}
.profile-skills-details {
  display: block;
}
.profile-skills-details.no-skills {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80px;
}
p.no-skills-text {
  color: #645d5d;
}
.skills-container {
  padding: 16px;
  display: flex;
  flex-wrap: wrap;
}
</style>
