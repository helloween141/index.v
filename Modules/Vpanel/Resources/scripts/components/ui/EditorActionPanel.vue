<template>
  <div>
    <button class="bg-blue-700 hover:bg-blue-400 text-gray-800 font-bold py-2 px-4 rounded">
      <i class="fa-solid fa-filter text-white"></i>
    </button>

    <button @click="onCreate" class="bg-blue-700 hover:bg-blue-400 ml-3 text-gray-800 font-bold py-2 px-4 rounded">
          <span class="text-white">
            <i class="fa-solid fa-circle-plus"></i> Создать {{ model.accusativeRecordTitle }}
          </span>
    </button>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'EditorActionPanel',
  props: {
    model: Object,
  },
  emits: ['on-create'],
  setup(props, {emit}) {
    const onCreate = () => {
      emit('on-create')
    }

    return {
      onCreate
    }
  }
})
</script>