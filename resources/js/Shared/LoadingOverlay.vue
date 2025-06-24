<template>
    <div v-if="visible" class="loading-overlay">
      <div class="spinner">Loading...</div>
    </div>
  </template>

  <script>
  export default {
    name: 'LoadingOverlay',
    props: {
      visible: {
        type: Boolean,
        default: false
      }
    }
  }
  </script>

  <style scoped>
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .spinner {
    color: white;
    font-size: 1.5rem;
  }
  </style>
