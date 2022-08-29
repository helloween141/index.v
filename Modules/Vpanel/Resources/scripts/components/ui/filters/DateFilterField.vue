<template>
  <Datepicker
      :value="value"
      :format="'dd.MM.yyyy HH:mm'"
      @update:modelValue="handleInput"
      :placeholder="placeholder"
      locale="ru"
      autoApply
      inputClassName="appearance-none bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
  />
</template>

<script>
import {defineComponent, ref} from "vue";
import moment from "moment";

export default defineComponent({
  name: 'DateFilterField',
  emits: ['set-value'],
  props: {
    field: Object,
    placeholder: String,
    value: String
  },
  setup(props, {emit}) {
    const handleInput = (val) => {
      val = moment(val).format('YYYY-MM-DD HH:mm')
      emit('set-value', val)
    }

    return {
      handleInput
    }
  }
})
</script>

<style scoped>

</style>
