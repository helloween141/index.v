<template>
  <div v-if="targetComponent">
    <component
        :is="targetComponent"
        :inc-model="modelInterface"
        :inc-values="modelValues"
    />
  </div>
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent, ref, shallowRef, watch} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";

export default defineComponent({
  name: 'ModuleView',
  setup() {
    const modelInterface = ref([])
    const modelValues = ref([])
    const targetComponent = shallowRef('')
    const route = useRoute()

    // TODO: Refactoring
    watch(route, async (to) => {
      const moduleName = (route.params.module).toString()
      const modelName = (route.params.model).toString()
      const recordId = route.params?.id || ''

      try {
        const interfaceResponse = await axios.get(`/api/vpanel/interface/${moduleName}/${modelName}`)
        const interfaceData = interfaceResponse.data
        modelInterface.value = interfaceData

        if (recordId) {
          const recordResponse = await axios.get(`/api/vpanel/record/${moduleName}/${modelName}/${recordId}`)
          modelValues.value = recordResponse.data
          targetComponent.value = loadFormComponent(interfaceData.formComponent, moduleName)
        } else {
          const listResponse = await axios.get(`/api/vpanel/list/${moduleName}/${modelName}`)
          modelValues.value = listResponse.data
          targetComponent.value = loadEditorComponent(interfaceData.editorComponent, moduleName)
        }

      } catch (error) {
        console.error(error)
      }
    }, {flush: 'pre', immediate: true, deep: true})

    const loadEditorComponent = (component: string, moduleName: string) => {
      if (component) {
        return defineAsyncComponent(() => import('../../../Modules/' + moduleName + '/Resources/scripts/components/' + component + '.vue'))
      }
      return defineAsyncComponent(() => import('../components/editors/DefaultModelEditor.vue'))
    }

    const loadFormComponent = (component: string, moduleName: string) => {
      if (component) {
        return defineAsyncComponent(() => import('../../../Modules/' + moduleName + '/Resources/scripts/components/' + component + '.vue'))
      }
      return defineAsyncComponent(() => import('../components/forms/DefaultModelForm.vue'))
    }

    return {
      targetComponent,
      modelInterface,
      modelValues,
    }
  }
})
</script>

<style scoped>
</style>
