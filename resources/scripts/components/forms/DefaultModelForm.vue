<template>
  <FormActionPanel :model="model" />

  <div class="relative overflow-x-auto" >
    <span class="text-white">{{values}}</span>
    <form @submit.prevent="onSave">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <tbody>
        <tr
            v-for="field in model.fields"
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

    </form>
  </div>
</template>

<script lang="ts">
import InputField from "@/components/ui/fields/InputField.vue";
import TextField from "@/components/ui/fields/TextField.vue";
import SelectField from "@/components/ui/fields/SelectField.vue";
import PointerField from "@/components/ui/fields/PointerField.vue";
import DateField from "@/components/ui/fields/DateField.vue";
import {defineComponent} from "vue";
import FormActionPanel from "@/components/ui/FormActionPanel.vue";

export default defineComponent({
  name: 'ModuleForm',
  components: {FormActionPanel, TextField, DateField, PointerField, SelectField, InputField},
  props: {
    model: Object,
    values: Object
  },
  setup(props, {emit}) {

    const onSave = () => {
      const formData = new FormData()

      Object.keys(props.values).forEach(key => {
        let item = props.values[key]
        if (item) {
          if (typeof item === 'object' && item.id) {
            formData.append(key, item.id)
          } else {
            formData.append(key, item)
          }
        }
      })
      emit('save-form-data', formData)
    }
    const setValue = (fieldName, fieldValue) => {
      props.values[fieldName] = fieldValue
    }

    return {
      onSave,
      setValue
    }
  }
})
</script>

<style scoped>

</style>