<template>
  <div>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th v-for="header in headers" scope="col" class="py-3 px-6">
              {{ header.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in rows"
              :key="index"
              @click="onClick(item.id)"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer"
          >
            <td v-for="(val, key, index) in item"
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
import {defineComponent, ref} from "vue";
import Pagination from "@/components/ui/Pagination.vue";

export default defineComponent({
  name: 'DefaultEditorTable',
  components: {Pagination},
  emits: ['select-record'],
  props: {
    model: Object,
    values: Object
  },
  setup(props, { emit }) {
    const headers = []
    const rows = []

    props.model.fields.forEach(field => {
      if (field.inEditor) {
        headers.push({name: field['name'], title: field['title']})
      }
    })

    props.values.data.forEach(item => {
      let obj = {}
      headers.forEach(header => {
        obj = {...obj, [header['name']]: item[header['name']]}
      })
      rows.push(obj)
    })
  
    const onClick = (recordId: number) => {
      emit('select-record', recordId)
    }

    return {
      headers,
      rows,
      onClick
    }
  }
})
</script>

<style scoped>
</style>
