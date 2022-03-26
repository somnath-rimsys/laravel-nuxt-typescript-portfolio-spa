<template>
  <div>
    <div class="section-title">
      <h3>Basic details</h3>
      <AppButton
        style="margin-left: 8px"
        class="btn-info"
        @click="editBasicDetailsModalVisible = !editBasicDetailsModalVisible"
      >
        Edit <i class="fas fa-pen" />
      </AppButton>
    </div>
    <AppCard class="profile-basic-details">
      <div class="profile-image-container">
        <img v-if="user_image" :src="user_image" alt="Profile Image">
        <img v-else src="~/assets/images/no-image.png" alt="Profile Image">
      </div>
      <div class="user-bio">
        <h1 class="user-name">
          <i class="far fa-user" /> {{ user.name }}
        </h1>
        <p class="user-email">
          <i class="far fa-envelope" /> {{ user.email }}
        </p>
        <p class="user-dob">
          <i class="fas fa-birthday-cake" />
          <span v-if="user.dob">{{ user.dob | date }}</span>
          <span v-else class="no-data">Add your dob</span>
        </p>
        <p class="user-address">
          <i class="fas fa-map-marker-alt" />
          <span v-if="user.address">{{ user.address }}</span>
          <span v-else class="no-data">Add your address</span>
        </p>
        <p class="user-mobile-number">
          <i class="fas fa-phone-square-alt" />
          <span v-if="user.mobile">
            {{ user.mobile ? user.mobile : "" }}
            <span
              v-if="user.alternate_mobile"
            >/ {{ user.alternate_mobile }}</span>
          </span>
          <span v-else class="no-data">Add your mobile number</span>
        </p>
        <div class="user-social-link">
          <p class="linkedin">
            <i class="fab fa-linkedin" />
            <span
              v-if="user.linkedin_link"
            ><a :href="user.linkedin_link" target="_blank">Linkedin</a></span>
            <span v-else class="no-data">No Link</span>
          </p>
          <p class="github">
            <i class="fab fa-github" />
            <span v-if="user.github_link">
              <a :href="user.github_link" target="_blank">Github</a>
            </span>
            <span v-else class="no-data">No Link</span>
          </p>
        </div>
      </div>
    </AppCard>

    <AppModal v-show="editBasicDetailsModalVisible">
      <template #header>
        <p style="margin: 0px">
          Edit basic details
        </p>
      </template>
      <template>
        <form ref="basicDetailsForm" class="updateBasicDetailsForm">
          <div class="form-group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" :value="user.name">
          </div>

          <div class="form-group">
            <label for="dob">Dob</label>
            <input id="dob" type="date" name="dob" :value="user.dob">
          </div>

          <div class="form-group">
            <label for="mobile">Mobile number</label>
            <input id="mobile" type="tele" name="mobile" :value="user.mobile">
          </div>

          <div class="form-group">
            <label for="alternate_mobile">Alternate Mobile number</label>
            <input
              id="alternate_mobile"
              type="tele"
              name="alternate_mobile"
              :value="user.alternate_mobile"
            >
          </div>

          <div class="form-group">
            <label for="linkedin_link">Linkedin link</label>
            <input
              id="linkedin_link"
              type="url"
              name="linkedin_link"
              :value="user.linkedin_link"
            >
          </div>

          <div class="form-group">
            <label for="github_link">Github link</label>
            <input
              id="github_link"
              type="url"
              name="github_link"
              :value="user.github_link"
            >
          </div>

          <div class="form-group">
            <label for="profile_image">Profile Image</label>
            <input
              id="profile_image"
              type="file"
              name="profile_image"
              @change="onProfileImageChange"
            >
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" rows="3" name="address">{{ user.address }}</textarea>
          </div>
        </form>
      </template>
      <template #footer>
        <div class="btn-group">
          <AppButton
            ref="saveBtn"
            class="btn-success"
            @click="updateUserDetails()"
          >
            Save
          </AppButton>
          <AppButton
            ref="cancelBtn"
            class="btn-danger"
            type="button"
            @click="editBasicDetailsModalVisible = false"
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
    user: {
      required: true,
    },
    user_image: {
      required: true,
    }
  },
  setup(props, { emit }) {
    const store = useStore()
    const { $axios, } = useContext()
    const editBasicDetailsModalVisible = ref(false)
    const proile_image_to_upload = ref('')
    const basicDetailsForm = ref()
    const saveBtn = ref()
    const cancelBtn = ref()

    function updateUserDetails () {
      const formElements = basicDetailsForm.value.elements
      saveBtn.value.$el.disabled = true
      saveBtn.value.$el.innerText = 'Loading...'
      cancelBtn.value.$el.disabled = true

      const formData = new FormData()
      formData.append('proile_image', proile_image_to_upload.value)
      formData.append('name', formElements.name.value)
      formData.append('address', formElements.address.value)
      formData.append('dob', formElements.dob.value)
      formData.append('mobile', formElements.mobile.value)
      formData.append('alternate_mobile', formElements.alternate_mobile.value)
      formData.append('linkedin_link', formElements.linkedin_link.value)
      formData.append('github_link', formElements.github_link.value)

      $axios
        .post('api/user/updateBasicDetails', formData, {
          headers: {
            Authorization: 'Bearer ' + store.getters['auth/getToken'],
            'Content-Type': 'multipart/form-data'
          }
        })
        .then((res) => {
          emit('updated', res.data)
          editBasicDetailsModalVisible.value = false
          basicDetailsForm.value.reset()
        })
        .catch((err) => {
          console.error(err)
          alert('Something went wrong. Please try again.')
        })
        .finally(() => {
          saveBtn.value.$el.disabled = false
          saveBtn.value.$el.innerText = 'Save'
          cancelBtn.value.$el.disabled = false
        })
    }

    function onProfileImageChange (e: any) {
      const files = e.target.files || e.dataTransfer.files
      if (!files.length) {
        proile_image_to_upload.value = ''
      } else {
        proile_image_to_upload.value = files[0]
      }
    }

    return {
      // data
      editBasicDetailsModalVisible,
      proile_image_to_upload,

      // methods
      updateUserDetails,
      onProfileImageChange
    }
  },
})
</script>


<style scoped>
.section-title {
  display: flex;
  align-items: center;
}
.profile-basic-details {
  position: relative;
}
.profile-image-container {
  max-width: 160px;
  padding: 4px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.profile-image-container img {
  width: 100%;
  height: 100%;
}
.user-bio {
  margin-left: 16px;
  font-size: 14px;
}
.no-data {
  color: rgb(172, 169, 169);
}
.user-social-link {
  display: flex;
  justify-content: space-between;
  margin-bottom: 14px;
}
.user-social-link p {
  margin: 0px;
}
.user-social-link p a {
  text-decoration: none;
  color: black;
}
.user-social-link p a:hover,
.user-social-link p a:active {
  color: blue;
}
.user-name {
  margin-bottom: 0px;
}
.updateBasicDetailsForm {
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

@media all and (min-width: 1024px) {
  .profile-basic-details,
  .section-title {
    width: 70%;
    margin: auto;
  }
}

@media all and (max-width: 768px) {
  .profile-image-container {
    max-width: 100%;
    padding: 0px;
    margin-top: 16px;
  }
  .profile-image-container img {
    width: 250px;
    height: 250px;
    border-radius: 50%;
  }
  .user-bio {
    margin-right: 16px;
    margin-bottom: 16px;
  }
  .user-email,
  .user-dob,
  .user-address,
  .user-mobile-number {
    margin: 8px 0px;
  }
  .user-social-link {
    justify-content: start;
    flex-direction: column;
    margin-bottom: 0px;
  }
  .user-social-link p {
    margin: 4px 0px;
  }
  .form-group {
    width: 100%;
  }
  .form-group:nth-child(odd) {
    margin-right: 0px;
  }
}
</style>
