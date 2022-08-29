<template>
  <input type="number"
         @input="onInputFrom($event.target.value)"
         :value="valueFrom"
         class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
  />
</template>

<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'NumberFilterField',
  emits: ['set-filter'],
  props: {
    field: Object,
    valueFrom: String,
    valueTo: String,
  },
  setup(props, {emit}) {
    const onInputFrom = (val) => {
      emit('set-filter', {
        'from': {
          'name': props.field.name,
          'comparsion': '>=',
          'value': val,
          'type': props.field.type
        }
      })
    }

    const onInputTo = (val) => {
      emit('set-filter', {
        'to': {
          'name': props.field.name,
          'comparsion': '<=',
          'value': val,
          'type': props.field.type
        }
      })
    }

    return {
      onInputFrom,
      onInputTo
    }
  }
})
</script>

<style scoped>

</style>
