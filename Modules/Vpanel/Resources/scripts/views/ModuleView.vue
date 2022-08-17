<template>
  <div v-if="targetComponent">
    <component
        :is="targetComponent"
        :inc-model="modelInterface"
    />
  </div>
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent, ref, shallowRef, watch} from "vue";
import {useRoute} from "vue-router";
import {loadInterface} from "@/api/actionEditor";
import {getRouteParameters} from "@/utils/utils";

export default defineComponent({
  name: 'ModuleView',
  setup() {
    const modelInterface = ref({})
    const targetComponent = shallowRef('')
    const route = useRoute()

    watch(route, async (to) => {
      const {moduleName, modelName, recordId} = getRouteParameters(route)

      if (moduleName && modelName) {
        modelInterface.value = await loadInterface(moduleName, modelName)

        if (recordId) {
          const formComponent = modelInterface.value['formComponent']
          targetComponent.value = formComponent ? loadCustomComponent(formComponent, moduleName) : loadFormComponent()
        } else {
          const editorComponent = modelInterface.value['editorComponent']
          targetComponent.value = editorComponent ? loadCustomComponent(editorComponent, moduleName) : loadEditorComponent()
        }
      }
    }, {flush: 'pre', immediate: true, deep: true})

    const loadCustomComponent = (component: string, moduleName: string) => {
      return defineAsyncComponent(() => import('/Modules/' + moduleName + '/Resources/scripts/components/' + component + '.vue'))
    }

    const loadEditorComponent = () => {
      return defineAsyncComponent(() => import('../components/editors/DefaultModelEditor.vue'))
    }

    const loadFormComponent = () => {
      return defineAsyncComponent(() => import('../components/forms/DefaultModelForm.vue'))
    }

    return {
      targetComponent,
      modelInterface
    }
  }
})
</script>

<style scoped>
</style>
