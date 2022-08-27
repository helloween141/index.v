<template>
  <div class="mb-5 inline-block justify-between p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    {{filter}}
    <div v-for="(field, index) in fields"
         :key="index"
         class="mb-3"
    >
      <span class="dark:text-white mb-3">
        {{ field.title }}
      </span>

      <div v-if="field.type === 'string'">
        <input type="text"
               v-model="filter[field.name]"
               class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
      </div>

      <div v-if="field.type === 'int' || field.type === 'float'">
        <div class="flex justify-between">
          <input type="text"
                 v-model="filter[`${field.name}_from`]"
                 placeholder="от"
                 class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
          <input type="text"
                 v-model="filter[`${field.name}_to`]"
                 placeholder="до"
                 class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
        </div>
      </div>

      <div v-if="field.type === 'pointer'">
        <input type="text"
               v-model="filter[field.name]"
               class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
      </div>

      <div v-if="field.type === 'date'">
        <div class="flex justify-between">
          <input type="text"
                 v-model="filter[`${field.name}_from`]"
                 placeholder="от"
                 class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
          <input type="text"
                 v-model="filter[`${field.name}_to`]"
                 placeholder="до"
                 class="ml-3 bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
        </div>
      </div>

      <div v-if="field.type === 'bool'">
        <input type="text" class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
      </div>
    </div>

    <div class="flex justify-end">
      <button
          @click="onResetFilter"
          class="bg-red-500 hover:bg-red-700 text-gray-800 font-bold py-2 px-4 rounded">
        <span class="text-white">Сбросить</span>
      </button>

      <button
          @click="onApplyFilter"
          class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
        <span class="text-white">Применить</span>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'EditorFilterPanel',
  props: {
    fields: Object
  },
  emits: ['on-filter'],
  setup(props, {emit}) {
    const filter = ref({})

    const onApplyFilter = () => {
      emit('on-filter', filter.value)
    }

    const onResetFilter = () => {
      filter.value = {}
    }

    return {
      filter,
      onApplyFilter,
      onResetFilter
    }
  }
})
</script>