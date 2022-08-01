<template>
  <div class="mb-3 flex justify-between items-center">
    <div>
      <h1 class="dark:text-white text-2xl">
        <span>
          Редактировать {{ model.recordTitle }}
        </span>
      </h1>
    </div>

    <div>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Назад
          </span>
      </button>
      <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Удалить
          </span>
      </button>
      <button @click="onSaveClick" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Сохранить
          </span>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'FormActionPanel',
  props: {
    model: Object
  },
  emits: ['on-save'],
  setup(props, {emit}) {
    const onSaveClick = () => {
      emit('on-save')
    }

    return {
      onSaveClick
    }
  }
})
</script>