<template>
  <div>
    <span class="dark:text-white mb-3">{{ field.title }}</span>
    <div class="flex">
      <DateFilterField
          :placeholder="'От'"
          :value="value"
          @set-value="onInputFrom"
      />
      <DateFilterField
          :placeholder="'До'"
          :value="value"
          @set-value="onInputTo"
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
      console.log(val)
      emit('set-filter', {
        'name': props.field.name,
        'comparsion': '>=',
        'value': val,
        'type': props.field.type
      })
    }

    const onInputTo = (val) => {
      emit('set-filter', {
        'name': props.field.name,
        'comparsion': '<=',
        'value': val,
        'type': props.field.type
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
