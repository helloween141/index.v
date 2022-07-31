<template>
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
      <tr v-for="(item, index) in values"
          :key="index"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer"
          @click="onClick(item.id)"
      >
        <td class="py-4 px-6" v-for="(value, key, index) in item"
            :key="index"
            v-show="headerNames.includes(key)"
        >
          {{value}}
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'DefaultTable',
  props: {
    headers: Array,
    values: Array
  },
  setup(props, { emit }) {
    const headerNames = ref([])
    props.headers.forEach(header => {
      headerNames.value.push(header['name'])
    })

    const onClick = (recordId: number) => {
      emit('choose-record', recordId)
    }

    return {
      headerNames,
      onClick
    }
  }
})
</script>

<style scoped>
</style>