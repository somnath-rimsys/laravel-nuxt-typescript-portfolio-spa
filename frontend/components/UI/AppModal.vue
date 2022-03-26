<template>
  <transition name="modal">
    <div class="modal-container">
      <div class="modal">
        <div class="modal-header">
          <slot name="header" />
        </div>
        <div class="modal-content">
          <slot />
        </div>
        <div class="modal-footer">
          <slot name="footer" />
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.modal-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: #5250508a;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
.modal {
  width: 80%;
  background: white;
  border-radius: 4px;
  margin: auto;
}
.modal-header {
  padding: 16px;
  border-bottom: 1px solid #a7a3a3;
}
.modal-content {
  padding: 16px;
}
.modal-footer {
  padding: 16px;
  border-top: 1px solid #a7a3a3;
}

.modal-enter-active {
  animation: modal-animation 0.2s ease-in;
}
.modal-leave-active {
  animation: modal-animation 0.2s ease-in reverse;
}

@media all and (min-width: 1024px) {
  .modal {
    width: 60%;
  }
}

@keyframes modal-animation {
  0% {
    opacity: 0;
    scale: 0;
  }
  100% {
    opacity: 1;
    scale: 1;
  }
}
</style>
