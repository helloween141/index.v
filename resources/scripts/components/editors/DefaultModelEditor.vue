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

    <DefaultTable :headers="model.fields" :values="values.data" />

    <Pagination :pages="values" />

  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Pagination from "@/components/ui/Pagination.vue";
import DefaultTable from "@/components/ui/tables/DefaultTable.vue";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {DefaultTable, Pagination},
  props: {
    model: Object,
    values: Object
  },
  setup() {
    return {
    }
  }
})
</script>

<style scoped>

</style>