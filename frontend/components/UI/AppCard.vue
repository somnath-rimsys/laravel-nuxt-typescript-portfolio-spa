<template>
  <section>
    <slot />
  </section>
</template>

<style scoped>
section {
  display: flex;
  background: white;
  border-radius: 8px;
  box-shadow: 2px 2px 7px #4e4949;
}
@media all and (max-width: 768px) {
  section {
    flex-direction: column;
  }
}
</style>
