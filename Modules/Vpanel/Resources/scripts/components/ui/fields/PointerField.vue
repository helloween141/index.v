<template>
  <v-select
      v-model="selectedOption"
      :label="identifyLabel"
      :options="options"
      :clearable="!field.required"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 custom-fx"
  >
    <template #search="{attributes, events}">
      <input
          class="vs__search"
          :required="field.required && !selectedOption"
          v-bind="attributes"
          v-on="events"
      />
    </template>
  </v-select>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import {parsePointerModelPath} from "@/utils/utils";
import {loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'PointerField',
  props: {
    field: Object,
    value: [Number, Object]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const options = ref([])
    const identifyLabel = ref(props.field.identify || 'name')
    const selectedOption = ref()

    onMounted(async () => {
      const pointerPath = parsePointerModelPath(props.field.model)
      options.value = await loadList(pointerPath.module, pointerPath.model)

      if (options.value.length > 0) {
        const currentOption = (options.value.find(option => option.id === props.value['id']))
        if (currentOption) {
          selectedOption.value = currentOption[identifyLabel.value]
        }
      }
    })

    const handleInput = () => {
      emit('set-value', props.field.name, selectedOption.value)
    }

    return {
      options,
      identifyLabel,
      selectedOption,
      handleInput,
      fetchData
    }
  }
})
</script>

<style scoped>
.custom-fx {
  font-size: 1rem;
  padding: 0.17rem 0.17rem;
}
</style>
