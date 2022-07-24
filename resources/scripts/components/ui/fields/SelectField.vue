<template>
  <v-select
      v-model="currentValue"
      :label="identifyLabel"
      :options="field.values"
      :required="field.required"
      :searchable="false"
      :clearable="false"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 font-medium"
  />
</template>

<script>
export default {
  name: 'SelectField',
  props: {
    field: Object,
    value: ''
  },
  data() {
    return {
      currentValue: {},
      identifyLabel: this.field.identify || 'name'
    }
  },
  created() {
    if (!this.value) {
      this.currentValue = this.field.values.find(val => val.default) || this.field.values[0]
    } else {
      this.currentValue = (typeof this.value === 'object') ? this.value : this.field.values.find(val => val.id === this.value)
    }

    this.handleInput(this.currentValue)
  },
  methods: {
    handleInput(value) {
      this.$emit('set-value', this.field.name, value)
    }
  }
}
</script>

<style scoped>

</style>