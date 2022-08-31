<template>
  <div>
    <span class="dark:text-white">{{ field.title }}</span>
    <div class="flex">
      <DateFilterField
          :placeholder="'От'"
          :type="'from'"
          :value="(value && value[0]) ? value[0].value : ''"
          @set-value="onInput"
          class="mr-3"
      />
      <DateFilterField
          :placeholder="'До'"
          :type="'to'"
          :value="(value && value[1]) ? value[1].value : ''"
          @set-value="onInput"
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
    value: [Array, String],
  },
  setup(props, {emit}) {
    let valFrom = ''
    let valTo = ''

    const onInput = (val, type) => {
      valFrom = type === 'from' ? val : valFrom
      valTo = type === 'to' ? val : valTo

      const result = []
      if (valFrom) {
        result.push({
          'comparsion': '>=',
          'value': valFrom
        })
      }

      if (valTo) {
        result.push({
          'comparsion': '<=',
          'value': valTo
        })
      }

      emit('set-filter', {[props.field.name]: result}, props.field.name)
    }

    return {
      onInput
    }
  }
})
</script>

<style scoped>

</style>
