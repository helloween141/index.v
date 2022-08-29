<template>
  <div class="flex justify-between">
    <NumberFilterField />
  </div>
</template>

<script>
import {defineComponent, ref} from "vue";
import DateFilterField from "@/components/ui/filters/DateFilterField.vue";
import NumberFilterField from "./NumberFilterField.vue";
export default defineComponent({
  name: 'NumberRangeFilterField',
  components: {NumberFilterField, DateFilterField},
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
