<template>
  <div>
    <span class="dark:text-white mb-3">{{ field.title }}</span>
    <div class="flex">
      <DateFilterField
          :placeholder="'От'"
          :value="value"
      />
      <DateFilterField
          :placeholder="'До'"
          :value="value"
      />
    </div>
  </div>
</template>

<script>
import {defineComponent, ref} from "vue";
import DateFilterField from "@/components/ui/filters/DateFilterField.vue";
export default defineComponent({
  name: 'DateRangeFilterField',
  components: {DateFilterField},
  emits: ['set-filter'],
  props: {
    field: Object,
    value: String,
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
