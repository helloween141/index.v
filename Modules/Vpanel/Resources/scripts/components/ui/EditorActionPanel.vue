<template>
  <div class="mb-3 flex justify-between items-center">

    <h1 class="dark:text-white text-2xl">
      {{ model.title }}
    </h1>

    <div v-show="searchPlaceholder"
         class="flex w-full justify-end"
    >
      <div class="relative w-1/2">
        <input type="search"
               v-model="searchString"
               :placeholder="searchPlaceholder"
               class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
        />
        <button @click="onSearch"
                class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          <i class="fa-solid fa-search text-white"></i>
        </button>
      </div>

      <button @click="onShowFilter"
              class="bg-blue-700 hover:bg-blue-400 text-gray-800 font-bold ml-3 py-2 px-4 rounded">
        <i class="fa-solid fa-filter text-white"></i>
      </button>

      <button @click="onCreate" class="bg-blue-700 hover:bg-blue-400 ml-3 text-gray-800 font-bold py-2 px-4 rounded">
          <span class="text-white">
            <i class="fa-solid fa-circle-plus"></i> Создать {{ model.accusativeRecordTitle }}
          </span>
      </button>
    </div>

  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import {getPlaceholderForSearch} from "@/utils/utils";

export default defineComponent({
  name: 'EditorActionPanel',
  props: {
    model: Object,
  },
  emits: ['on-create', 'on-show-filter', 'on-search'],
  setup(props, {emit}) {
    const searchString = ref('')

    const searchPlaceholder = getPlaceholderForSearch(props.model.fields)

    const onCreate = () => {
      emit('on-create')
    }

    const onShowFilter = () => {
      emit('on-show-filter')
    }

    const onSearch = () => {
      emit('on-search', searchString.value)
    }

    return {
      onCreate,
      onShowFilter,
      onSearch,
      searchString,
      searchPlaceholder
    }
  }
})
</script>