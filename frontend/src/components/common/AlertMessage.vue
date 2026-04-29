<template>
  <Transition name="alert-fade">
    <div v-if="show" class="alert-custom" :class="`alert-${type}`" role="alert">
      <i class="bi me-2" :class="iconClass"></i>
      <span>{{ message }}</span>
      <button v-if="dismissible" class="alert-close" @click="$emit('close')">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </Transition>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  show:        { type: Boolean, default: false },
  type:        { type: String,  default: 'info' }, 
  message:     { type: String,  default: '' },
  dismissible: { type: Boolean, default: true },
})

defineEmits(['close'])

const iconClass = computed(() => ({
  'bi-check-circle-fill': props.type === 'success',
  'bi-x-circle-fill':     props.type === 'error',
  'bi-exclamation-triangle-fill': props.type === 'warning',
  'bi-info-circle-fill':  props.type === 'info',
}))
</script>

<style scoped>
.alert-custom {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 18px;
  border-radius: 12px;
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 16px;
  position: relative;
}

.alert-success  { background: #e8f5e9; color: #1a5c28; border: 1px solid #b7dfbc; }
.alert-error    { background: #fdecea; color: #8b1a1a; border: 1px solid #f5c2c2; }
.alert-warning  { background: #fff3e0; color: #7a4f00; border: 1px solid #ffd59f; }
.alert-info     { background: #EAF6FF; color: #1D3461; border: 1px solid #b3d9f0; }

.alert-close {
  margin-left: auto;
  background: transparent;
  border: none;
  cursor: pointer;
  font-size: 16px;
  opacity: 0.6;
  transition: opacity 0.2s;
  color: inherit;
  padding: 0;
  display: flex;
}

.alert-close:hover { opacity: 1; }

.alert-fade-enter-active,
.alert-fade-leave-active { transition: all 0.3s ease; }
.alert-fade-enter-from,
.alert-fade-leave-to { opacity: 0; transform: translateY(-8px); }
</style>