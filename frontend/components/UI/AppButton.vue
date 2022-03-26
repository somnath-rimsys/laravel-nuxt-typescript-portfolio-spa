<template>
  <button class="btn" @click="btnClick">
    <slot />
  </button>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  setup(_, { emit }) {
    function btnClick() {
      emit('click')
    }

    return {
      // methods
      btnClick,
    }
  },
})
</script>


<style scoped>
.btn {
  outline: none;
  border: none;
  padding: 4px 8px;
  cursor: pointer;
  border-radius: 2px;
  transition: all 0.3s;
}
.btn:hover,
.btn:active {
  box-shadow: 1px 1px 4px #000000, -1px 0px 0px 0px #ffffff,
    0px -1px 0px #ffffff;
}
.btn:disabled {
  box-shadow: none;
  opacity: 0.8;
}

.btn-danger {
  background: #cb3636;
  color: white;
}
.btn-success {
  background: #309763;
  color: white;
}
.btn-info {
  background: #2a1fb5;
  color: white;
}
.btn-warning {
  background: #dd6d2d;
  color: white;
}
</style>
