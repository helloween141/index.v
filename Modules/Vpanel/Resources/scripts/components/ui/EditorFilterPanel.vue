<template>
  <div class="mb-5 p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    {{values}}
    <div v-for="(field, index) in fields"
         :key="index"
         class="mb-3"
    >
      <StringFilterField
          v-if="field.type === 'string' || field.type === 'pointer' || field.type === 'select'"
          :field="field"
          v-model:value="values[field.name]"
          @set-filter="setFilter"
      />

      <DateRangeFilterField
          v-if="field.type === 'date'"
          :field="field"
          v-model:value="values[field.name]"
          @set-filter="setFilter"
      />

      <NumberFilterField
          v-if="field.type === 'int' || field.type === 'float'"
          :field="field"
          v-model:value="values[field.name]"
          @set-filter="setFilter"
      />

      <BoolFilterField
          v-if="field.type === 'bool'"
          :field="field"
          v-model:value="values[field.name]"
          @set-filter="setFilter"
      />
    </div>

    <div class="flex justify-end">
      <button
          @click="onResetFilter"
          class="bg-red-500 hover:bg-red-700 text-gray-800 font-bold py-2 px-4 rounded">
        <span class="text-white">Сбросить</span>
      </button>

      <button
          @click="onApplyFilter"
          class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
        <span class="text-white">Применить</span>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import StringFilterField from "@/components/ui/filters/StringFilterField.vue";
import DateRangeFilterField from "@/components/ui/filters/DateRangeFilterField.vue";
import NumberFilterField from "@/components/ui/filters/NumberFilterField.vue";
import BoolFilterField from "@/components/ui/filters/BoolFilterField.vue";

export default defineComponent({
  name: 'EditorFilterPanel',
  components: {BoolFilterField, NumberFilterField, DateRangeFilterField, StringFilterField},
  props: {
    fields: Object
  },
  emits: ['on-filter'],
  setup(props, {emit}) {
    let filter = {}
    let values = ref({})

    const setFilter = (fieldFilter, fieldName) => {
      values.value[fieldName] = fieldFilter[fieldName]

      filter = {...filter, ...fieldFilter}
    }

    const onApplyFilter = () => {
      emit('on-filter', filter)
    }

    const onResetFilter = () => {
      filter = {}
      values.value = {}
    }

    return {
      filter,
      values,
      onApplyFilter,
      onResetFilter,
      setFilter
    }
  }
})
</script>
