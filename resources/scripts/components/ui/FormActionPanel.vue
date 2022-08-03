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
      <button @click="onBack" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Назад
          </span>
      </button>
      <button @click="onDelete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Удалить
          </span>
      </button>
      <button @click="onSave" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
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
  emits: ['on-save', 'on-delete', 'on-back'],
  setup(props, {emit}) {
    const onSave= () => {
      emit('on-save')
    }

    const onDelete = () => {
      emit('on-delete')
    }

    const onBack = () => {
      emit('on-back')
    }

    return {
      onSave,
      onDelete,
      onBack
    }
  }
})
</script>