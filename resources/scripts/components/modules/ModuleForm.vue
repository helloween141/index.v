<template>
  <div class="relative overflow-x-auto">
    <!--<span class="text-white">{{values}}</span>-->
    <form @submit.prevent="handleSave">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <tbody>
        <tr
            v-for="field in fields"
            v-show="!field.hidden"
            :key="field"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white odd:bg-gray-50"
        >
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap w-1/6">
            {{ field.title }}
          </th>
          <td class="px-6 py-4 w-1/2">
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

            <DateTimeField
                v-else-if="field.type === 'datetime'"
                :field="field"
                :value="values[field.name]"
                @set-value="setValue"
            />
          </td>
        </tr>
        </tbody>
      </table>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-5 mt-5">
        Сохранить
      </button>
    </form>
  </div>
</template>

<script lang="ts">
import InputField from "@/components/ui/fields/InputField.vue";
import TextField from "@/components/ui/fields/TextField.vue";
import SelectField from "@/components/ui/fields/SelectField.vue";
import PointerField from "@/components/ui/fields/PointerField.vue";
import DateTimeField from "@/components/ui/fields/DateTimeField.vue";

export default {
  name: "ModuleForm",
  components: {DateTimeField, PointerField, SelectField, TextField, InputField},
  props: {
    incFields: Object,
    incValues: Object
  },
  data() {
    return {
      fields: this.incFields,
      values: this.incValues
    }
  },
  methods: {
    async handleSave() {
      const formData = new FormData()

      Object.keys(this.values).forEach(key => {
        let item = this.values[key]
        if (item) {
          if (typeof item === 'object' && item.id) {
            formData.append(key, item.id)
          } else {
            formData.append(key, item)
          }
        }
      })
      this.$emit('save-form-data', formData)
    },
    setValue(fieldName, fieldValue) {
      console.log(fieldValue)
      this.values[fieldName] = fieldValue
    },
  }
}
</script>

<style scoped>

</style>