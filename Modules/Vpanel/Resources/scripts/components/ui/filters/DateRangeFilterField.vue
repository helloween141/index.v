<template>
  <div>
    <span class="dark:text-white">{{ field.title }}</span>
    <div class="flex">
      <DateFilterField
          :placeholder="'От'"
          :type="'from'"
          :value="valueFrom"
          @set-value="onInput"
          class="mr-3"
      />
      <DateFilterField
          :placeholder="'До'"
          :type="'to'"
          :value="valueTo"
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
    value: String,
  },
  setup(props, {emit}) {
    const valueFrom = ref(props.value)
    const valueTo = ref(props.value)

    const onInput = (val, type) => {
      emit('set-filter', {
        'name': props.field.name,
        'comparsion': type === 'from' ? '>=' : '<=',
        'value': val,
        'type': props.field.type
      })
    }

    return {
      valueFrom,
      valueTo,
      onInput
    }
  }
})
</script>

<style scoped>

</style>
