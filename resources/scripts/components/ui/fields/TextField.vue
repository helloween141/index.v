<template>
  <textarea
      rows="5"
      v-model="currentValue"
      :required="field.required"
      @input="handleInput"
      class="bg-gray-200 appearance-none border-gray-200 rounded w-full text-gray-700 leading-tight font-medium focus:outline-none focus:bg-white focus:border-purple-500"
  >
    {{value}}
  </textarea>
</template>

<script>
export default {
  name: 'TextField',
  props: {
    field: Object,
    value: ''
  },
  data() {
    return {
      currentValue: this.value || this.field.default
    }
  },
  methods: {
    handleInput() {
      this.$emit('set-value', this.field.name, this.currentValue)
    }
  }
}
</script>

<style scoped>

</style>