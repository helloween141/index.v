<template>
  <div>
    <span class="dark:text-white mb-3">{{ field.title }}</span>
    <v-select
        v-model="currentValue"
        :label="identifyLabel"
        :options="options"
        @update:modelValue="handleInput"
        class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 custom-fx"
        multiple
        push-tags
    />
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref, watch} from "vue";
import {parseModelPath} from "@/utils/utils";
import {loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'PointerFilterField',
  props: {
    field: Object,
    value: Array
  },
  emits: ['set-filter'],
  setup(props, {emit}) {
    const options = ref([])
    const identifyLabel = ref(props.field.identify || 'name')
    const currentValue = ref([])

    onMounted(async () => {
      const pointerPath = parseModelPath(props.field.model)
      options.value = await loadList(pointerPath.module, pointerPath.model)

      if (options.value.length > 0 && Array.isArray(props.value)) {
        options.value.forEach(option => {
          if (props.value.includes(option.id)) {
            currentValue.value.push({
              id: option.id,
              name: option.name
            })
          }
        })
      }
    })

    watch(() => props.value, (current, previous) => {
      if (!current) {
        currentValue.value = []
      }
    })

    const handleInput = () => {
      const result = currentValue.value.map(item => item.id)
      emit('set-filter', {[props.field.name]: result}, props.field.name)
    }

    return {
      options,
      identifyLabel,
      currentValue,
      handleInput
    }
  }
})
</script>

<style scoped>
  .custom-fx {
    font-size: 1rem;
    padding: 0.17rem 0.17rem;
  }
</style>
