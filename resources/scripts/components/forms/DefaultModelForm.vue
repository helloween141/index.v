<template>
  <FormActionPanel
      :model="model"
      @on-save="onSave"
  />

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
import {defineComponent, ref} from "vue";
import FormActionPanel from "@/components/ui/FormActionPanel.vue";
import axios from "axios";
import {useToast} from "vue-toastification";
import {useRoute} from "vue-router";
import router from "@/router";

export default defineComponent({
  name: 'ModuleForm',
  components: {FormActionPanel, TextField, DateField, PointerField, SelectField, InputField},
  props: {
    incModel: Object,
    incValues: Object
  },
  setup(props, {emit}) {
    const model = ref({})
    const values = ref({})

    model.value = props.incModel
    values.value = props.incValues

    const toast = useToast()
    const route = useRoute()

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

      const moduleName = route.params.module
      const modelName = route.params.model

      try {
        const response = await axios.post(`/api/vpanel/${moduleName}/${modelName}/save`, formData)
        const id = response.data?.id || 0
        if (id) {
          toast.success("Данные сохранены!", {
            timeout: 3000
          });

          //await router.push({ name: 'module', params: { id } })

        } else {
          toast.error("Ошибка сохранения данных!", {
            timeout: 3000
          });
        }
      } catch (error) {
        console.error(error)
      }
    }

    const setValue = (fieldName, fieldValue) => {
      values.value[fieldName] = fieldValue
    }

    return {
      onSave,
      setValue,
      model,
      values
    }
  }
})
</script>

<style scoped>

</style>