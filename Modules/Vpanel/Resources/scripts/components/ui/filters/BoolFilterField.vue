<template>
  <div class="flex items-center mb-3">
    <span class="dark:text-white">{{ field.title }}</span>
    <input type="checkbox"
           :value="value"
           @click="onClick($event.target.value)"
           class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
    />
  </div>

</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
  name: 'BoolFilterField',
  emits: ['set-filter'],
  props: {
    value: Boolean,
    field: Object,
  },
  setup(props, {emit}) {
    const onClick = (val) => {
      emit('set-filter', {
        'name': props.field.name,
        'comparsion': '=',
        'value': val,
        'type': props.field.type
      })
    }

    return {
      onClick
    }
  }
})
</script>

<style scoped>

</style>
