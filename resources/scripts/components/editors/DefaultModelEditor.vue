<template>
  <div>
    <div class="mb-3 flex justify-between items-center">
      <div>
        <h1 class="text-white text-2xl">{{ model.title }}</h1>
      </div>
      <div>
        <button class="bg-blue-700 hover:bg-blue-400 text-gray-800 font-bold py-2 px-4 rounded">
          <i class="fa-solid fa-filter text-white"></i>
        </button>

        <button class="bg-blue-700 hover:bg-blue-400 ml-3 text-gray-800 font-bold py-2 px-4 rounded">
        <span class="text-white">
          <i class="fa-solid fa-circle-plus"></i> Создать {{ model.accusativeRecordTitle }}
        </span>
        </button>
      </div>
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th v-for="field in model.fields" scope="col" class="py-3 px-6">
            {{ field.title }}
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="list in values.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="py-4 px-6" v-for="record in list">
            {{record}}
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <Pagination :pages="values" />

  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Pagination from "@/components/ui/Pagination.vue";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {Pagination},
  props: {
    model: Object,
    values: Array
  },
  setup() {
    return {
    }
  }
})
</script>

<style scoped>

</style>