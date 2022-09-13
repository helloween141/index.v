<template>
  <v-select
      v-model="selectedOption"
      :label="identifyLabel"
      @open="handleClick"
      class="py-2 bg-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500 custom-fx"
  >
    <template #search="{attributes, events}">
      <input
          class="vs__search"
          :required="field.required && !selectedOption"
          v-bind="attributes"
          v-on="events"
      />
    </template>
  </v-select>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref, watch} from "vue";
import {$vfm} from "vue-final-modal";
import VModal from "@/components/ui/modal/VModal.vue";
import DefaultModelEditor from "@/components/editors/DefaultModelEditor.vue";
import axios from "axios";
import {parsePointerModelPath} from "@/utils/utils";
import {loadInterface, loadList} from "@/api/actionEditor";

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
    let model = null
    let values = null

    onMounted(async () => {
      const pointerPath = parsePointerModelPath(props.field.model)
      model = await loadInterface(pointerPath.module, pointerPath.model)
      values = await loadList(pointerPath.module, pointerPath.model, true)

      selectedOption.value = values.data.find(item => item.id === props.value['id'])
    })

    const handleClick = () => {
      $vfm.show({
        component: VModal,
        slots: {
          content: {
            component: DefaultModelEditor,
            bind: {
              incModel: model,
              incValues: values,
              isModal: true
            },
            on: {
              selectRecord(recordId) {
                if (values) {
                  selectedOption.value = values.data.find(item => item.id === recordId)
                  emit('set-value', props.field.name, selectedOption.value)
                  $vfm.hideAll()
                }
              }
            }
          }
        }
      })
    }

    watch(() => selectedOption.value, (current, previous) => {
      if (!current) {
        emit('set-value', props.field.name, selectedOption.value)
      }
    })

    return {
      identifyLabel,
      selectedOption,
      handleClick
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
