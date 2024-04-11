<script setup>
  import {computed, defineProps, defineEmits} from "vue";

  const props = defineProps(['label', 'modelValue', 'type', 'disabled'])
  const emits = defineEmits(['update:modelValue'])

  const value = computed({
    get: () => props.modelValue,
    set: (newVal) => emits('update:modelValue', newVal)
})
</script>

<template>
  <label class="contact-input">
    {{ label }}
    <input :type="type" v-model="value" :disabled="disabled">
  </label>
</template>

<style scoped>
  .contact-input {
    display: flex;
    flex-direction: column;
  }

  input {
    height: 30px;
  }
</style>