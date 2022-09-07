<template>
  <v-select
      v-model="selectedOption"
      :label="identifyLabel"
      :required="field.required"
      @click="handleClick"
      @update:modelValue="handleInput"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 custom-fx"
  />
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import {$vfm} from "vue-final-modal";
import VModal from "@/components/ui/modal/VModal.vue";
import DefaultModelEditor from "@/components/editors/DefaultModelEditor.vue";

export default defineComponent({
  name: 'PointerModalField',
  props: {
    field: Object,
    value: [Number, Object]
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    const identifyLabel = ref(props.field.identify || 'name')
    const selectedOption = ref({})

    const handleClick = () => {
      $vfm.show({
        component: VModal,
        on: {
          confirm(close) {
            close()
          },
        },
        slots: {
          content: {
            component: DefaultModelEditor,
            bind: {
              incModel: {},
              customModuleName: '',
              customModelName: ''
            }
          }
        }
      })
    }

    const handleInput = () => {
      emit('set-value', props.field.name, selectedOption.value)
    }

    return {
      identifyLabel,
      selectedOption,
      handleInput,
      handleClick
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
