<template>
  <v-select
      v-model="currentValue"
      :label="identifyLabel"
      :options="field.values"
      :required="field.required"
      :searchable="false"
      :clearable="false"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 font-medium"
  />
</template>


<script>
import {defineComponent, onMounted, ref} from "vue";

export default defineComponent({
  name: 'SelectField',
  props: {
    field: Object,
    value: [String, Number]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const currentValue = ref({})
    const identifyLabel = ref(props.field.identify || 'name')

    onMounted(() => {
      if (!props.value) {
        currentValue.value = props.field.values.find(val => val.default) || props.field.values[0]
      } else {
        currentValue.value = (typeof props.value === 'object') ? props.value : props.field.values.find(val => val.id === props.value)
      }
      this.handleInput(currentValue.value)
    })

    const handleInput = () => {
      emit('set-value', props.field.name, currentValue.value)
    }

    return {
      currentValue,
      identifyLabel,
      handleInput
    }
  }
})
</script>

<style scoped>

</style>