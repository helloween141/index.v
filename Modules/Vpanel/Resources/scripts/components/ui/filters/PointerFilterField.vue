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
import axios from "axios";
import {$vfm} from "vue-final-modal";
import VModal from "@/components/ui/modal/VModal.vue";
import DefaultModelEditor from "@/components/editors/DefaultModelEditor.vue";

export default defineComponent({
  name: 'PointerFilterField',
  props: {
    field: Object,
    value: [Number, Object]
  },
  emits: ['set-filter'],
  setup(props, {emit}) {
    const options = ref([])
    const identifyLabel = ref(props.field.identify || 'name')
    const currentValue = ref(null)

    onMounted(async () => {
      const listResponse = await axios.get(`/api/vpanel/pointer`, {
        params: {
          'model': props.field.model
        }
      })
      options.value = listResponse.data

      if (options.value) {
        const currentOption = (options.value.find(option => option.id === props.value))
        if (currentOption) {
          currentValue.value = currentOption[identifyLabel.value]
        }
      }
    })

    watch(() => props.value, (current, previous) => {
      if (!current) {
        currentValue.value = null
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
