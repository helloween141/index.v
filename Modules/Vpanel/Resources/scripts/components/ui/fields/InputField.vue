<template>
  <input
      type="text"
      v-model="currentValue"
      :readonly="field.readonly"
      :required="field.required"
      @input="handleInput"
      class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
  />
</template>

<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'InputField',
  props: {
    field: Object,
    value: [String, Number]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const currentValue = ref(props.value || props.field.default)

    const handleInput = () => {
      emit('set-value', props.field.name, currentValue.value)
    }

    return {
      currentValue,
      handleInput
    }
  }
})
</script>

<style scoped>

</style>