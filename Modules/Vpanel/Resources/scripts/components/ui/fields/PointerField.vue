<template>
  <v-select
      v-model="selectedOption"
      :label="identifyLabel"
      :options="options"
      :required="field.required"
      @search="fetchData"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 custom-fx"
  />
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import axios from "axios";
import {$vfm} from "vue-final-modal";
import VModal from "@/components/ui/modal/VModal.vue";
import DefaultModelEditor from "@/components/editors/DefaultModelEditor.vue";

export default defineComponent({
  name: 'PointerField',
  props: {
    field: Object,
    value: [Number, Object]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const options = ref([])
    const identifyLabel = ref(props.field.identify || 'name')
    const selectedOption = ref({})
    let incValues = []

    onMounted(async () => {
      const listResponse = await axios.get(`/api/vpanel/pointer`, {
        params: {
          'model': props.field.model
        }
      })
      incValues = listResponse.data

      if (!props.field.isModal) {
        options.value = listResponse.data
      }

      if (options.value) {
        const currentOption = (options.value.find(option => option.id === props.value))
        if (currentOption) {
          selectedOption.value = currentOption[identifyLabel.value]
        }
      }
    })

    // TODO: autocomplete
    const fetchData = (search, loading) => {
    }

    const handleInput = () => {
      emit('set-value', props.field.name, selectedOption.value)
    }

    return {
      options,
      identifyLabel,
      selectedOption,
      handleInput,
      fetchData
    }
  }
})
</script>

<style scoped>
.custom-fx {
  font-size: 1rem;
  padding: 0.2rem 0.2rem;
}
</style>
