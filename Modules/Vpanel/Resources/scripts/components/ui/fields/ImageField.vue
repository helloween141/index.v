<template>
  <div>
    <label for="dropzone-file" class="flex flex-col w-1/3 h-32 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
      <div class="flex flex-col justify-center items-center pt-5 pb-6">
        <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
      </div>
      <input id="dropzone-file" type="file" class="hidden" />
    </label>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Скачать</button>
  </div>
</template>

<script>

import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'ImageField',
  props: {
    field: Object,
    value: [String, Number]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const currentValue = ref(props.value)

    const handleInput = () => {
      emit('set-value', props.field.name, currentValue.value)
    }

    return {
      currentValue,
      handleInput
    }
  }
})
</script>

<style scoped>

</style>
