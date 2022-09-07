<template>
  <v-select
      v-model="selectedOption"
      :options="options"
      :required="field.required"
      :searchable="true"
      :clearable="true"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 font-medium custom-fx"
  />
</template>


<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'SelectField',
  props: {
    field: Object,
    value: [String, Number]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const selectedOption = ref(props.field.options[props.value])
    const options = []

    for (const [key, value] of Object.entries(props.field.options)) {
      options.push({
        id: key,
        label: value
      })
    }

    const handleInput = () => {
      emit('set-value', props.field.name, selectedOption.value)
    }

    return {
      options,
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
