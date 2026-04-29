<template>
  <div class="spinner-wrap" :class="{ fullscreen: fullscreen }">
    <div class="spinner-ring">
      <div></div><div></div><div></div><div></div>
    </div>
    <p v-if="text" class="spinner-text">{{ text }}</p>
  </div>
</template>

<script setup>
defineProps({
  text:       { type: String,  default: '' },
  fullscreen: { type: Boolean, default: false },
})
</script>

<style scoped>
.spinner-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px;
  gap: 16px;
}

.spinner-wrap.fullscreen {
  min-height: 100vh;
}

.spinner-ring {
  display: inline-block;
  position: relative;
  width: 48px; height: 48px;
}

.spinner-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 38px; height: 38px;
  margin: 5px;
  border: 4px solid #1ea8d4;
  border-radius: 50%;
  animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #1ea8d4 transparent transparent transparent;
}

.spinner-ring div:nth-child(1) { animation-delay: -0.45s; }
.spinner-ring div:nth-child(2) { animation-delay: -0.3s; }
.spinner-ring div:nth-child(3) { animation-delay: -0.15s; }

@keyframes spin {
  0%   { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.spinner-text {
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  color: #888888;
  margin: 0;
}
</style>