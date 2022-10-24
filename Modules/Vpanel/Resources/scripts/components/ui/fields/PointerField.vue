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
import {parseModelPath} from "@/utils/utils";
import {loadInterface, loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'PointerField',
  props: {
    field: Object,
    value: Object
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const identifyLabel = ref()
    const options = ref([])
    const selectedOption = ref(props.value)

    onMounted(async () => {
      const pointerPath = parseModelPath(props.field.model)
      const pointerModel = await loadInterface(pointerPath.module, pointerPath.model)
      options.value = await loadList(pointerPath.module, pointerPath.model)

      const identifyField = pointerModel.fields.find(field => field.identify)
      if (identifyField) {
        identifyLabel.value = identifyField['name']
      }
    })

    const handleInput = () => {
      emit('set-value', props.field.name, selectedOption.value)
    }

    return {
      options,
      identifyLabel,
      selectedOption,
      handleInput
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
