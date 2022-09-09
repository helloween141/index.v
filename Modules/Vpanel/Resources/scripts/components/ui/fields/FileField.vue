<template>
  <div>
    <label for="dropzone-file" class="flex flex-col w-1/3 h-32 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
      <div @dragover.prevent="onDrop"
           @dragleave.prevent="onDrop"
           @drop.prevent="onDrop"
           class="flex flex-col justify-center items-center pt-5 pb-6"
      >
        <i class="fas fa-2x fa-file-upload pb-3"></i>
        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
          <span class="font-semibold">Нажмите на иконку загрузки</span> или перенесите файл
        </p>
        <span v-if="currentValue">Текущий файл: {{ currentValue.name }}</span>
      </div>
      <input id="dropzone-file" type="file" class="hidden" ref="file" @change="onChange($event)" />
    </label>
    <div class="mt-3">
      <button
          @click.prevent="onDownload"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3">
        Скачать
      </button>
      <button
          @click.prevent="onReset"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3">
        Удалить
      </button>
      <button
          @click.prevent="onReset"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        В архив
      </button>
    </div>
  </div>
</template>

<script>

import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'FileField',
  props: {
    field: Object,
    value: [String, Number]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const currentValue = ref(props.value)

    const onDrop = ($event) => {
      handleInput($event.dataTransfer)
    }

    const onChange = ($event) => {
      handleInput($event.target)
    }

    const onDownload = () => {

    }

    const onReset = () => {
      currentValue.value = null
    }

    const handleInput = (target) => {
      if (target && target.files) {
        currentValue.value = target.files[0]
        emit('set-value', props.field.name, currentValue.value)
      }
    }

    return {
      currentValue,
      onDrop,
      onChange,
      onReset,
      onDownload
    }
  }
})
</script>

<style scoped>

</style>
