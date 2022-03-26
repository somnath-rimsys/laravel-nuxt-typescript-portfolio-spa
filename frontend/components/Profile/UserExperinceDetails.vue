<template>
  <div>
    <div class="section-title">
      <h3>Experiences.</h3>
      <AppButton
        style="margin-left: 8px"
        class="btn-success"
        @click="showExperienceModal"
      >
        Add <i class="fas fa-plus-circle" />
      </AppButton>
    </div>
    <AppCard
      class="profile-experience-details"
      :class="{ 'no-experience': experiences.length === 0 ? true : false }"
    >
      <p v-if="experiences.length === 0" class="no-experience-text">
        No Experiences added yet
      </p>

      <div v-else class="experience-container">
        <ul>
          <SingleExperience
            v-for="experience in experiences"
            :key="experience.id"
            :data="experience"
            class="single-experience"
            @edit="editExperience"
            @delete="deleteExperience"
          />
        </ul>
      </div>
    </AppCard>

    <AppModal v-show="showAddExperienceModal">
      <template #header>
        <p style="margin: 0px">
          Add Experience
        </p>
      </template>
      <template>
        <form>
          <div class="form-group">
            <label for="job_title">Job Title</label>
            <input
              id="job_title"
              v-model="addExperienceFormData.job_title"
              type="text"
              name="job_title"
            >
          </div>

          <div class="form-group">
            <label for="company_name">Company Name</label>
            <input
              id="company_name"
              v-model="addExperienceFormData.company_name"
              type="text"
              name="company_name"
            >
          </div>

          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input
              id="start_date"
              v-model="addExperienceFormData.start_date"
              type="date"
              name="start_date"
            >
          </div>

          <div class="form-group">
            <label for="end_date">End Date</label>
            <input
              id="end_date"
              v-model="addExperienceFormData.end_date"
              type="date"
              name="end_date"
            >
          </div>

          <div
            class="form-group"
            style="flex-direction: revert; align-items: center"
          >
            <input
              id="currently_working"
              v-model="addExperienceFormData.currently_working"
              type="checkbox"
              name="currently_working"
            >
            <label for="currently_working">Currently Working</label>
          </div>
        </form>
      </template>
      <template #footer>
        <div class="btn-group">
          <AppButton
            ref="saveExperienceBtn"
            class="btn-success"
            type="button"
            @click="saveExperience()"
          >
            Save
          </AppButton>
          <AppButton
            ref="cancelSaveExperienceBtn"
            class="btn-danger"
            type="button"
            @click="showAddExperienceModal = false"
          >
            Cancel
          </AppButton>
        </div>
      </template>
    </AppModal>

    <AppModal v-show="showEditExperienceModal">
      <template #header>
        <p style="margin: 0px">
          Edit Experience
        </p>
      </template>
      <template>
        <form>
          <div class="form-group">
            <label for="edit_job_title">Job Title</label>
            <input
              id="edit_job_title"
              v-model="editExperienceFormData.job_title"
              type="text"
              name="edit_job_title"
            >
          </div>

          <div class="form-group">
            <label for="company_name">Company Name</label>
            <input
              id="edit_company_name"
              v-model="editExperienceFormData.company_name"
              type="text"
              name="edit_company_name"
            >
          </div>

          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input
              id="edit_start_date"
              v-model="editExperienceFormData.start_date"
              type="date"
              name="edit_start_date"
            >
          </div>

          <div class="form-group">
            <label for="end_date">End Date</label>
            <input
              id="edit_end_date"
              v-model="editExperienceFormData.end_date"
              type="date"
              name="edit_end_date"
            >
          </div>

          <div
            class="form-group"
            style="flex-direction: revert; align-items: center"
          >
            <input
              id="edit_currently_working"
              v-model="editExperienceFormData.currently_working"
              type="checkbox"
              name="edit_currently_working"
            >
            <label for="edit_currently_working">Currently Working</label>
          </div>
        </form>
      </template>
      <template #footer>
        <div class="btn-group">
          <AppButton
            ref="updateExperienceBtn"
            class="btn-success"
            type="button"
            @click="updateExperience()"
          >
            Update
          </AppButton>
          <AppButton
            ref="cancelUpdateExperienceBtn"
            class="btn-danger"
            type="button"
            @click="showEditExperienceModal = false"
          >
            Cancel
          </AppButton>
        </div>
      </template>
    </AppModal>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, useContext, useStore } from '@nuxtjs/composition-api'

export default defineComponent({
  props: {
    experiences: {
      required: true,
    },
  },
  setup(props, { emit }) {
    const store = useStore()
    const { $axios, } = useContext()
    const showAddExperienceModal = ref(false)
    const showEditExperienceModal = ref(false)
    const addExperienceFormData = ref({
      job_title: '',
      company_name: '',
      start_date: '',
      end_date: '',
      currently_working: true
    })
    const editExperienceFormData = ref({
      job_title: '',
      company_name: '',
      start_date: '',
      end_date: '',
      currently_working: false,
      id: null
    })
    const saveExperienceBtn = ref()
    const cancelSaveExperienceBtn = ref()
    const updateExperienceBtn = ref()
    const cancelUpdateExperienceBtn = ref()

    function showExperienceModal () {
      showAddExperienceModal.value = true
    }

    function saveExperience () {
      if (
        !addExperienceFormData.value.job_title ||
        !addExperienceFormData.value.company_name ||
        !addExperienceFormData.value.start_date
      ) {
        alert('Some field is empty')
      } else if (
        !addExperienceFormData.value.currently_working &&
        !addExperienceFormData.value.end_date
      ) {
        alert('Please provide end date')
      } else {
        saveExperienceBtn.value.disabled = true
        saveExperienceBtn.value.innerText = 'Loading...'
        cancelSaveExperienceBtn.value.disabled = true

        $axios
          .post('api/user/addExperience', addExperienceFormData.value, {
            headers: {
              Authorization: 'Bearer ' + store.getters['auth/getToken']
            }
          })
          .then((res) => {
            emit('updated', res.data)
            showAddExperienceModal.value = false
            addExperienceFormData.value = {
              job_title: '',
              company_name: '',
              start_date: '',
              end_date: '',
              currently_working: true
            }
          })
          .catch((err) => {
            console.error(err)
            alert('Something went wrong. Please try again.')
          })
          .finally(() => {
           saveExperienceBtn.value.disabled = false
           saveExperienceBtn.value.innerText = 'Save'
           cancelSaveExperienceBtn.value.disabled = false
          })
      }
    }

    function editExperience (data: any) {
      editExperienceFormData.value.job_title = data.job_title
      editExperienceFormData.value.company_name = data.company_name
      editExperienceFormData.value.start_date = data.start_date
      editExperienceFormData.value.end_date = data.end_date
      editExperienceFormData.value.currently_working = data.currently_working
      editExperienceFormData.value.id = data.id
      showEditExperienceModal.value = true
    }

    function updateExperience () {
      if (
        !editExperienceFormData.value.job_title ||
        !editExperienceFormData.value.company_name ||
        !editExperienceFormData.value.start_date
      ) {
        alert('Some field is empty')
      } else if (
        !editExperienceFormData.value.currently_working &&
        !editExperienceFormData.value.end_date
      ) {
        alert('Please provide end date')
      } else {
        updateExperienceBtn.value.disabled = true
        updateExperienceBtn.value.innerText = 'Loading...'
        cancelUpdateExperienceBtn.value.disabled = true

        $axios
          .post('api/user/updateExperience', editExperienceFormData.value, {
            headers: {
              Authorization: 'Bearer ' + store.getters['auth/getToken']
            }
          })
          .then((res) => {
            emit('updated', res.data)
            showEditExperienceModal.value = false
            editExperienceFormData.value = {
              job_title: '',
              company_name: '',
              start_date: '',
              end_date: '',
              currently_working: false,
              id: null
            }
          })
          .catch((err) => {
            console.error(err)
            alert('Something went wrong. Please try again.')
          })
          .finally(() => {
            updateExperienceBtn.value.disabled = false
            updateExperienceBtn.value.innerText = 'Update'
            cancelUpdateExperienceBtn.value.disabled = false
          })
      }
    }

    function deleteExperience (data: any) {
      if (confirm('Are you sure?')) {
        $axios.post(
          '/api/user/deleteExperience',
          { id: data.id },
          {
            headers: {
              Authorization: 'Bearer ' + store.getters['auth/getToken']
            }
          }
          )
          .then((res) => {
            emit('updated', res.data)
          })
          .catch((e) => {
            console.error(e)
          })
      }
    }

    return {
      // data
      showAddExperienceModal,
      showEditExperienceModal,
      addExperienceFormData,
      editExperienceFormData,
      saveExperienceBtn,
      cancelSaveExperienceBtn,
      updateExperienceBtn,
      cancelUpdateExperienceBtn,

      // methods
      showExperienceModal,
      saveExperience,
      editExperience,
      updateExperience,
      deleteExperience,
    }
  },
})
</script>


<style scoped>
.section-title {
  display: flex;
  align-items: center;
  margin-top: 32px !important;
}
.profile-experience-details {
  display: block;
}
.profile-experience-details.no-experience {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80px;
}
p.no-experience-text {
  color: #645d5d;
}
.experience-container {
  padding: 16px;
}
.experience-container .single-experience {
  border-bottom: 1px solid #aba4a4;
  padding: 8px 0px;
}
.experience-container .single-experience:first-child {
  padding-top: 0px;
}
.experience-container .single-experience:last-child {
  padding-bottom: 0px;
  border-bottom: none;
}
form {
  display: flex;
  flex-wrap: wrap;
}
.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 14px;
  width: 48%;
  /* float: left; */
}
.form-group:nth-child(odd) {
  margin-right: 4%;
}
.btn-group {
  text-align: right;
}
.form-group label {
  font-size: 12px;
}
.form-group input,
.form-group textarea {
  outline: none;
  padding: 4px 8px;
  border: 1px solid #afafaf;
  border-radius: 2px;
}
.btn-group {
  text-align: right;
}

@media all and (min-width: 1024px) {
  .profile-experience-details,
  .section-title {
    width: 70%;
    margin: auto;
  }
}

@media all and (max-width: 768px) {
  .form-group {
    width: 100%;
  }
  .form-group:nth-child(odd) {
    margin-right: 0px;
  }
}
</style>
