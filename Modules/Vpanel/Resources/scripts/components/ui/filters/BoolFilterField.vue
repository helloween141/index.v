<template>
  <div class="flex items-center mb-3">
    <span class="dark:text-white">{{ field.title }}</span>
    <input type="checkbox"
           :value="value"
           @change="onChange(value)"
           class="w-4 h-4 ml-3 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
    />
  </div>

</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
  name: 'BoolFilterField',
  emits: ['set-filter'],
  props: {
    value: {
      type: Boolean,
      default: 0
    },
    field: Object,
  },
  setup(props, {emit}) {
    const onChange = (val) => {
      emit('set-filter', {[props.field.name]: (val ? 0 : 1)}, props.field.name)
    }

    return {
      onChange
    }
  }
})
</script>

<style scoped>

</style>
