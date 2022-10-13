<template>
  <input
      type="password"
      v-model="currentValue"
      @input="handleInput"
      required
      placeholder="Новый пароль"
      class="mb-5 bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
  />

  <input
      type="password"
      @input="handleInput"
      v-model="repeatValue"
      required
      placeholder="Подтвердите пароль"
      class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
  />
</template>

<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'PasswordField',
  props: {
    field: Object,
    value: String
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const currentValue = ref(props.value || props.field.default)
    const repeatValue = ref()

    const handleInput = () => {
      if (currentValue.value === repeatValue.value) {
        emit('set-value', props.field.name, currentValue.value)
      } else {
        emit('set-value', props.field.name, '')
      }
    }

    return {
      currentValue,
      repeatValue,
      handleInput
    }
  }
})
</script>

<style scoped>

</style>
