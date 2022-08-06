<template>
  <div>
    <button @click.prevent="onBack" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
      <span class="text-white">
        <i class="fa-solid fa-arrow-rotate-back"></i>
        Назад
      </span>
    </button>
    <button @click.prevent="onDelete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
      <span class="text-white">
        Удалить
      </span>
    </button>
    <button @submit.prevent="onSave" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
      <span class="text-white">
        Сохранить
      </span>
    </button>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'FormActionPanel',
  props: {
    model: Object
  },
  emits: ['on-save', 'on-delete', 'on-back'],
  setup(props, {emit}) {
    const onSave = () => {
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