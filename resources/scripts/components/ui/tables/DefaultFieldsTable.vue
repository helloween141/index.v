<template>
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <tbody>
      <tr
          v-for="field in fields"
          v-show="!field.hidden"
          :key="field"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white odd:bg-gray-50"
      >
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap w-48">
          {{ field.title }}
        </th>
        <td class="px-6 py-4">
          <InputField
              v-if="field.type === 'string' || field.type === 'int'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />

          <TextField
              v-else-if="field.type === 'text'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />

          <HtmlField
              v-else-if="field.type === 'html'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />

          <SelectField
              v-else-if="field.type === 'select'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />

          <PointerField
              v-else-if="field.type === 'pointer'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />

          <DateField
              v-else-if="field.type === 'date'"
              :field="field"
              :value="values[field.name]"
              @set-value="setValue"
          />
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import InputField from "@/components/ui/fields/InputField.vue";
import TextField from "@/components/ui/fields/TextField.vue";
import HtmlField from "@/components/ui/fields/HtmlField.vue";
import SelectField from "@/components/ui/fields/SelectField.vue";
import PointerField from "@/components/ui/fields/PointerField.vue";
import DateField from "@/components/ui/fields/DateField.vue";

export default defineComponent({
  name: 'DefaultFieldsTable',
  components: {DateField, PointerField, SelectField, HtmlField, TextField, InputField},
  props: {
    fields: Object,
    values: Object
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const setValue = (fieldName, fieldValue) => {
      emit('set-value', fieldName, fieldValue)
    }

    return {
      setValue
    }
  }
})
</script>

<style scoped>

</style>