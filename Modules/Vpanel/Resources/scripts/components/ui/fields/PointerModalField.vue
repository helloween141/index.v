<template>
  <v-select
      v-model="selectedOption"
      :clearable="!field.required"
      @click="handleClick"
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
import {parseModelPath} from "@/utils/utils";
import {loadInterface, loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'PointerModalField',
  props: {
    field: Object,
    value: Object
  },
  emits: ['set-value'],
  setup(props, {emit}) {
    let selectedOption = ref((props.value).value)
    const pointerPath = parseModelPath(props.field.model)

    let model = null
    let values = null

    onMounted(async () => {
      model = await loadInterface(pointerPath.module, pointerPath.model)
      values = await loadList(pointerPath.module, pointerPath.model, 1, [], '')
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
              incPathData: {
                module: pointerPath.module,
                model: pointerPath.model,
              },
              isModal: true
            },
            on: {
              selectRecord(record) {
                const identifyKey = Object.keys(record)[1] || ''
                selectedOption.value = record[identifyKey]

                emit('set-value', props.field.name, record)
                $vfm.hideAll()
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
