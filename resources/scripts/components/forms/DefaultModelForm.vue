<template>
  <div class="relative overflow-x-auto" >
    <span class="text-white">{{values}}</span>
    <form @submit.prevent="onSave">
      <FormActionPanel
          :model="model"
          @on-save="onSave"
          @on-delete="onDelete"
          @on-back="onBack"
      />
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
import {defineComponent, ref} from "vue";
import FormActionPanel from "@/components/ui/FormActionPanel.vue";
import {useRoute} from "vue-router";
import router from "@/router";
import {saveRecord, deleteRecord} from "@/api/actionForm";

export default defineComponent({
  name: 'ModuleForm',
  components: {FormActionPanel, TextField, DateField, PointerField, SelectField, InputField},
  props: {
    incModel: Object,
    incValues: Object
  },
  setup(props, {emit}) {
    const route = useRoute()
    const model = ref(props.incModel || {})
    const values = ref(props.incValues || {})

    const moduleName = route.params.module.toString()
    const modelName = route.params.model.toString()

    const prepareFormData = () => {
      const data = new FormData()
      Object.keys(values.value).forEach(key => {
        let item = values.value[key]
        if (item) {
          if (typeof item === 'object' && item.id) {
            data.append(key, item.id)
          } else {
            data.append(key, item)
          }
        }
      })
      return data
    }

    const onSave = async () => {
      const formData = prepareFormData()
      await saveRecord(moduleName, modelName, formData)
    }

    const onDelete = async () => {
      const id = model.value.id || 0
      await deleteRecord(moduleName, modelName, id)
    }

    const onBack = () => {
      router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
    }

    const setValue = (fieldName, fieldValue) => {
      values.value[fieldName] = fieldValue
    }

    return {
      onSave,
      onDelete,
      onBack,
      setValue,
      model,
      values
    }
  }
})
</script>

<style scoped>

</style>