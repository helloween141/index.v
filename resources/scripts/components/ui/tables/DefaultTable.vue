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
      <tr v-for="item in values" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="py-4 px-6" v-for="(record, key, index) in item" :key="index" v-show="headerNames.includes(key)">
          {{record}}
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
  setup(props) {
    const headerNames = ref([])
    props.headers.forEach(header => {
      headerNames.value.push(header['name'])
    })

    return {
      headerNames
    }
  }
})
</script>

<style scoped>

</style>