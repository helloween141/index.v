<template>
  <QuillEditor v-model:content="currentValue"
               theme="snow"
               toolbar="essential"
               content-type="html"
               @textChange="handleInput"
  />
</template>

<script>
import {defineComponent, ref} from "vue";
import {QuillEditor} from "@vueup/vue-quill";

export default defineComponent({
  name: 'HtmlField',
  components: {QuillEditor},
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