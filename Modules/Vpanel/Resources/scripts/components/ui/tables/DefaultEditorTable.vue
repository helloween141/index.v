<template>
  <div>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead v-if="headers" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th v-for="header in headers" scope="col" class="py-3 px-6">
              {{ header.title }}
            </th>
          </tr>
        </thead>
        <tbody v-if="rows">
          <tr v-for="(row, index) in rows"
              :key="index"
              @click="onClick(row.id)"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer"
          >
            <td v-for="(val, key, index) in row"
                :key="index"
                v-show="key !== 'id'"
                class="py-4 px-6"
            >
              <span v-if="val.value">
                {{ val.value }}
              </span>
              <span v-else>
                {{ val }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :pages="values" />
  </div>
</template>

<script lang="ts">
import {defineComponent, ref, watch} from "vue";
import Pagination from "@/components/ui/Pagination.vue";
import {getHeadersForEditorTable, getRowsForEditorTable} from "@/utils/utils";

export default defineComponent({
  name: 'DefaultEditorTable',
  components: {Pagination},
  emits: ['select-record'],
  props: {
    model: Object,
    values: Object
  },
  setup(props, { emit }) {
    let headers = ref()
    let rows = ref()

    const onClick = (recordId: number) => {
      emit('select-record', recordId)
    }

    watch(() => props.values, (current, previous) => {
      headers.value = getHeadersForEditorTable(props.model.fields)
      rows.value = getRowsForEditorTable(props.model.fields, props.values.data)
    }, { deep: true })

    return {
      headers,
      rows,
      onClick
    }
  },
})
</script>

<style scoped>
</style>
